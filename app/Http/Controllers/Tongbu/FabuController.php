<?php

namespace App\Http\Controllers\Tongbu;

use App\Http\Controllers\Controller;
use App\Models\Admin\KeyTemp;
use App\Models\Admin\Product;
use App\Models\Admin\ProductTemp;
use App\Models\Admin\TitleKey;
use Illuminate\Http\Request;
use Session, Response, DB;
use Log;

/**
 * create by:haohaisheng
 * Class UserController
 * date  2016/7/25
 * @package App\Http\Controllers\Tongbu
 */
class FabuController extends Controller
{
    protected $token;
    protected $userid;

    public function __construct()
    {
        $this->token = get_token(Session::get('login_alibaba'));
        $this->userid = Session::get('login_alibaba');
    }

    /**
     * @return Response
     *
     */
    public function index($productId)
    {
        return view('tongbu/fabu_count')->with('productid', $productId);
    }

    public function fabuDetail()
    {
        $curr_action = $_SERVER['REQUEST_URI'];
        return view('tongbu/fabu_detail');
    }

    public function getKeyList()
    {
        $tkey = new TitleKey();
        $keys = $tkey->getTitleKeyList();
        if (count($keys) > 0) {
            $fkeys = array();
            foreach ($keys as $key => $val) {
                if ($val->title_pid == 0) {
                    $fkeys[$key]['id'] = $val->id;
                    $fkeys[$key]['title_key'] = $val->title_key;
                    $fkeys[$key]['title_pid'] = $val->title_pid;
                    $childrens = $tkey->getTitleKeyListByfid($val->id);
                    $fkeys[$key]['childrens'] = $childrens;
                }
            }
            return json_encode(array_values($fkeys));
        }
        return array();
    }

    //获取标题词语
    public function getFkeys($fid)
    {
        $key = new TitleKey();
        if ($fid == 0) {
            $keys = $key->getFkeys('all', $this->userid);
        } else {
            $keys = $key->getChildrens($fid);
        }
        return json_encode($keys);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 添加标题词语
     */
    public function saveKeys(Request $request)
    {
        $key = $request->has('key') ? $request->input('key') : '';
        $fid = $request->has('fid') ? $request->input('fid') : '';
        $k = new TitleKey();
        $k->title_key = $key;
        $k->title_pid = $fid;
        $k->userid = $this->userid;
        $flag = $k->save();
        return response()->json(array(
            'code' => $flag
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 更新标题词语
     */
    public function editKey(Request $request)
    {
        $key = $request->has('key') ? $request->input('key') : '';
        $id = $request->has('id') ? $request->input('id') : '';
        $keys = TitleKey::find($id);
        $keys->title_key = $key;
        $flag = $keys->save();
        return response()->json(array(
            'code' => $flag
        ));
    }

    public function delKey(Request $request)
    {
        $id = $request->has('id') ? $request->input('id') : '';
        $flag = TitleKey::destroy($id);
        return response()->json(array(
            'code' => $flag
        ));
    }

    /**
     * @return mixed|string
     * 获取标题生成格式
     */
    public function getTitleFormat()
    {
        $key = new TitleKey();
        $data = $key->getTitleFormat();
        return json_encode($data);
    }

    /**
     * @param $status
     * @return mixed|string
     * 获取关键词
     */
    public function getKeys($status)
    {
        $key = new TitleKey();
        $data = $key->getFkeys($status, $this->userid);
        return json_encode($data);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     * 获取复制产品列表
     */
    public function getTempProductList(Request $request)
    {
        $page = $request->has('page') ? $request->input('page') : 1;
        $status = $request->has('status') ? $request->input('status') : 1;
        $num = 300;
        $temp = new ProductTemp();
        $temps = $temp->getProductTempList($num, $status, $this->userid);
        if (count($temps) > 0) {
            return $temps;
        }
        return array();
    }

    public function saveTempKeys(Request $request)
    {
        $fid = $request->has('fid') ? $request->input('fid') : '';
        $ids = $request->has('ids') ? $request->input('ids') : '';
        $ftype = $request->has('ftype') ? $request->input('ftype') : '';
        $k = new TitleKey();
        $keytemp = new KeyTemp();
        $key = $k->getKeyById($fid);
        $fid = $key[0]->id;
        $fname = $key[0]->title_key;
        if (strpos($ids, ',')) {
            $arr = explode(',', $ids);
            foreach ($arr as $val) {
                $keytemp->deleteKeyTemp($fid, $val);
                $key = $k->getKeyById($val);
                $child_id = $key[0]->id;
                $child_name = $key[0]->title_key;
                $keytemp->key_cateid = $fid;
                $keytemp->key_cate = $fname;
                $keytemp->key_name = $child_name;
                $keytemp->key_id = $child_id;
                $keytemp->status = $ftype;
                $keytemp->userid = $this->userid;
                $keytemp->save();
            }
        } else {
            $keytemp->deleteKeyTemp($fid, intval($ids));
            $key = $k->getKeyById($ids);
            $child_id = $key[0]->id;
            $child_name = $key[0]->title_key;
            $keytemp->key_cateid = $fid;
            $keytemp->key_cate = $fname;
            $keytemp->key_name = $child_name;
            $keytemp->key_id = $child_id;
            $keytemp->status = $ftype;
            $keytemp->userid = $this->userid;
            $keytemp->save();
        }
    }

    public function delTempKey(Request $request)
    {
        $fid = $request->has('fid') ? $request->input('fid') : '';
        $ids = $request->has('ids') ? $request->input('ids') : '';
        $keytemp = new KeyTemp();
        $keytemp->deleteKeyTemp($fid, intval($ids));
    }

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     * 高级设置
     */
    public function advancedSeting(Request $request)
    {
        $keytemp = new KeyTemp();
        $sets = $keytemp->advancedsetInfo($this->userid);
        return view('tongbu/advanced_seting')->with('sets', $sets);
    }


    /**
     * @param Request $request
     * @return string
     * 关键词信息
     */
    public function advancedSetingInfo(Request $request)
    {
        $keytemp = new KeyTemp();
        $sets = $keytemp->advancedsetInfo($this->userid);
        return json_encode($sets[0]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 关键词设置保存
     */
    public function advancedSet(Request $request)
    {
        $id = $request->has('id') ? $request->input('id') : '';
        $match_set = $request->has('match_set') ? $request->input('match_set') : '';
        $match_model = $request->has('match_model') ? $request->input('match_model') : '';
        $match_key = $request->has('match_key') ? $request->input('match_key') : '';

        $param['id'] = $id;
        $param['matching_set'] = $match_set;
        $param['matching_model'] = $match_model;
        $param['matching_key'] = $match_key;
        $keytemp = new KeyTemp();
        $flag = $keytemp->updateAdvancedset($param, $this->userid);
        return response()->json(array(
            'code' => $flag
        ));
    }

    /**
     * @param $cateId
     * @return \Illuminate\Http\JsonResponse
     * 自动生成关键词
     */
    public function keyGenerate($cateId)
    {
        $keytemp = new KeyTemp();
        $keys = $keytemp->getKeyTemp($cateId, $this->userid);
        if (empty($keys)) {
            return response()->json(array(
                'code' => 100
            ));
        }
        $products = $keytemp->getTempProductList($this->userid);
        $sets = $keytemp->advancedsetInfo($this->userid);
        if (empty($sets) || $sets[0]->matching_key == '') {
            return response()->json(array(
                'code' => '102'
            ));
        }
        $key_arr = array();
        foreach ($keys as $val) {
            $key_arr[] = $val->key_name;
        }
        $len = substr_count($sets[0]->matching_key, ',') + 1;
        if (count($key_arr) < $len) {
            $key_arr = $this->jisuan($key_arr, $sets[0]);
        }
        $i = 0;
        $length = count($key_arr);
        foreach ($products as $val) {
            $key_param = array();
            if ($sets[0]->matching_set == 1) {//1是顺序匹配，2为随机匹配
                //数组重复循环顺序取值
                $num = ($i * $len) % $length;
                $i++;
                for ($j = 0; $j < $len; $j++) {
                    $x = ($num + $j) % $length;
                    $key_param[] = $key_arr[$x];
                }
            } else {
                //从数组中随机取值
                $key_param = array_rand($key_arr, $len);
            }
            $keytemp->updateTempProduct($val->id, $key_param, $sets[0]->matching_key);
        }
        return response()->json(array(
            'code' => '101'
        ));
    }

    public function jisuan($keyarr, $sets)
    {
        $count = count($keyarr);
        $len = substr_count($sets->matching_key, ',') + 1;
        if ($count == $len || $count > $len) {
            return $keyarr;
        } else {
            $arr = array();
            $l = $len - $count;
            if ($l > $count) {
                foreach ($keyarr as $val) {
                    array_push($keyarr, $val);
                }
                $arr = $this->jisuan($keyarr, $sets);
            } else {
                $cha_arr = array_slice($keyarr, 0, $l);
                foreach ($cha_arr as $val) {
                    array_push($keyarr, $val);
                }
                $arr = $keyarr;
            }
            return $arr;
        }

    }

    /**
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * 自动生成标题
     */
    public function titleGenerate($type)
    {
        $keytemp = new KeyTemp();
        $keys = $keytemp->getAllKeyTemp($this->userid);
        if (empty($keys)) {
            return response()->json(array(
                'code' => 100
            ));
        }
        $products = $keytemp->getTempProductList($this->userid);
        $sets = $keytemp->advancedsetInfo($this->userid);
        $format = $keytemp->titleFormat();
        $format_arr = explode('|', $format[0]->title);
        $prefix = array();
        $suffix = array();
        $keyword = array();
        foreach ($keys as $val) {
            $str = $val->key_cate;
            if (mb_strpos($str, '前缀') !== false) {
                $prefix[] = $val->key_name;
            } else if (mb_strpos($str, '后缀') !== false) {
                $suffix[] = $val->key_name;
            } else if (mb_strpos($str, '关键词') !== false) {
                $keyword[] = $val->key_name;
            }
        }
        $i1 = 0;
        $i2 = 0;
        $i3 = 0;
        foreach ($products as $val) {
            $title = '';
            //重复顺序循环遍历关键词
            foreach ($format_arr as $v) {
                if (mb_strpos($v, '前缀') !== false) {
                    if ($type == 1) {
                        if ($i1 >= count($prefix)) {
                            $i1 = 0;
                        }
                        $title .= $prefix[$i1];
                        $i1++;
                    } else {
                        $title .= $prefix[array_rand($prefix, 1)];
                    }
                } else if (mb_strpos($v, '后缀') !== false) {
                    if ($type == 1) {
                        if ($i2 >= count($suffix)) {
                            $i2 = 0;
                        }
                        $title .= $suffix[$i2];
                        $i2++;
                    } else {
                        $title .= $suffix[array_rand($suffix, 1)];
                    }
                } else if (mb_strpos($v, '关键词') !== false) {
                    if ($type == 1) {
                        if ($i3 >= count($keyword)) {
                            $i3 = 0;
                        }
                        $title .= $keyword[$i3];
                        $i3++;
                    } else {
                        $title .= $keyword[array_rand($keyword, 1)];
                    }
                }
            }
            $keytemp->updateTempTitle($val->id, $title, $this->userid);
        }
        return response()->json(array(
            'code' => true
        ));
    }

    function zhengze($str)
    {
        $result = array();
        preg_match_all("/(?:\{)(.*)(?:\})/i", $str, $result);
        //return $result[1][0];
        return $result[1][0];
    }

    public function imageBank()
    {
        return view('tongbu/imagebank');
    }

    /**
     * @param Request $request
     * 复制产品发布
     */
    public function fabu_bak(Request $request)
    {
        $keytemp = new KeyTemp();
        $protemp = new ProductTemp();
        $products = $keytemp->getTempProductList($this->userid);
        if (empty($products)) {
            return response()->json(array(
                'code' => false,
                'message' => '没有可发布的产品'
            ));
        }
        foreach ($products as $val) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['productType'] = $val->productType;
            $post_data['categoryID'] = $val->categoryID;
            $post_data['subject'] = $val->subject1;
            $post_data['description'] = $val->description;
            $post_data['language'] = 'ENGLISH';
            $post_data['groupID'] = $val->groupID;
            $img = array();
            $arr = explode(',', $val->images);
            foreach ($arr as $v) {
                $img[] = $v;
            }
            $post_data['image'] = json_encode(array('images' => $img));
            //价格区间
            $ranges = $protemp->getProductPriceRange($val->productID);
            $prices = array();
            foreach ($ranges as $r) {
                $prices[] = array(
                    'startQuantity' => $r->startQuantity,
                    'price' => $r->price
                );
            }
            //销售信息
            $saleDetail = array(
                'saleType' => $val->saleType,
                'unit' => $val->unit,
                'minOrderQuantity' => $val->minOrderQuantity,
                'batchNumber' => $val->batchNumber,
                'priceRanges' => $prices
            );
            $post_data['saleInfo'] = json_encode($saleDetail);
            //商品属性
            $attributes = $protemp->getProductAttributes($val->productID);
            if (!empty($attributes)) {
                $att = array();
                foreach ($attributes as $a) {
                    $att[] = array(
                        'attributeID' => $a->attributeID,
                        'attributeName' => $a->attributeName,
                        'valueID' => $a->valueID,
                        'value' => $a->value
                    );
                }
                $post_data['attributes'] = json_encode($att);
            }
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.add/' . APP_KEY, $post_data);
            $post_data['_aop_signature'] = $sing;
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.add/" . APP_KEY . "?";
            $response = request_post($url, $post_data);
            var_dump($response);
        }
        return response()->json(array(
            'code' => true,
            'message' => 'success'
        ));

    }

    public function fabu(Request $request)
    {
        set_time_limit(0);
        $keytemp = new KeyTemp();
        $protemp = new ProductTemp();
        $products = $keytemp->getTempProductList($this->userid);
        if (empty($products)) {
            return response()->json(array(
                'code' => false,
                'message' => '没有可发布的产品'
            ));
        }
        foreach ($products as $val) {
            $post_data = array();
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['productType'] = $val->productType;
            $post_data['categoryID'] = $val->categoryID;
            $post_data['subject'] = $val->subject1;
            $post_data['description'] = $val->description;
            $post_data['language'] = 'ENGLISH';
            $post_data['groupID'] = json_encode(array($val->groupID));
            $img = array();
            $arr = explode(',', $val->images);
            foreach ($arr as $v) {
                array_push($img, $v);
            }
            $post_data['image'] = json_encode(array('images' => $img));
            //价格区间
            $ranges = $protemp->getProductPriceRange($val->productID);
            $prices = array();
            foreach ($ranges as $r) {
                $prices[] = array(
                    'startQuantity' => $r->startQuantity,
                    'price' => $r->price
                );
            }
            //销售信息
            $saleDetail = array(
                'saleType' => $val->saleType,
                'unit' => $val->unit,
                'minOrderQuantity' => $val->minOrderQuantity,
                'batchNumber' => $val->batchNumber,
                'priceRanges' => $prices
            );
            $post_data['saleInfo'] = json_encode($saleDetail);
            //商品国际贸易信息
            $internationalTradeInfo = array(
                'fobCurrency' => $val->fobCurrency,
                'fobMinPrice' => $val->fobMinPrice,
                'fobMaxPrice' => $val->fobMaxPrice,
                'fobUnitType' => $val->fobUnitType,
                'minOrderQuantity' => $val->minOrderQuantity,
                'minOrderUnitType' => $val->minOrderUnitType,
                'minOrderQuantity' => $val->minOrderQuantity,
                'supplyQuantity' => $val->supplyQuantity,
                'supplyUnitType' => $val->supplyUnitType,
                'supplyPeriodType' => $val->supplyPeriodType,
                'deliveryPort' => $val->deliveryPort,
                'deliveryTime' => $val->deliveryTime,
                'packagingDesc' => $val->packagingDesc
            );
            $post_data['internationalTradeInfo'] = json_encode($internationalTradeInfo);
            //商品属性
            $attributes = $protemp->getProductAttributes($val->productID);
            if (!empty($attributes)) {
                $att = array();
                foreach ($attributes as $a) {
                    $att[] = array(
                        'attributeID' => $a->attributeID,
                        'attributeName' => $a->attributeName,
                        'valueID' => $a->valueID,
                        'value' => $a->value
                    );
                }
                $post_data['attributes'] = json_encode($att);
            }
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.add/' . APP_KEY, $post_data);
            $post_data['_aop_signature'] = $sing;
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.add/" . APP_KEY . "?";
            $response = request_post($url, $post_data);
        }
        if (strstr($response, 'productID')) {
            $protemp->deleteAllProductTemp();
            return response()->json(array(
                'code' => true,
                'message' => 'success'
            ));
        } else {
            return response()->json(array(
                'code' => false,
                'message' => json_decode($response)->errorMsg
            ));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 单个产品发布
     */
    public function fabu_one(Request $request)
    {
        $keytemp = new KeyTemp();
        $protemp = new ProductTemp();
        $productid = $request->has('productid') ? $request->input('productid') : '';
        $products = $keytemp->getTempProductByIdList($productid, $this->userid);
        if (empty($products)) {
            return response()->json(array(
                'code' => false,
                'message' => '没有可发布的产品'
            ));
        }
        foreach ($products as $val) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['productType'] = $val->productType;
            $post_data['categoryID'] = $val->categoryID;
            $post_data['subject'] = $val->subject1;
            $post_data['description'] = $val->description;
            $post_data['language'] = 'ENGLISH';
            $post_data['groupID'] = json_encode(array($val->groupID));
            $img = array();
            $arr = explode(',', $val->images);
            foreach ($arr as $v) {
                array_push($img, $v);
            }
            $post_data['image'] = json_encode(array('images' => $img));
            //价格区间
            $ranges = $protemp->getProductPriceRange($val->productID);
            $prices = array();
            foreach ($ranges as $r) {
                $prices[] = array(
                    'startQuantity' => $r->startQuantity,
                    'price' => $r->price
                );
            }
            //销售信息
            $saleDetail = array(
                'saleType' => $val->saleType,
                'unit' => $val->unit,
                'minOrderQuantity' => $val->minOrderQuantity,
                'batchNumber' => $val->batchNumber,
                'priceRanges' => $prices
            );
            $post_data['saleInfo'] = json_encode($saleDetail);
            //商品国际贸易信息
            $internationalTradeInfo = array(
                'fobCurrency' => $val->fobCurrency,
                'fobMinPrice' => $val->fobMinPrice,
                'fobMaxPrice' => $val->fobMaxPrice,
                'fobUnitType' => $val->fobUnitType,
                'minOrderQuantity' => $val->minOrderQuantity,
                'minOrderUnitType' => $val->minOrderUnitType,
                'minOrderQuantity' => $val->minOrderQuantity,
                'supplyQuantity' => $val->supplyQuantity,
                'supplyUnitType' => $val->supplyUnitType,
                'supplyPeriodType' => $val->supplyPeriodType,
                'deliveryPort' => $val->deliveryPort,
                'deliveryTime' => $val->deliveryTime,
                'packagingDesc' => $val->packagingDesc
            );
            $post_data['internationalTradeInfo'] = json_encode($internationalTradeInfo);
            //商品属性
            $attributes = $protemp->getProductAttributes($val->productID);
            if (!empty($attributes)) {
                $att = array();
                foreach ($attributes as $a) {
                    $att[] = array(
                        'attributeID' => $a->attributeID,
                        'attributeName' => $a->attributeName,
                        'valueID' => $a->valueID,
                        'value' => $a->value
                    );
                }
                $post_data['attributes'] = json_encode($att);
            }
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.add/' . APP_KEY, $post_data);
            $post_data['_aop_signature'] = $sing;
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.add/" . APP_KEY . "?";
            $response = request_post($url, $post_data);
            if (strstr($response, 'productID')) {
                $protemp->deleteAllProductTemp();
                return response()->json(array(
                    'code' => true,
                    'message' => 'success'
                ));
            } else {
                return response()->json(array(
                    'code' => false,
                    'message' => '发布失败'
                ));
            }
        }
    }

    /**
     * @param $productid
     * @param $count
     * @return \Illuminate\Http\JsonResponse
     * 复制产品
     */
    public function fuZhi($productid, $count)
    {
        if (empty($productid) || empty($count)) {
            return response()->json(array(
                'code' => false
            ));
        }
        $pro = new Product();
        $product = $pro->getProductById($productid, $this->userid);
        if ($count > 0) {
            $temp = new ProductTemp();
            $temp->deleteAllProductTemp($this->userid);
            $temp->deleteAllSelectKey($this->userid);
            for ($i = 0; $i < $count; $i++) {
                $p = new ProductTemp();
                $p->subject = $product->subject;
                $p->categoryID = $product->categoryID;
                $p->groupID = $product->groupID;
                $p->productType = $product->productType;
                $p->description = $product->description;
                $p->fobCurrency = $product->fobCurrency;
                $p->fobMinPrice = $product->fobMinPrice;
                $p->fobMaxPrice = $product->fobMaxPrice;
                $p->fobUnitType = $product->fobUnitType;
                $p->paymentMethods = $product->paymentMethods;
                $p->minOrderQuantity = $product->minOrderQuantity;
                $p->minOrderUnitType = $product->minOrderUnitType;
                $p->supplyQuantity = $product->supplyQuantity;
                $p->supplyUnitType = $product->supplyUnitType;
                $p->supplyPeriodType = $product->supplyPeriodType;
                $p->deliveryPort = $product->deliveryPort;
                $p->deliveryTime = $product->deliveryTime;
                $p->consignmentDate = $product->consignmentDate;
                $p->packagingDesc = $product->packagingDesc;
                $p->productID = $product->productID;
                $p->json_data = $product->json_data;
                $p->userid = $product->userid;

                if (!empty($product->images)) {
                    $p->images = $product->images;
                    $arr = explode(',', $product->images);
                    for ($j = 0; $j < count($arr); $j++) {
                        $key = 'img' . ($j + 1);
                        $p->$key = $arr[$j];
                    }
                }
                $p->save();
            }
            return response()->json(array(
                'code' => true
            ));
        }
    }

    /**
     * @param $productid
     * @return \Illuminate\Http\JsonResponse
     * 获取单个产品信息
     */
    public function getProductInfo($productid)
    {
        if (empty($productid)) {
            return response()->json(array(
                'code' => false
            ));
        }
        $pro = new Product();
        $product = $pro->getProductById($productid, $this->userid);
        return response()->json(array(
            'data' => $product,
            'code' => true
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 更新复制产品详情
     */
    public function updateDesc(Request $request)
    {
        $content = $request->has('content') ? $request->input('content') : '';
        if (empty($content)) {
            return response()->json(array(
                'code' => false
            ));
        }
        $pro = new ProductTemp();
        $flag = $pro->updateProductDesc($content, $this->userid);
        return response()->json(array(
            'code' => true
        ));
    }

    public function test()
    {
        return view('tongbu/fabu_detail');
    }

    //复制产品-详情
    public function toDetail($productid)
    {
        return view('tongbu/fabu_detail')->with('productid', $productid);
    }

    //复制产品-生成参数
    public function toParam()
    {
        return view('tongbu/fabu_set_param');
    }

    //复制产品-生成关键词
    public function toKey()
    {
        return view('tongbu/fabu_set_key');
    }

    //复制产品-生成标题
    public function toTitle()
    {
        return view('tongbu/fabu_set_title');
    }

    public function toWuliu()
    {
        return view('tongbu/fabu_wuliu');
    }

    //复制产品-编辑
    public function toBatch()
    {
        return view('tongbu/fabu_batchedit');
    }

    public function removeFabu($productid)
    {
        $pro = new ProductTemp();
        $flag = $pro->removeFabu($productid, $this->userid);
        if ($flag) {
            return response()->json(array(
                'code' => true
            ));
        }
        return response()->json(array(
            'code' => false
        ));
    }

    public function saveTitle(Request $request)
    {
        $id = $request->has('id') ? $request->input('id') : '';
        $title = $request->has('title') ? $request->input('title') : '';
        if (empty($id) || empty($title)) {
            return response()->json(array(
                'code' => false
            ));
        }
        $pro = new ProductTemp();
        $flag = $pro->updateFabuTitle($title, $id, $this->userid);
        if ($flag) {
            return response()->json(array(
                'code' => true
            ));
        }
        return response()->json(array(
            'code' => false
        ));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 打乱图片顺序
     */
    public function randImage()
    {
        $keytemp = new KeyTemp();
        $pro = new ProductTemp();
        $products = $keytemp->getTempProductList($this->userid);
        foreach ($products as $val) {
            $json = json_decode($val->json_data);
            $arr = explode(',', $val->images);
            shuffle($arr);
            $json->image->images = shuffle($arr);
            $pro->updateTempData(json_encode($json), $this->userid);
            $i = 0;
            $img = '';
            $img_str = '';
            $img_arr = array();
            foreach ($arr as $m) {
                $i++;
                if ($img_str == '') {
                    $img = 'img' . $i . ' = ?';
                    $img_str = $img_str . $m;
                } else {
                    $img = $img . ',' . 'img' . $i . ' = ?';
                    $img_str = $img_str . ',' . $m;
                }
                array_push($img_arr, $m);
            }
            array_push($img_arr, $img_str);
            array_push($img_arr, $this->userid);
            $sql = 'set ' . $img . ', images= ?';
            $pro->updateTempImage($sql, $img_arr);
        }
        return response()->json(array(
            'code' => true
        ));
    }

    public function yunFei(Request $request)
    {
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.logistics.freightTemplate.getList/1512858/' . APP_KEY, $post_data);
        $post_data['_aop_signature'] = $sing;
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.logistics.freightTemplate.getList/1512858/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $result = json_decode($response)->freightTemplates;
        return response()->json(array(
            'code' => false,
            'message' => PARAM_NULL,
            'data' => json_encode($result)
        ));
    }

}


<?php

namespace App\Http\Controllers\Tongbu;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductBatch;
use App\Models\Admin\Product;
use App\Models\Admin\ProductAttribute;
use App\Models\Admin\PriceRangesBatch;
use App\Models\Admin\ProductTemp;
use Illuminate\Http\Request;
use Session, Response, DB;
use App\Models\Admin\KeyTemp;
use Log;

/**
 * create by:haohaisheng
 * Class BatchController
 * date  2016/7/25
 * @package App\Http\Controllers\Tongbu
 */
class BatchController extends Controller
{
    protected $token;
    protected $userid;

    public function __construct()
    {
        $this->token = get_token(Session::get('login_alibaba'));;
        $this->userid = Session::get('login_alibaba');
    }
    /**
     * @return Response
     *
     */
    /*public function index_bak(Request $request)
    {
        $ids = $request->has('ids') ? $request->input('ids') : '';
        if (empty($ids)) {
            return response()->json(array('code' => true, 'message' => PARAM_NULL));
        }
        $pro = new Product();
        $pb = new ProductBatch();
        if (is_array($ids)) {
            $list = $pro->getBatchList($ids);
            $pb->deleteAllBatch();
            foreach ($list as $val) {
                $p = new ProductBatch();
                $p->subject = $val->subject;
                $p->categoryID = $val->categoryID;
                $p->productType = $val->productType;
                $p->description = $val->description;
                $p->fobCurrency = $val->fobCurrency;
                $p->fobMinPrice = $val->fobMinPrice;
                $p->fobMaxPrice = $val->fobMaxPrice;
                $p->fobUnitType = $val->fobUnitType;
                $p->paymentMethods = $val->paymentMethods;
                $p->minOrderQuantity = $val->minOrderQuantity;
                $p->minOrderUnitType = $val->minOrderUnitType;
                $p->supplyQuantity = $val->supplyQuantity;
                $p->supplyUnitType = $val->supplyUnitType;
                $p->supplyPeriodType = $val->supplyPeriodType;
                $p->deliveryPort = $val->deliveryPort;
                $p->deliveryTime = $val->deliveryTime;
                $p->consignmentDate = $val->consignmentDate;
                $p->packagingDesc = $val->packagingDesc;
                $p->saleType = $val->saleType;
                $p->unit = $val->unit;
                $p->productID = $val->productID;
                //图片
                $p->images = $val->images;
                if (!empty($val->images)) {
                    $arr = explode(',', $val->images);
                    for ($j = 0; $j < count($arr); $j++) {
                        $key = 'img' . ($j + 1);
                        $p->$key = $arr[$j];
                    }
                }
                //价格区间
                $ranges = $pro->getProductPriceRange($val->productID);
                foreach ($ranges as $r) {
                    $price = new PriceRangesBatch();
                    $price->startQuantity = $r->startQuantity;
                    $price->price = $r->price;
                    $price->productID = $val->productID;
                    $price->save();
                }
                //商品属性
                $attributes = $pro->getProductAttributes($val->productID);
                if (!empty($attributes)) {
                    foreach ($attributes as $a) {
                        $arr = new ProductAttributeBatch();
                        $arr->attributeID = $a->attributeID;
                        $arr->attributeName = $a->attributeName;
                        $arr->valueID = $a->valueID;
                        $arr->value = $a->value;
                    }
                }
                $p->save();
            }
            return view('tongbu/batch_index')->with('ids', json_encode($ids));
        }
    }*/


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     * 编辑产品
     */
    public function index(Request $request)
    {
        $ids = $request->has('ids') ? $request->input('ids') : '';
        if (empty($ids)) {
            return response()->json(array('code' => true, 'message' => PARAM_NULL));
        }
        $pro = new Product();
        $pro->removeBatchPorduct($this->userid);
        $pro->updateType($ids);
        return view('tongbu/batch_index')->with('ids', json_encode($ids));
    }

    public function edit_index(Request $request)
    {
        $pro = new Product();
        $products = $pro->getProductBatchList($this->userid);
        $ids = array();
        if (!empty($products)) {
            foreach ($products as $val) {
                array_push($ids, $val->productID);
            }
        }
        return view('tongbu/batch_index')->with('ids', json_encode($ids));
    }


    /**
     * @param Request $request
     * @return array|static[]
     * 获取批量编辑产品
     */
    public function getBatchProductList(Request $request)
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            if ($val->subject == $json->subject) {
                $val->subject2 = '';
            } else {
                $val->subject2 = $json->subject;
            }
            if (property_exists($json, 'saleInfo')) {
                if (property_exists($json->saleInfo, 'minOrderQuantity')) {
                    $val->minOrderQuantity = $json->saleInfo->minOrderQuantity;
                } else {
                    $val->minOrderQuantity = 0;
                }
            } else {
                $val->minOrderQuantity = 0;
            }
        }
        if (count($batchs) > 0) {
            return $batchs;
        }
        return array();
    }

    public function getBatchProductTitleList(Request $request)
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        if (count($batchs) > 0) {
            return $batchs;
        }
        return array();
    }

    public function batchTitle()
    {
        return view('tongbu/batch_title');
    }


    public function batchKey()
    {
        return view('tongbu/batch_key');
    }

    public function batchcategory()
    {
        return view('tongbu/batch_category');
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

    //复制产品-编辑
    public function toBatch()
    {
        return view('tongbu/fabu_batchedit');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑标题
     */
    /*    public function titleReplace_bak(Request $request)
        {
            $type = $request->has('type') ? $request->input('type') : '';
            $isupdate = $request->has('isupdate') ? $request->input('isupdate') : '';
            if (empty($type)) {
                return response()->json(array('code' => true, 'message' => PARAM_NULL));
            }
            $bat = new ProductBatch();
            $batchs = $bat->getProductBatchList();
            if ($type == 1) {
                $findWord = $request->has('findwrod') ? $request->input('findwrod') : '';
                $replacewrod = $request->has('replacewrod') ? $request->input('replacewrod') : '';
                $isbig = $request->has('isbig') ? $request->input('isbig') : '';
                if (empty($findWord) || empty($replacewrod) || empty($isbig)) {
                    return response()->json(array('code' => true, 'message' => PARAM_NULL));
                }
                foreach ($batchs as $val) {
                    if ($isbig == 1) {
                        if (strstr($val->subject, $findWord)) {
                            $pb = ProductBatch::find($val->id);
                            $pb->subject1 = str_replace($findWord, $replacewrod, $val->subject);
                            if ($isupdate) {
                                if (strstr($val->description, $findWord)) {
                                    $pb->description = str_replace($findWord, $replacewrod, $val->description);
                                }
                            }
                            $pb->save();

                        }
                    } else {
                        if (stristr($val->subject, $findWord)) {
                            $pb = ProductBatch::find($val->id);
                            $pb->subject1 = str_replace($findWord, $replacewrod, $val->subject);
                            if ($isupdate) {
                                if (stristr($val->description, $findWord)) {
                                    $pb->description = str_replace($findWord, $replacewrod, $val->description);
                                }
                            }
                            $pb->save();
                        }
                    }
                }
                return response()->json(array('code' => true, 'message' => SUCESS));
            } else {
                $allword = $request->has('allword') ? $request->input('allword') : '';
                foreach ($batchs as $val) {
                    $pb = ProductBatch::find($val->id);
                    $pb->subject1 = $allword;
                    $pb->save();

                }
                return response()->json(array('code' => true, 'message' => SUCESS));
            }
        }*/

    public function titleReplace(Request $request)
    {
        $type = $request->has('type') ? $request->input('type') : '';
        $isupdate = $request->has('isupdate') ? $request->input('isupdate') : '';
        if (empty($type)) {
            return response()->json(array('code' => true, 'message' => PARAM_NULL));
        }
        $bat = new Product();
        $batchs = $bat->getProductBatchList($this->userid);
        if ($type == 1) {
            $findWord = $request->has('findwrod') ? $request->input('findwrod') : '';
            $replacewrod = $request->has('replacewrod') ? $request->input('replacewrod') : '';
            $isbig = $request->has('isbig') ? $request->input('isbig') : '';
            if (empty($findWord) || empty($replacewrod) || empty($isbig)) {
                return response()->json(array('code' => true, 'message' => PARAM_NULL));
            }
            foreach ($batchs as $val) {
                $info = $bat->getProductById($val->productID, $this->userid);
                $json_data = json_decode($info->batch_data);
                if ($isbig == 1) {//区分大小写
                    if (strstr($val->subject, $findWord)) {
                        $json_data->subject = str_replace($findWord, $replacewrod, $json_data->subject);
                        //$bat->updateSubject1($val->productID, str_replace($findWord, $replacewrod, $json_data->subject), $this->userid);
                        if ($isupdate) {
                            if (strstr($json_data->description, $findWord)) {
                                $json_data->description = str_replace($findWord, $replacewrod, $json_data->description);
                            }
                        }
                    }
                } else {
                    if (stristr($val->subject, $findWord)) {
                        $json_data->subject = str_replace($findWord, $replacewrod, $json_data->subject);
                        //$bat->updateSubject1($val->productID, str_replace($findWord, $replacewrod, $json_data->subject), $this->userid);
                        if ($isupdate) {
                            if (stristr($json_data->subject, $findWord)) {
                                $json_data->description = str_replace($findWord, $replacewrod, $json_data->description);
                            }
                        }
                    }
                }
                $bat->updateBatchData($val->productID, json_encode($json_data), $this->userid);
            }
            return response()->json(array('code' => true, 'message' => SUCESS));
        } else {
            $allword = $request->has('allword') ? $request->input('allword') : '';
            foreach ($batchs as $val) {
                $info = $bat->getProductById($val->productID, $this->userid);
                $json_data = json_decode($info->batch_data);
                $json_data->subject = $allword;
                $bat->updateBatchData($val->productID, json_encode($json_data), $this->userid);
            }
            return response()->json(array('code' => true, 'message' => SUCESS));
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑发布
     */
    /*    public function batchFabu_bak()
        {
            $bat = new ProductBatch();
            $prices = new PriceRangesBatch();
            $batchs = $bat->getProductBatchList();
            if (empty($batchs)) {
                return response()->json(array('code' => false, 'message' => '没有可发布的产品'));
            }
            $token = get_token();
            foreach ($batchs as $val) {
                $post_data['access_token'] = $token;
                $post_data['webSite'] = 'alibaba';
                $post_data['productID'] = $val->productID;
                //产品图片信息
                $img = array();
                $arr = explode(',', $val->images);
                foreach ($arr as $v) {
                    $img[] = $v;
                }
                $price = array();
                $ps = $prices->getProductPriceRanges($val->productID);
                foreach ($ps as $p) {
                    $price[] = array(
                        'startQuantity' => $p->startQuantity,
                        'price' => $p->price
                    );
                }
                //销售信息
                $saleDetail = array(
                    'saleType' => $val->saleType,
                    'unit' => $val->unit,
                    'minOrderQuantity' => $val->minOrderQuantity,
                    'batchNumber' => $val->batchNumber,
                    'priceRanges' => $price
                );

                //商品属性
                $attributes = $bat->getBatchProductAttributes($val->productID);
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
                }

                //价格区间
                $ranges = $prices->getProductPriceRanges($val->productID);
                $prices = array();
                foreach ($ranges as $r) {
                    $prices[] = array(
                        'startQuantity' => $r->startQuantity,
                        'price' => $r->price
                    );
                }
                $productInfo = array(
                    'productID' => $val->productID,
                    'productType' => $val->productType,
                    'subject' => $val->subject1,
                    'description' => $val->description,
                    'language' => 'ENGLISH',
                    'groupID' => $val->groupID,
                    'categoryID' => $val->categoryID,
                    'bizType' => $val->bizType,
                    'image' => array('images' => $img),
                    'saleInfo' => $saleDetail,
                    'attributes' => $att,
                );
                $json = $val->json_data;
                $result = json_decode($json);
                $post_data['productInfo'] = json_encode($result[0]);
                $sing = getSign('param2/1/com.alibaba.product/alibaba.product.edit/' . APP_KEY, $post_data);
                $post_data['_aop_signature'] = $sing;
                $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.edit/" . APP_KEY . "?";
                $response = request_post($url, $post_data);
                var_dump($response);
                return response()->json(array('code' => true, 'message' => SUCESS));
            }
        }*/

    /**
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑发布
     */
    public function batchFabu()
    {
        $pro = new Product();
        $bat = new ProductBatch();
        $prices = new PriceRangesBatch();
        $batchs = $pro->getProductBatchList($this->userid);
        if (empty($batchs)) {
            return response()->json(array('code' => 102, 'message' => '没有可发布的产品'));
        }
        foreach ($batchs as $val) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['productID'] = $val->productID;
            $json = $val->batch_data;
            $result = json_decode($json);
            unset($result->status);
            echo json_encode($result);
            $post_data['productInfo'] = json_encode($result);

            $response = $this->fabu_submit($post_data);
             var_dump($response);
            if (strstr($response, 'productID')) {
                $p = Product::find($val->id);
                $p['productID'] = $result->productID;
                $p['productType'] = $result->productType;
                $p['categoryID'] = $result->categoryID;
                $p['groupID'] = $result->groupID[0];
                $p['json_data'] = json_encode($result);
                $attributes = $result->attributes;
                foreach ($attributes as $val1) {
                    $a = new ProductAttribute();
                    $a->productID = $result->productID;
                    if (property_exists($val1, 'attributeID')) {
                        $a->attributeID = $val1->attributeID;
                    } else {
                        $a->attributeID = null;
                    }
                    if (property_exists($val1, 'attributeName')) {
                        $a->attributeName = $val1->attributeName;
                    } else {
                        $a->attributeName = null;
                    }
                    if (property_exists($val1, 'value')) {
                        $a->value = $val1->value;
                    } else {
                        $a->value = null;
                    }
                    if (property_exists($val1, 'valueID')) {
                        $a->valueID = $val1->valueID;
                    } else {
                        $a->valueID = null;
                    }
                    $a->save();
                }
                //$p['status'] = $result->status;
                $p['subject'] = $result->subject;
                $p['language'] = $result->language;
                //图片处理
                $img = $result->image->images;
                $imgs = implode(',', $img);
                $p['images'] = $imgs;
                load_img($imgs);
                $p['description'] = $result->description;
                $intion = $result->internationalTradeInfo;
                if (property_exists($intion, 'fobCurrency')) {
                    $p['fobCurrency'] = $intion->fobCurrency;
                }
                if (property_exists($intion, 'fobMinPrice')) {
                    $p['fobMinPrice'] = $intion->fobMinPrice;
                }
                if (property_exists($intion, 'fobMaxPrice')) {
                    $p['fobMaxPrice'] = $intion->fobMaxPrice;
                }
                if (property_exists($intion, 'fobUnitType')) {
                    $p['fobUnitType'] = $intion->fobUnitType;
                }
                if (property_exists($intion, 'paymentMethods')) {
                    $p['paymentMethods'] = implode(',', $intion->paymentMethods);
                }
                if (property_exists($intion, 'minOrderQuantity')) {
                    $p['minOrderQuantity'] = $intion->minOrderQuantity;
                }
                if (property_exists($intion, 'minOrderUnitType')) {
                    $p['minOrderUnitType'] = $intion->minOrderUnitType;
                }
                if (property_exists($intion, 'supplyQuantity')) {
                    $p['supplyQuantity'] = $intion->supplyQuantity;
                }
                if (property_exists($intion, 'supplyUnitType')) {
                    $p['supplyUnitType'] = $intion->supplyUnitType;
                }
                if (property_exists($intion, 'supplyPeriodType')) {
                    $p['supplyPeriodType'] = $intion->supplyPeriodType;
                }
                if (property_exists($intion, 'deliveryPort')) {
                    $p['deliveryPort'] = $intion->deliveryPort;
                }
                if (property_exists($intion, 'deliveryTime')) {
                    $p['deliveryTime'] = $intion->deliveryTime;
                }
                if (property_exists($intion, 'packagingDesc')) {
                    $p['packagingDesc'] = $intion->packagingDesc;
                }
                $p['type'] = 1;
                $p->save();
                return json_encode(array('code' => '101', 'message' => SUCESS));
            } else {
                return response()->json(array('code' => '103', 'message' => json_decode($response)->errorMsg));
                //return response()->json(array('code' => '103', 'message' =>'发布失败'));
            }
        }
        return response()->json(array('code' => true, 'message' => SUCESS));
    }

    /**
     * @param $productId
     * @return mixed
     * 从阿里获取单个产品信息
     */
    public function getProductInfo($productId)
    {
        $p = new Product();
        $post_data['access_token'] = $this->token;
        $post_data['productID'] = $productId;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.get/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.get/" . APP_KEY . "?access_token=" . $this->token . '&productID=' . $productId . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $result = json_decode($response);
        return $result;
    }

    /**
     * @param $post_data
     * @return \Illuminate\Http\JsonResponse
     * 发布通用方法
     */
    public function fabu_submit($post_data)
    {
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.edit/' . APP_KEY, $post_data);
        $post_data['_aop_signature'] = $sing;
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.edit/" . APP_KEY . "?";
        $response = request_post($url, $post_data);
        return $response;
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑_编辑图片页面
     */
    public function batchImg()
    {
        return view('tongbu/batch_img');
    }

    /**
     * @return array|static[]
     * 批量编辑_获取待编辑产品图片
     */
    public function getBatchImgList()
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            $images = $json->image->images;
            for ($i = 0; $i < 6; $i++) {
                $key = 'img' . ($i + 1);
                if ($i >= count($images)) {
                    $val->$key = '';
                } else {
                    $val->$key = $images[$i];
                }
            }
        }
        return json_encode($batchs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__编辑图片_选择图片
     */
    public function checkImage(Request $request)
    {
        $data = $request->has('data') ? $request->input('data') : '';
        $count = $request->has('count') ? $request->input('count') : '';
        $selecttype = $request->has('selecttype') ? $request->input('selecttype') : '';
        $imags = array();
        foreach ($data as $val) {
            $name = '123445345.jpg';
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['name'] = $name;
            $post_data['imageBytes'] = $val;
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.add/" . APP_KEY . "?";
            $response = request_post($url, $post_data);
            $result = json_decode($response);
            if (empty($result->errorCode)) {
                $imags[] = $result->image->url;
            }
        }
        $pro = new Product();
        $products = $pro->getProductBatchList($this->userid);
        $i = 0;
        foreach ($products as $val) {
            $json = json_decode($val->batch_data);
            $images = $json->image->images;
            $img_len = count($imags);
            if ($selecttype == 1) {//顺序
                if ($count == 'all') {//全部图片
                    $arr = array();
                    for ($m = 0; $m < 6; $m++) {
                        $x = $m % $img_len;
                        array_push($arr, $imags[$x]);
                        $json->image->images = $arr;
                    }
                } else {
                    $x = $i % $img_len;
                    if (count($images) >= $count) {
                        $json->image->images[$count - 1] = $imags[$x];
                    } else {
                        $json->image->images[count($images)] = $imags[$x];
                    }
                }
                $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
            } else {
                $imgs1 = array();
                if ($count == 'all') {//全部图片
                    for ($m = 0; $m < 6; $m++) {
                        $arr = array();
                        array_push($arr, array_rand($imags, 1));
                        $json->image->images = $arr;
                    }
                } else {
                    if (count($images) >= $count) {
                        $json->image->images[$count - 1] = $imags[array_rand($imags, 1)];
                    } else {
                        $json->image->images[count($images)] = $imags[array_rand($imags, 1)];
                    }
                }
                $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
            }
            $i++;
        }
        return response()->json(array(
            'code' => true
        ));
    }

    /**
     * @param $count
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__编辑图片_删除图片
     */
    public function delImages($count, $type)
    {
        $pro = new Product();
        $products = $pro->getProductBatchList($this->userid);
        foreach ($products as $val) {
            $json = json_decode($val->batch_data);
            if ($type == 'all' || $count == 'all') {
                $json->image->images = array();
            } else {
                if (count($json->image->images) >= $count) {
                    array_splice($json->image->images, ($count - 1), 1);
                }
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true
        ));
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑__编辑产品价格页面
     */
    public function batchPrice()
    {
        return view('tongbu/batch_price');
    }

    /**
     * @return array|static[]
     * 批量编辑__获取产品价格信息
     */
    public function getBatchPriceList()
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            $images = $json->image->images;
            for ($i = 0; $i < 6; $i++) {
                $key = 'img' . ($i + 1);
                if ($i >= count($images)) {
                    $val->$key = '';
                } else {
                    $val->$key = $images[$i];
                }
            }
        }
        return json_encode($batchs);
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑__编辑产品详情页面
     */
    public function batchDetail()
    {
        return view('tongbu/batch_detail');
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑__获取产品列表编辑详情使用
     */
    public function getBatchDetailList(Request $request)
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        foreach ($batchs as $val) {
            $val->str = strlen($val->description);
        }
        if (count($batchs) > 0) {
            return $batchs;
        }
        return array();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__编辑详情
     */
    public function batchDetailSave(Request $request)
    {
        $findkey = $request->has('findkey') ? $request->input('findkey') : '';
        $replacekey = $request->has('replacekey') ? $request->input('replacekey') : '';
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            if (stristr($json->description, $findkey)) {
                $json->description = str_replace($findkey, $replacekey, $json->description);
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true
        ));
    }


    /**
     * @return \Illuminate\View\View
     * 批量编辑__编辑产品最小起订量
     */
    public function batchMinOrder()
    {
        return view('tongbu/batch_minorder');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__最小起定量
     */
    public function batchMinOrderSave(Request $request)
    {
        $content = $request->has('content') ? $request->input('content') : '';
        if (!strstr($content, '|')) {
            return response()->json(array(
                'code' => false
            ));
        }
        $arr = explode('|', $content);
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            $json->saleInfo = array(
                'minOrderQuantity' => $arr[0],
                'unit' => $arr[1]
            );
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }

        return response()->json(array(
            'code' => true
        ));
    }

    /**
     * @return \Illuminate\View\View
     *
     */
    public function batchDetailImg()
    {
        return view('tongbu/batch_detail_img');
    }

    /**
     * @return string
     * 批量编辑__编辑详情图片信息
     */
    public function getBatchDetailImgList()
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        $pro->deleteDetailImg($this->userid);
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
            preg_match_all($pattern, $json->description, $match);
            $count = 0;
            $arr = array();
            foreach ($match[1] as $ma) {
                $im = $pro->getDetailImgTemp($this->userid);
                if (!empty($im)) {
                    foreach ($im as $m) {
                        if (!in_array($m->url, $arr)) {
                            array_push($arr, $m->url);
                        }
                    }
                }
                if (in_array($ma, $arr)) {
                    $count++;
                    $pro->updateDetailImgTemp($ma, $val->productID, $count);
                } else {
                    $param['url'] = $ma;
                    $param['count'] = 1;
                    $param['ids'] = $val->productID;
                    $pro->saveDetailImgTemp($param, $this->userid);
                }
            }
        }
        $imgTemp = $pro->getDetailImgTemp($this->userid);
        return json_encode($imgTemp);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse|static[]
     * 根据ID获取待编辑产品列表
     */
    public function getProductBactListByIds(Request $request)
    {
        $pro = new Product();
        $ids = $request->has('ids') ? $request->input('ids') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $list = $pro->getBatchProductByIds($ids);
        return $list;
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑__图片银行页面
     */
    public function batchImgBank()
    {
        return view('tongbu/batch_image_bank');
    }

    public function batchImgBank1()
    {
        return view('tongbu/batch_image_bank1');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__批量替换产品详情中的图片
     */
    public function replaceDetailImg(Request $request)
    {
        $pro = new Product();
        $ids = $request->has('ids') ? $request->input('ids') : '';
        $imags = $request->has('imags') ? $request->input('imags') : '';
        $checkimg = $request->has('checkimg') ? $request->input('checkimg') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $arr_id = explode(',', $ids);
        $list = $pro->getBatchProductByIds($arr_id);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            $json->description = str_replace($checkimg, $imags[0], $json->description);
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__删除详情中图片
     */
    public function removeDetailImg(Request $request)
    {
        $pro = new Product();
        $ids = $request->has('ids') ? $request->input('ids') : '';
        $checkimg = $request->has('checkimg') ? $request->input('checkimg') : '';

        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $arr_id = explode(',', $ids);
        $list = $pro->getBatchProductByIds($arr_id);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
            preg_match_all($pattern, $json->description, $match);
            foreach ($match[0] as $m) {
                if (strstr($m, $checkimg)) {
                    $json->description = preg_replace('<' . $m . '>', "", $json->description);
                }
            }
            /*  $patternStrs="(<div class=\"hdwiki_tmml\"><a.+?)name=\"(.+?)\">(.+?)(</a></div>)";
              if(preg_match($regex, $str, $matches)){
                  var_dump($matches);
              }*/
            //$json->description = preg_replace("&lt;&gt;", "", $json->description);
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__详情中插入图片
     */
    public function insertImg(Request $request)
    {
        $pro = new Product();
        $ids = $request->has('ids') ? $request->input('ids') : '';
        $checkimg = $request->has('checkimg') ? $request->input('checkimg') : '';
        $data = $request->has('data') ? $request->input('data') : '';
        $type = $request->has('data') ? $request->input('type') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $name = '123445345.jpg';
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $post_data['name'] = $name;
        $post_data['imageBytes'] = $data[0];
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.add/" . APP_KEY . "?";
        $response = request_post($url, $post_data);
        $result = json_decode($response);
        if (empty($result->errorCode)) {
            $img_url = $result->image->url;
            $arr_id = explode(',', $ids);
            $list = $pro->getBatchProductByIds($arr_id);
            foreach ($list as $val) {
                $json = json_decode($val->batch_data);
                $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
                preg_match_all($pattern, $json->description, $match);
                foreach ($match[0] as $m) {
                    if (strstr($m, $checkimg)) {
                        if ($type == 1) {//图片之前插入
                            $str = ' <img src="' . $img_url . '" style = "width:480.648px;height:320px;">' . $m;
                        } else {
                            $str = $m . '<img src="' . $img_url . '" style = "width:480.648px;height:320px;"> ';
                        }
                        $json->description = preg_replace($m, $str, $json->description);
                    }
                }
                $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
            }
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS,
            'uploadimg' => $img_url
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__删除插入详情的图片
     */
    public function removeInsertDetailImg(Request $request)
    {
        $pro = new Product();
        $ids = $request->has('ids') ? $request->input('ids') : '';
        $checkimg = $request->has('checkimg') ? $request->input('checkimg') : '';
        $delimg = $request->has('delimg') ? $request->input('delimg') : '';
        $type = $request->has('type') ? $request->input('type') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $arr_id = explode(',', $ids);
        $list = $pro->getBatchProductByIds($arr_id);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
            preg_match_all($pattern, $json->description, $match);
            $str = '<img src = "' . $delimg . '" style = "width:480.648px;height:320px;">';
            foreach ($match[0] as $m) {
                if (strstr($m, $checkimg)) {
                    if ($type == 1) {
                        $str = $str . $m;
                    } else {
                        $str = $m . $str;
                    }
                    $json->description = str_replace($str, $m, $json->description);
                }
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑__编辑计量单位页面
     */
    public function batchUnit()
    {
        return view('tongbu/batch_unit');
    }

    /**
     * @return mixed|string
     * 批量编辑__获取计量单位
     */
    public function getUnitList()
    {
        $pro = new Product();
        $units = $pro->getUnit();
        if (empty($units)) {
            $units = array();
        }
        return json_encode($units);
    }

    public function getBatchUnitlList()
    {
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        if (empty($list)) {
            return array();
        }
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            if (property_exists($json, 'saleInfo')) {
                if (property_exists($json->saleInfo, 'unit')) {
                    $val->unit = $json->saleInfo->unit;
                } else {
                    $val->unit = '';
                }
            } else {
                $val->unit = '';
            }
        }
        return $list;
    }


    public function saveUnit(Request $request)
    {
        $unit = $request->has('unit') ? $request->input('unit') : '';
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            if (property_exists($json, 'saleInfo')) {
                $json->saleInfo->unit = $unit;
            } else {
                $json->saleInfo = array('unit' => $unit);
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @return \Illuminate\View\View
     * 批量编辑__编辑计量单位页面
     */
    public function batchPriceRange()
    {
        return view('tongbu/batch_price_range');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__批量编辑产品价格区间
     */
    public function saveBatchPriceRange(Request $request)
    {
        $range = $request->has('range') ? $request->input('range') : '';
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        if (empty($range)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            $ranges = array();
            foreach ($range as $a) {
                $price = explode('|', $a);
                $ranges[] = array(
                    'startQuantity' => $price[0],
                    'price' => $price[1]
                );
            }
            if (property_exists($json, 'saleInfo')) {
                $json->saleInfo->priceRanges = $ranges;
            } else {
                $json->saleInfo = array('priceRanges' => $ranges);
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__编辑产品FOB价格
     */
    public function saveBatchFobPrice(Request $request)
    {
        $fobUnitType = $request->has('fobUnitType') ? $request->input('fobUnitType') : '';
        $fobMinPrice = $request->has('fobMinPrice') ? $request->input('fobMinPrice') : '';
        $fobMaxPrice = $request->has('fobMaxPrice') ? $request->input('fobMaxPrice') : '';
        $minOrderUnitType = $request->has('minOrderUnitType') ? $request->input('minOrderUnitType') : '';
        $fobMinPrice_count = $request->has('fobMinPrice_count') ? $request->input('fobMinPrice_count') : '';
        $fobMaxPrice_count = $request->has('fobMaxPrice_count') ? $request->input('fobMaxPrice_count') : '';
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        if (empty($fobUnitType) || empty($fobMinPrice) || empty($fobMaxPrice) || empty($minOrderUnitType)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        if (is_float($fobMinPrice)) {
            $fobMinPrice = round($fobMinPrice, $fobMinPrice_count);
        }
        if (is_float($fobMaxPrice)) {
            $fobMaxPrice = round($fobMaxPrice, $fobMaxPrice_count);
        }
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            if (property_exists($json, 'internationalTradeInfo')) {
                $json->internationalTradeInfo->fobUnitType = $fobUnitType;
                $json->internationalTradeInfo->fobMinPrice = $fobMinPrice;
                $json->internationalTradeInfo->fobMaxPrice = $fobMaxPrice;
                $json->internationalTradeInfo->minOrderUnitType = $minOrderUnitType;
            } else {
                $json->internationalTradeInfo = array(
                    'fobUnitType' => $fobUnitType,
                    'fobMinPrice' => $fobMinPrice,
                    'fobMaxPrice' => $fobMaxPrice,
                    'minOrderUnitType' => $minOrderUnitType,
                );
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @param Request $request
     * @return array|static[]
     * 批量编辑__用于编辑产品类型 型号 品牌列表
     */
    public function getBatchCatetoryList(Request $request)
    {
        $pro = new Product();
        $batchs = $pro->getProductBatchList($this->userid);
        $catelist = $pro->getCategoryList();
        $cate = array();
        foreach ($catelist as $val) {
            $cate[$val->categoryID] = $val->enName;
        }
        foreach ($batchs as $val) {
            $json = json_decode($val->batch_data);
            foreach ($json->attributes as $a) {
                if ($a->attributeName == 'Place of Origin') {
                    $val->chandi = $a->value;
                }
                if ($a->attributeName == 'Brand Name') {
                    $val->pinpai = $a->value;
                }
                if ($a->attributeName == 'Model Number') {
                    $val->xinghao = $a->value;
                }
            }
            $val->catename = $cate[$val->categoryID];
            $val->str = strlen($val->description);
        }
        if (count($batchs) > 0) {
            return $batchs;
        }
        return array();
    }

    public function getCountryList()
    {
        $pro = new Product();
        $list = $pro->getCountry();
        return json_encode($list);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑 __批量编辑产品原产地
     */
    public function saveChandi(Request $request)
    {
        $country = $request->has('country') ? $request->input('country') : '';
        if (empty($country)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            foreach ($json->attributes as $a) {
                if ($a->attributeName == 'Place of Origin') {
                    $a->value = $country;
                }
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑 __批量编辑产品品牌
     */
    public function savePinPai(Request $request)
    {
        $pinpai = $request->has('pinpai') ? $request->input('pinpai') : '';
        if (empty($pinpai)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            foreach ($json->attributes as $a) {
                if ($a->attributeName == 'Brand Name') {
                    $a->value = $pinpai;
                }
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑 __批量编辑产品型号
     */
    public function saveXinghao(Request $request)
    {
        $replace = $request->has('replace') ? $request->input('replace') : '';
        $type = $request->has('type') ? $request->input('type') : '';
        if (empty($replace) || empty($type)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        $z = 0;
        $i = 0;
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            foreach ($json->attributes as $a) {
                if ($a->attributeName == 'Model Number') {
                    if ($type == 'radio1') {//全部替换
                        $a->value = $replace;
                    } else if ($type == 'radio2') {//按输入的型号自动生成
                        if (preg_match('/[0-9]/', $replace)) {
                            preg_match_all("/\d+/", $replace, $arr);
                            if (count($arr[0]) > 1) {
                                if ($i == 0) {
                                    $z = $arr[0][count($arr[0]) - 1];
                                }
                                $defa = $arr[0][count($arr[0]) - 1];
                                $a->value = str_replace($defa, $z, $replace);
                                $z = intval($z) + 1;
                            } else {
                                if ($i == 0) {
                                    $z = $arr[0][0];
                                }
                                $defa = $arr[0][0];
                                $a->value = str_replace($defa, $z, $replace);
                                $z = intval($z) + 1;
                            }
                        } else {
                            $a->value = $replace . $i;
                        }
                    } else {


                    }
                }
            }
            $i++;
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }

        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }

    public function saveFileXinghao()
    {

        Log::info('test1---------------');


        Log::info('test1---------------' . $_FILES["filexinghao"]["name"]);

        if ($_FILES["filexinghao"]["error"] > 0) {
            echo "Error: " . $_FILES["filexinghao"]["error"] . "<br />";
        } else {
            echo "Upload: " . $_FILES["filexinghao"]["name"] . "<br />";
            echo "Type: " . $_FILES["filexinghao"]["type"] . "<br />";
            echo "Stored in: " . $_FILES["filexinghao"]["tmp_name"];


        }
    }


    public function saveBatchCustomCate(Request $request)
    {
        $customs = $request->has('custom') ? $request->input('custom') : '';
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        if (empty($customs)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            $custom = array();
            foreach ($customs as $a) {
                $cus = explode('|', $a);
                if (property_exists($json, 'attributes')) {
                    array_push($json->attributes, array(
                        'attributeName' => $cus[0],
                        'value' => $cus[1]
                    ));
                } else {
                    $json->attributes = $custom;
                }
            }
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }


    public function getCategoryList($cateid)
    {
        if (empty($cateid) && $cateid != 0) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $pro = new Product();
        $list = $pro->getCategoryById($cateid);
        return json_encode($list);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量编辑__编辑产品类目
     */
    public function saveCategory(Request $request)
    {
        $cateid = $request->has('cateid') ? $request->input('cateid') : '';
        if (empty($cateid)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        foreach ($list as $val) {
            $json = json_decode($val->batch_data);
            $json->categoryID = $cateid;
            $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS
        ));
    }


    public function saveBatchProductImages(Request $request)
    {
        $count = $request->has('count') ? $request->input('count') : '';
        $selecttype = $request->has('selecttype') ? $request->input('selecttype') : '';
        $imags = $request->has('imags') ? $request->input('imags') : '';
        $pro = new Product();
        $products = $pro->getProductBatchList($this->userid);
        $i = 0;
        foreach ($products as $val) {
            $json = json_decode($val->batch_data);
            $images = $json->image->images;
            $img_len = count($imags);
            if ($selecttype == 1) {//顺序
                if ($count == 'all') {//全部图片
                    $arr = array();
                    for ($m = 0; $m < 6; $m++) {
                        $x = $m % $img_len;
                        array_push($arr, $imags[$x]);
                        $json->image->images = $arr;
                    }
                } else {
                    $x = $i % $img_len;
                    if (count($images) >= $count) {
                        $json->image->images[$count - 1] = $imags[$x];
                    } else {
                        $json->image->images[count($images)] = $imags[$x];
                    }
                }
                $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
            } else {
                $imgs1 = array();
                if ($count == 'all') {//全部图片
                    for ($m = 0; $m < 6; $m++) {
                        $arr = array();
                        array_push($arr, array_rand($imags, 1));
                        $json->image->images = $arr;
                    }
                } else {
                    if (count($images) >= $count) {
                        $json->image->images[$count - 1] = $imags[array_rand($imags, 1)];
                    } else {
                        $json->image->images[count($images)] = $imags[array_rand($imags, 1)];
                    }
                }
                $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
            }
            $i++;
        }
        return response()->json(array(
            'code' => true
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editBatchProductDetail(Request $request)
    {
        $replacekey = $request->has('replacekey') ? $request->input('replacekey') : '';
        $findkey = $request->has('findkey') ? $request->input('findkey') : '';
        $type = $request->has('type') ? $request->input('type') : '';
        if (empty($type)) {
            return response()->json(array(
                'code' => false,
                'message' => PARAM_NULL
            ));
        }
        $pro = new Product();
        $list = $pro->getProductBatchList($this->userid);
        $count = 0;
        if ($type == 'find') {
            foreach ($list as $val) {
                $json = json_decode($val->batch_data);
                $count = $count + substr_count($json->description, $findkey);
            }
        } else {
            foreach ($list as $val) {
                $json = json_decode($val->batch_data);
                str_replace($findkey, $replacekey, $json->description);
                $pro->updateBatchData($val->productID, json_encode($json), $this->userid);
            }
        }
        return response()->json(array(
            'code' => true,
            'message' => SUCESS,
            'count' => $count
        ));
    }
}


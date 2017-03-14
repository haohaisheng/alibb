<?php

namespace App\Http\Controllers\Tongbu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use App\Models\Admin\Product;
use App\Models\Admin\ProductAttribute;
use App\Models\Admin\GoodOption;
use App\Models\Admin\Category;
use Log;
use Illuminate\Support\Facades\Session;


class TongBuController extends Controller
{

    protected $token;
    protected $userid;

    public function __construct()
    {
        $this->token = get_token(Session::get('login_alibaba'));
        $this->userid = Session::get('login_alibaba');
    }

    public function index(Request $request)
    {
        return view('tongbu/tongbu');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 数据同步，从阿里巴巴上把商品信息同步到本地服务器上
     */
    public function home_______1(Request $request)
    {
        set_time_limit(0);
        $shenhe = $request->has('shenhe') ? $request->input('shenhe') : '';
        $detail = $request->has('detail') ? $request->input('detail') : '';
        $pic = $request->has('pic') ? $request->input('pic') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $chuchuang = $request->has('chuchuang') ? $request->input('chuchuang') : '';
        $cateid = $request->has('cateid') ? $request->input('cateid') : 0;
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $param = '';
        if ($cateid) {
            $post_data['categoryID'] = $cateid;
            $param = '&categoryID=' . $cateid;
        }
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba' . $param . '&_aop_signature=' . $sing;
        $response = request_get($url);
        $count = json_decode($response)->count;
        $totalPage = ceil($count / 30);//分页总数

        for ($i = 0; $i < $totalPage; $i++) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $param = '';
            if ($cateid) {
                $post_data['categoryID'] = $cateid;
                $param = '&categoryID=' . $cateid;
            }
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba' . $param . '&_aop_signature=' . $sing;
            $response = request_get($url);
            $result = json_decode($response)->productInfos;
            foreach ($result as $val) {
                $p = new Product();
                if ($shenhe == 1) {
                    if ($val->status == 'online') {
                        $p['productID'] = $val->productID;
                        $p['productType'] = $val->productType;
                        $p['categoryID'] = $val->categoryID;
                        $p['groupID'] = $val->groupID[0];
                        $p['json_data'] = json_encode($val);
                        $attributes = $val->attributes;
                        foreach ($attributes as $val1) {
                            $a = new ProductAttribute();
                            $a->productID = $val->productID;
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
                        $p['status'] = $val->status;
                        $p['subject'] = $val->subject;
                        $p['language'] = $val->language;
                        //图片处理
                        $img = $val->image->images;
                        $imgs = implode(',', $img);
                        $p['images'] = $imgs;
                        load_img($imgs);
                        // if ($detail == 1) {
                        $p['description'] = $val->description;
                        // }
                        $intion = $val->internationalTradeInfo;
                        $p['fobCurrency'] = $intion->fobCurrency;
                        $p['fobMinPrice'] = $intion->fobMinPrice;
                        $p['fobMaxPrice'] = $intion->fobMaxPrice;
                        $p['fobUnitType'] = $intion->fobUnitType;
                        $p['paymentMethods'] = implode(',', $intion->paymentMethods);
                        $p['minOrderQuantity'] = $intion->minOrderQuantity;
                        $p['minOrderUnitType'] = $intion->minOrderUnitType;
                        $p['supplyQuantity'] = $intion->supplyQuantity;
                        $p['supplyUnitType'] = $intion->supplyUnitType;
                        $p['supplyPeriodType'] = $intion->supplyPeriodType;
                        $p['deliveryPort'] = $intion->deliveryPort;
                        $p['deliveryTime'] = $intion->deliveryTime;
                        // $p['consignmentDate'] = $intion->consignmentDate;
                        $p['packagingDesc'] = $intion->packagingDesc;
                        $p->save();
                    }
                } else {
                    $p['productID'] = $val->productID;
                    $p['productType'] = $val->productType;
                    $p['categoryID'] = $val->categoryID;
                    $p['groupID'] = $val->groupID[0];
                    $p['json_data'] = json_encode($val);
                    $attributes = $val->attributes;
                    foreach ($attributes as $val1) {
                        $a = new ProductAttribute();
                        $a->productID = $val->productID;
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
                    $p['status'] = $val->status;
                    $p['subject'] = $val->subject;
                    $p['language'] = $val->language;
                    //图片处理
                    $img = $val->image->images;
                    $imgs = implode(',', $img);
                    $p['images'] = $imgs;
                    //load_img($imgs);
                    //if ($detail == 1) {
                    $p['description'] = $val->description;
                    //}
                    $intion = $val->internationalTradeInfo;
                    $p['fobCurrency'] = $intion->fobCurrency;
                    $p['fobMinPrice'] = $intion->fobMinPrice;
                    $p['fobMaxPrice'] = $intion->fobMaxPrice;
                    $p['fobUnitType'] = $intion->fobUnitType;
                    $p['paymentMethods'] = implode(',', $intion->paymentMethods);
                    $p['minOrderQuantity'] = $intion->minOrderQuantity;
                    $p['minOrderUnitType'] = $intion->minOrderUnitType;
                    $p['supplyQuantity'] = $intion->supplyQuantity;
                    $p['supplyUnitType'] = $intion->supplyUnitType;
                    $p['supplyPeriodType'] = $intion->supplyPeriodType;
                    $p['deliveryPort'] = $intion->deliveryPort;
                    $p['deliveryTime'] = $intion->deliveryTime;
                    $p['packagingDesc'] = $intion->packagingDesc;
                    $p->save();
                    //die;
                    //  }
                }
            }
        }
        return response()->json(array(
            'code' => 101
        ));
        exit;
    }

    public function getdate($str)
    {
        $times = strstr($str, '+', TRUE);
        $a = substr($times, 0, -3);
        $tt = strtotime($a);
        return date("Y-m-d H:i:s", $tt);
    }

    public function home(Request $request)
    {
        set_time_limit(0);
        //同步产品分组
        $group_url = 'http://139.129.167.119/getgroup/-1';
        $response = request_get($group_url);

        $shenhe = $request->has('shenhe') ? $request->input('shenhe') : '';
        $detail = $request->has('detail') ? $request->input('detail') : '';
        $pic = $request->has('pic') ? $request->input('pic') : '';
        $status = $request->has('status') ? $request->input('status') : '';
        $chuchuang = $request->has('chuchuang') ? $request->input('chuchuang') : '';
        $cateid = $request->has('cateid') ? $request->input('cateid') : '';
        $pageno = $request->has('pageno') ? $request->input('pageno') : 0;
        $pageSize = 30;
        if ($pageno == 0) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $param = '';
            if (!empty($cateid)) {
                $post_data['categoryID'] = $cateid;
                $param = '&categoryID=' . $cateid;
            }
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba' . $param . '&_aop_signature=' . $sing;
            $response = request_get($url);
            $count = json_decode($response)->count;
            $totalPage = ceil($count / $pageSize);//分页总数
            return response()->json(array(
                'code' => 101,
                'totalcount' => $count,
                'totalpage' => $totalPage,
                'count' => 0,
                'pageno' => $pageno + 1
            ));
        } else {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['pageNo'] = $pageno;
            $post_data['pageSize'] = $pageSize;
            $param = '';
            if (!empty($cateid)) {
                $post_data['categoryID'] = $cateid;
                $param = '&categoryID=' . $cateid;
            }
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/" . APP_KEY . "?access_token=" . $this->token . '&pageNo=' . $pageno . '&pageSize=' . $pageSize . '&webSite=alibaba' . $param . '&_aop_signature=' . $sing;
            //Log::info('url------------'.$url);
            $response = request_get($url);
            $result = json_decode($response)->productInfos;
            $userid = Session::get('login_alibaba');
            foreach ($result as $val) {
                $p = new Product();
                $lasttime = $this->getdate($val->lastUpdateTime);
                $info = $p->getProductById($val->productID, $this->userid);
                if (empty($info) || ($lasttime > $info->lastUpdateTime)) {//有修改才更新
                    $p->deleteProductById($val->productID, $this->userid);
                    if ($shenhe == 1) {
                        if ($val->status == 'online') {
                            $p['productID'] = $val->productID;
                            $p['productType'] = $val->productType;
                            $p['categoryID'] = $val->categoryID;
                            $p['groupID'] = $val->groupID[0];
                            $p['json_data'] = json_encode($val);
                            $p['batch_data'] = json_encode($val);
                            $lasttime = $this->getdate($val->lastUpdateTime);
                            $creatime = $this->getdate($val->createTime);
                            $p['lastUpdateTime'] = $lasttime;
                            $p['createTime'] = $creatime;
                            $attributes = $val->attributes;
                            if (!empty($attributes)) {
                                $p->deleteProductAttribute($val->productID, $this->userid);
                                foreach ($attributes as $val1) {
                                    $a = new ProductAttribute();
                                    $a->productID = $val->productID;
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
                                    $a->userid = $this->userid;
                                    $a->save();
                                }
                            }
                            $p['status'] = $val->status;
                            $p['subject'] = $val->subject;
                            $p['language'] = $val->language;
                            //图片处理
                            $img = $val->image->images;
                            $imgs = implode(',', $img);
                            $p['images'] = $imgs;
                            load_img($imgs);
                            // if ($detail == 1) {
                            $p['description'] = $val->description;
                            // }
                            $intion = $val->internationalTradeInfo;
                            if (property_exists($intion, 'fobCurrency')) {
                                $p['fobCurrency'] = $intion->fobCurrency;
                            } else {
                                $p['fobCurrency'] = '';
                            }
                            if (property_exists($intion, 'fobMinPrice')) {
                                $p['fobMinPrice'] = $intion->fobMinPrice;
                            } else {
                                $p['fobMinPrice'] = '';
                            }
                            if (property_exists($intion, 'fobMaxPrice')) {
                                $p['fobMaxPrice'] = $intion->fobMaxPrice;
                            } else {
                                $p['fobMaxPrice'] = '';
                            }
                            if (property_exists($intion, 'fobUnitType')) {
                                $p['fobUnitType'] = $intion->fobUnitType;
                            } else {
                                $p['fobUnitType'] = '';
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
                            $p['userid'] = $userid;
                            $p->save();
                        }
                    } else {
                        $p['productID'] = $val->productID;
                        $p['productType'] = $val->productType;
                        $p['categoryID'] = $val->categoryID;
                        $p['groupID'] = $val->groupID[0];
                        $p['json_data'] = json_encode($val);
                        $p['batch_data'] = json_encode($val);
                        $lasttime = $this->getdate($val->lastUpdateTime);
                        $creatime = $this->getdate($val->createTime);
                        $p['lastUpdateTime'] = $lasttime;
                        $p['createTime'] = $creatime;
                        $attributes = $val->attributes;
                        if (!empty($attributes)) {
                            $p->deleteProductAttribute($val->productID, $this->userid);
                            foreach ($attributes as $val1) {
                                $a = new ProductAttribute();
                                $a->productID = $val->productID;
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
                                $a->userid = $this->userid;
                                $a->save();
                            }
                        }
                        $p['status'] = $val->status;
                        $p['subject'] = $val->subject;
                        $p['language'] = $val->language;
                        //图片处理
                        $img = $val->image->images;
                        $imgs = implode(',', $img);
                        $p['images'] = $imgs;
                        //load_img($imgs);
                        //if ($detail == 1) {
                        $p['description'] = $val->description;
                        //}
                        $intion = $val->internationalTradeInfo;
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
                        $p['userid'] = $userid;
                        $p->save();
                    }
                }
            }
            $p = new Product();
            $count = $p->getAllCount($userid);
            return response()->json(array(
                'code' => 101,
                'count' => $count,
                'pageno' => $pageno + 1
            ));
            exit;
        }
    }


    public function tbcount(Request $request)
    {
        $p = new Product();
        $data = $p->getCount($this->token);
        if (count($data) == 0) {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = '1688';
            $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/2993483?access_token=" . $this->token . '&webSite=1688&_aop_signature=' . $sing;
            $response = request_get($url);
            $count = json_decode($response)->count;
        } else {
            $count = $data[0]->total;
        }
        return response()->json(array(
            'total' => $count,
            'count' => count($data)
        ));
    }

    /**
     * 更新橱窗产品
     */
    public function updateChuChuang()
    {
        $p = new Product();
        $post_data['access_token'] = $this->token;
        // $sing = getSign('param2/1/cn.alibaba.open/industry.showwindow.doQueryRecommOfferList/' . APP_KEY, $post_data);
        $sing = getSign('', $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/cn.alibaba.open/industry.showwindow.doQueryRecommOfferList/" . APP_KEY . "?access_token=" . $this->token . '&_aop_signature=' . $sing;
        $response = request_get($url);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 更新单个商品
     */
    public function updateProduct(Request $request)
    {
        $productid = $request->has('productid') ? $request->input('productid') : '';
        $lastupdatetime = $request->has('lastupdatetime') ? $request->input('lastupdatetime') : '';
        if (empty($productid) || empty($lastupdatetime)) {
            return response()->json(array(
                'code' => false,
                'message' => '参数错误'
            ));
        }
        $p = new Product();
        $post_data['access_token'] = $this->token;
        $post_data['productID'] = $productid;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.get/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.get/" . APP_KEY . "?access_token=" . $this->token . '&productID=' . $productid . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $result = json_decode($response)->productInfo;
        if (!property_exists($result, 'productID')) {
            return response()->json(array(
                'code' => 102,
            ));
        }
        $lasttime = $this->getdate($result->lastUpdateTime);
        if ($lasttime == $lastupdatetime) {
            return response()->json(array(
                'code' => 103,
            ));
        } else {
            $flag = $p->deleteProductBasic($productid, $this->userid);
            $p['productID'] = $result->productID;
            $p['productType'] = $result->productType;
            $p['categoryID'] = $result->categoryID;
            $p['groupID'] = $result->groupID[0];
            $p['json_data'] = json_encode($result);
            $p['batch_data'] = json_encode($result);
            $lasttime = $this->getdate($result->lastUpdateTime);
            $creatime = $this->getdate($result->createTime);
            $p['lastUpdateTime'] = $lasttime;
            $p['createTime'] = $creatime;
            $attributes = $result->attributes;
            if (!empty($attributes)) {
                $p->deleteProductAttribute($result->productID, $this->userid);
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
                    $a->userid = $this->userid;
                    $a->save();
                }
            }
            $p['status'] = $result->status;
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
            $p['userid'] = $this->userid;
            $p->save();
            return response()->json(array(
                'code' => 101,
            ));

        }

    }

    public function login(Request $request)
    {
//       /* $token = get_token();
//        $post_data['access_token'] = $token;
//        $post_data['returnUrl'] = 'localhost';
//        $sing = getSign('param2/1/com.alibaba.product/alibaba.member.getLoginUri/' . APP_KEY, $post_data);
//        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.member.getLoginUri/" . APP_KEY . "?access_token=" . $token . '&returnUrl=localhost&webSite=1688&_aop_signature=' . $sing;
//        $response = request_get($url);
//        var_dump($response);*/
        //$result = json_decode($response)->productInfo;
        $post_data['access_token'] = $this->token;
        $post_data['returnUrl'] = 'localhost';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.member.getLoginUri/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.member.getLoginUri/" . APP_KEY . "?returnUrl=localhost";
        $response = request_get($url);
    }


    /**
     * @param $cid
     * 递归获取类目信息
     */
    public function categoryInfo($cid)
    {
        set_time_limit(0);
        $post_data['categoryID'] = $cid;
        $post_data['webSite'] = 'alibaba';
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.category.get/" . APP_KEY . "?categoryID=" . $cid . "&webSite=alibaba";
        $response = request_get($url);
        if (property_exists(json_decode($response), 'categoryInfo')) {
            if (count(json_decode($response)->categoryInfo) > 0) {
                $data = json_decode($response)->categoryInfo[0];
                $cate = new Category();
                if ($cid != 0) {
                    $cate['categoryID'] = $data->categoryID;
                    $cate['name'] = $data->name;
                    $cate['enName'] = $data->enName;
                    $cate['level'] = $data->level;
                    $cate['isLeaf'] = $data->isLeaf;
                    if (!empty($data->parentIDs)) {
                        $pid = implode(',', $data->parentIDs);
                        $cate['parentIDs'] = $pid;
                    }
                    if (!empty($data->childIDs)) {
                        $pstr = implode(',', $data->childIDs);
                        $cate['childIDs'] = $pstr;
                    }
                    $cate->save();
                }
                if (!empty($data->childIDs)) {
                    foreach ($data->childIDs as $c) {
                        $this->categoryInfo($c);
                    }
                }
            }

        }
    }


    /**
     * @param $cateid
     * @return mixed
     * 获取类目信息
     */
    public function categoryInfoBycateId($cateid)
    {
        $post_data['access_token'] = $this->token;
        $post_data['categoryID'] = $cateid;
        $post_data['webSite'] = 1688;
        $sing = getSign('param2/1/com.alibaba.product/alibaba.category.get/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.category.get/" . APP_KEY . "?categoryID=" . $cateid . "&webSite=1688";
        $response = request_get($url);
        $data1 = json_decode($response)->categoryInfo;
        $cate = new Category();
        $cateinfo = $cate->getCateinfoById($cateid);
        if (empty($cateinfo[0]->categoryID)) {
            $cate['categoryID'] = $data1[0]->categoryID;
            $cate['name'] = $data1[0]->name;
            $cate['enName'] = $data1[0]->enName;
            $cate['level'] = $data1[0]->level;
            $cate['isLeaf'] = $data1[0]->isLeaf;
            $cate['parentIDs'] = '';
            $pstr = implode(',', $data1[0]->childIDs);
            $cate['childIDs'] = $pstr;
            $cate->save();
        }
        return $response;
    }

    /**
     * @return \Illuminate\View\View
     * 系统概述
     */
    public function dash()
    {
        /*$post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $totalcount = json_decode($response)->count; */

        $pro = new Product();
        $time = date('Y-m-d') . ' 00:00:00';
        $count = $pro->getTotalCount($time, $this->userid);
        $todaycreate = $pro->getCountTodayCreate($time, $this->userid);
        $todayupdate = $pro->getCountTodayUpdate($time, $this->userid);
        return view('tongbu/dashboard')->with('totalcount', $count)->with('todaycreate', $todaycreate)->with('todayupdate', $todayupdate);
    }

    public function home_bak(Request $request)
    {
        $p = new Product();
        $productId = '60536676414';
        $post_data['access_token'] = $this->token;
        $post_data['productID'] = $productId;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.get/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.get/" . APP_KEY . "?access_token=" . $this->token . '&productID=' . $productId . '&webSite=alibaba&_aop_signature=' . $sing;

        $url = "";

        $response = request_get($url);

        echo $response;
        die;
        $result = json_decode($response);
        $result = $result->productInfo;


        $p = new Product();
        $p['productID'] = $result->productID;
        $p['productType'] = $result->productType;
        $p['categoryID'] = $result->categoryID;
        // $p['groupID'] = $result->groupID[0];
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
        $p['status'] = $result->status;
        $p['subject'] = $result->subject;
        $p['language'] = $result->language;
        //图片处理
        $img = $result->image->images;
        $imgs = implode(',', $img);
        $p['images'] = $imgs;
        load_img($imgs);
        $p['description'] = $result->description;
        $intion = $result->internationalTradeInfo;
        /*$p['fobCurrency'] = $result->fobCurrency;
        $p['fobMinPrice'] = $intion->fobMinPrice;
        $p['fobMaxPrice'] = $intion->fobMaxPrice;
        $p['fobUnitType'] = $intion->fobUnitType;
        $p['paymentMethods'] = implode(',', $intion->paymentMethods);
        $p['minOrderQuantity'] = $intion->minOrderQuantity;
        $p['minOrderUnitType'] = $intion->minOrderUnitType;
        $p['supplyQuantity'] = $intion->supplyQuantity;
        $p['supplyUnitType'] = $intion->supplyUnitType;
        $p['supplyPeriodType'] = $intion->supplyPeriodType;
        $p['deliveryPort'] = $intion->deliveryPort;
        $p['deliveryTime'] = $intion->deliveryTime;
        $p['packagingDesc'] = $intion->packagingDesc; */
        $p->save();
    }

    public function getp()
    {
        /* $post_data['access_token'] = $this->token;
         $post_data['webSite'] = 'alibaba';
         $post_data['timeStamp'] = '2016-9-18 9:58:43';
         $sing = getSign('param2/1/com.alibaba.product/alibaba.product.getList/' . APP_KEY, $post_data);
         $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.getList/" . APP_KEY . "?timeStamp=2016-9-18 9:58:43&access_token=" . $this->token . '&webSite=alibaba&_aop_signature=' . $sing;
         $response = request_get($url);
         //$count = json_decode($response)->count;
         var_dump($response);*/

        $str = '<div id="x7nr9" style="vertical-align: top; width: 33.3333%; display: inline-block; box-sizing: border-box; padding-right: 4px; padding-left: 4px"><div style="overflow: hidden; width: 244.656px; height: 320px;"><img src="http://baidu.com/aa.jpg"/></div></div>';
        //$regex = "(<div><a.+?)name=\"(.+?)\">&lt;&gt(</a></div>)";
        //$regex="/[^<div]*<div[^<>]*>(.*)<\/div>[^<\/div>]*/";
        //$regex="/[^<div]*>(&lt;&gt;)[^<\/div>]*/";
        $regex = "/<div>(.*)<\\/div>/iU";
        echo preg_replace($regex, $str);
        /*$regex = '';
        if (preg_match($regex, $str, $matches)) {
            var_dump($matches);
            echo '<br>';
            echo '---' . $matches[0];
        }*/
    }


    function get_tag($attr, $value, $xml, $tag = null)
    {
        if (is_null($tag)) {
            $tag = '\w+';
        } else {
            $tag = preg_quote($tag);
        }
        $attr = preg_quote($attr);
        $value = preg_quote($value);
        $tag_regex = "/<(" . $tag . ")[^>]*$attr\s*=\s*" . "(['\"])$value\\2[^>]*>(.*?)<\/\\1>/";
        preg_match_all($tag_regex, $xml, $matches, PREG_PATTERN_ORDER);
        return $matches[3];
    }

    public function chuChuang()
    {
        $p = new Product();
        $productId = '60535186527';
        $post_data['access_token'] = $this->token;
        $post_data['productID'] = $productId;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.product.get/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.product.get/" . APP_KEY . "?access_token=" . $this->token . '&productID = ' . $productId . '&webSite = alibaba&_aop_signature = ' . $sing;
        $response = request_get($url);
        $result = json_decode($response);
        $result = $result->productInfo;
        $p = new Product();
        $p['productID'] = $result->productID;
        $p['productType'] = $result->productType;
        $p['categoryID'] = $result->categoryID;
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
        $p['status'] = $result->status;
        $p['subject'] = $result->subject;
        $p['language'] = $result->language;
        //图片处理
        $img = $result->image->images;
        $imgs = implode(', ', $img);
        $p['images'] = $imgs;
        load_img($imgs);
        $p['description'] = $result->description;
        $intion = $result->internationalTradeInfo;
        $p->save();
    }
}

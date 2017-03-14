<?php

namespace App\Http\Controllers\Tongbu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, Response, DB;
use App\Models\Admin\KeyTemp;
use Log;

/**
 * create by:haohaisheng
 * Class UserController
 * date  2016/7/25
 * @package App\Http\Controllers\Tongbu
 */
class UploadController extends Controller
{
    protected $token;
    protected $userid;

    public function __construct()
    {
        $this->token = get_token(Session::get('login_alibaba'));
        $this->userid = Session::get('login_alibaba');
    }

    /* public function uploadImage(Request $request)
     {
         $url = $request->has('url') ? $request->input('url') : '';
         $token = get_token();
         $name = '123445345.jpg';
         $post_data['access_token'] = $token;
         $post_data['webSite'] = 'alibaba';
         $post_data['name'] = $name;

         $imgurl = 'C:\Users\hhs\Desktop\actile_bg.jpg';
         $tab = $this->base64EncodeImage($imgurl);
         $post_data['imageBytes'] = array($tab, $tab);
         $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.add/" . APP_KEY . "?";
         $response = request_post($url, $post_data);
         var_dump($response);
     }*/


    public function uploadImage(Request $request)
    {
        $data = $request->has('data') ? $request->input('data') : '';
        $count = $request->has('count') ? $request->input('count') : '';
        $selecttype = $request->has('$selecttype') ? $request->input('$selecttype') : '';
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
        $keytemp = new KeyTemp();
        $products = $keytemp->getTempProductList($this->userid);
        $i = 0;
        foreach ($products as $val) {
            $imgs = explode(',', $val->images);
            $img_len = count($imags);
            if ($selecttype == 1) {//顺序
                $imgs1 = array();
                if ($count == 'all') {//全部图片
                    for ($m = 0; $m < 6; $m++) {
                        $x = $m % $img_len;
                        $key = 'img' . ($m + 1);
                        $imgs1[$key] = $imags[$x];
                    }
                } else {
                    $x = $i % $img_len;
                    $key = 'img' . $count;
                    $imgs1[$key] = $imags[$x];
                }
                $tmd = json_decode($imgs1);
                $keytemp->updateImageProduct($imgs1, $val->id, $this->userid, json_decode($val->json_data));
            } else {
                $imgs1 = array();
                if ($count == 'all') {//全部图片
                    for ($m = 0; $m < 6; $m++) {
                        $key = 'img' . ($m + 1);
                        $k = array_rand($imags, 1);
                        $imgs1[$key] = $imags[$k];
                    }
                } else {
                    $key = 'img' . $count;
                    $k = array_rand($imags, 1);
                    $imgs1[$key] = $imags[$k];
                }
                $keytemp->updateImageProduct($imgs1, $val->id, $this->userid, json_decode($val->json_data));
            }
            $i++;
        }
        return response()->json(array(
            'code' => true
        ));
    }

    /**
     *
     */
    public function getImageList($page, $gid)
    {
        $pageSize = 50;
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $post_data['pageNo'] = $page;
        $post_data['pageSize'] = $pageSize;
        if ($gid == 'all') {
            $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.photo.getList/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&pageNo=' . $page . '&pageSize=' . $pageSize . '&_aop_signature=' . $sing;
        } else {
            $post_data['albumID'] = $gid;
            $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.photo.getList/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&pageNo=' . $page . '&albumID=' . $gid . '&pageSize=' . $pageSize . '&_aop_signature=' . $sing;
        }
        $response = request_get($url);
        $pics = json_decode($response)->photoInfos;
        $count = json_decode($response)->count;
        $totalPage = ceil($count / $pageSize);//分页总数
        return response()->json(array(
            'data' => $pics,
            'totalPage' => $totalPage
        ));
    }

    public function getImageGroup()
    {
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.album.getList/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.album.getList/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $pics = json_decode($response)->albumInfos;
        return response()->json(array(
            'data' => $pics
        ));
    }

    function base64EncodeImage($image_file)
    {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        //$base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        $base64_image = chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    public function setProductImages(Request $request)
    {
        $count = $request->has('count') ? $request->input('count') : '';
        $imags = $request->has('imags') ? $request->input('imags') : '';
        $selecttype = $request->has('selecttype') ? $request->input('selecttype') : '';
        $keytemp = new KeyTemp();
        $products = $keytemp->getTempProductList($this->userid);
        $i = 0;
        foreach ($products as $val) {
            $json = $val->json_data;
            $imgs = explode(',', $val->images);
            $img_len = count($imags);
            if ($selecttype == 1) {//顺序
                $imgs1 = array();
                if ($count == 'all') {//全部图片
                    for ($m = 0; $m < 6; $m++) {
                        $x = $m % $img_len;
                        $key = 'img' . ($m + 1);
                        $imgs1[$key] = $imags[$x];
                    }
                } else {
                    $x = $i % $img_len;
                    $key = 'img' . $count;
                    $imgs1[$key] = $imags[$x];
                }
                $keytemp->updateImageProduct($imgs1, $val->id, $this->userid, json_decode($json));
            } else {
                $imgs1 = array();
                if ($count == 'all') {//全部图片
                    for ($m = 0; $m < 6; $m++) {
                        $key = 'img' . ($m + 1);
                        $k = array_rand($imags, 1);
                        $imgs1[$key] = $imags[$k];
                    }
                } else {
                    $key = 'img' . $count;
                    $k = array_rand($imags, 1);
                    $imgs1[$key] = $imags[$k];
                }
                $keytemp->updateImageProduct($imgs1, $val->id, $this->userid, json_decode($json));
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
     * 批量删除产品主图
     */
    public function deleteImages($count, $type)
    {
        $keytemp = new KeyTemp();
        $products = $keytemp->getTempProductList($this->userid);
        foreach ($products as $val) {
            $json = $val->json_data;
            $imgs = array();
            if ($type == 'all' || $count == 'all') {
                for ($m = 0; $m < 6; $m++) {
                    $key = 'img' . ($m + 1);
                    $imgs[$key] = '';
                }
            } else {
                $key = 'img' . $count;
                $imgs[$key] = '';
            }
            $keytemp->updateImageProduct($imgs, $val->id, $this->userid, json_decode($json));
        }
        return response()->json(array(
            'code' => true
        ));
    }


    /**
     * @param Request $request
     * @return string
     * 富文本编辑器中的图片上传
     */
    public function uploadImage1(Request $request)
    {
        $file = $_FILES["imgFile"]["tmp_name"];
        $base64 = $this->base64EncodeImage($file);
        $name = '123445345.jpg';
        $post_data['access_token'] = $this->token;
        $post_data['webSite'] = 'alibaba';
        $post_data['name'] = $name;
        $post_data['imageBytes'] = $base64;
        $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.add/" . APP_KEY . "?";
        $response = request_post($url, $post_data);
        $result = json_decode($response);
        return json_encode(array(
            "error" => 0,
            "url" => $result->image->url
        ));
    }


    /**
     * @param $page
     * @return \Illuminate\Http\JsonResponse
     * 删除图片
     */
    public function deleteImage_bak(Request $request)
    {
        $ids = $request->has('ids') ? $request->input('ids') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => $ids,
                'message' => 'fail'
            ));
        }
        if (is_array($ids)) {
            foreach ($ids as $val) {
                $post_data['access_token'] = $this->token;
                $post_data['webSite'] = 'alibaba';
                $post_data['photoID'] = $val;
                $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.photo.delete/' . APP_KEY, $post_data);
                $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.delete/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&photoID=' . $val . '&_aop_signature=' . $sing;
                $response = request_post($url);
            }
        } else {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['photoID'] = $ids;
            $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.photo.delete/' . APP_KEY, $post_data);
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.delete/" . APP_KEY . "?access_token=" . $this->token . '&webSite=alibaba&photoID=' . $ids . '&_aop_signature=' . $sing;
            $response = request_post($url);
            var_dump($response);
        }
        return response()->json(array(
            'code' => json_encode($response),
            'message' => 'sucess'
        ));
    }

    public function deleteImage(Request $request)
    {
        $ids = $request->has('ids') ? $request->input('ids') : '';
        if (empty($ids)) {
            return response()->json(array(
                'code' => false,
                'message' => 'fail'
            ));
        }
        if (is_array($ids)) {
            foreach ($ids as $val) {
                $post_data['access_token'] = $this->token;
                $post_data['webSite'] = 'alibaba';
                $post_data['photoID'] = $val;
                $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.photo.delete/' . APP_KEY, $post_data);
                $post_data['_aop_signature'] = $sing;
                $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.delete/" . APP_KEY . "?";
                $response = request_post($url, $post_data);
            }
            return response()->json(array(
                'code' => json_encode($response),
                'message' => 'sucess'
            ));
        } else {
            $post_data['access_token'] = $this->token;
            $post_data['webSite'] = 'alibaba';
            $post_data['photoID'] = $ids;
            $sing = getSign('param2/1/com.alibaba.product/alibaba.photobank.photo.delete/' . APP_KEY, $post_data);
            $post_data['_aop_signature'] = $sing;
            $url = "http://gw.open.1688.com:80/openapi/param2/1/com.alibaba.product/alibaba.photobank.photo.delete/" . APP_KEY . "?";
            $response = request_post($url, $post_data);
        }
        return response()->json(array(
            'code' => json_encode($response),
            'message' => 'sucess'
        ));
    }

}


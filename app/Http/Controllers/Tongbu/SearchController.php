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
class SearchController extends Controller
{
    public function searchRank()
    {
        return view('tongbu/search_rank');
    }

    public function searchKey($key)
    {
        //$token = get_token();
        //$post_data['access_token'] = $token;
        $post_data['webSite'] = 'alibaba';
        $post_data['q'] = $key;
        $sing = getSign('param2/1/cn.alibaba.open/offer.search/' . APP_KEY, $post_data);
        $url = "http://gw.open.1688.com:80/openapi/param2/1/cn.alibaba.open/offer.search/" . APP_KEY . "?q=" . $key . '&webSite=alibaba&_aop_signature=' . $sing;
        $response = request_get($url);
        $result = json_decode($response);
        echo $response;
    }

}


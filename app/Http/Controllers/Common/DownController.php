<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use Illuminate\Support\Facades\Response;

class DownController extends Controller
{
    public function  down(Request $request)
    {
        $filename = $request->has('filename') ? $request->input('filename') : '';
        $filename = 'SameBoy_V1.0.11.apk';
        $file = '/www/wenda/public/download/andorid/SameBoy_V1.0.11.apk';
        //$file = '/www/wenda/SameBoy_V1.0.11.apk';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            //header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
}

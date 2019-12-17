<?php

namespace App\Http\Controllers\ProductApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * 图片上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function images(Request $request)
    {
        $status = 0;
        $data = [];
        if ($request->method() == 'POST') {
            $date = date('Ymd');
            $path = $request->file('file')->store('', 'upload');
            if ($path) {
                $file = $request->file('file'); # 获取上传的文件
                $filename = $file->getClientOriginalName(); # 获取上传文件的文件名
                $filesize = $file->getSize(); # 获取上传文件的大小
                $filetype = $file->getType(); # 获取上传文件的类型
                $thumbnailUrl = '/upload/image/' . $date . '/' . $path;
                // $fileKey = encrypt($thumbnailUrl);
                // $fileKey = Crypt::encryptString($thumbnailUrl);
                // $fileKey = Crypt::decryptString($thumbnailUrl);
                $fileKey = '';
                // 字符串转16进制
                for ($i = 0; $i < strlen($thumbnailUrl); $i++) {
                    $fileKey .= dechex(ord($thumbnailUrl[$i]));
                }
                // 16进制转字符串
                /*$string='';
                for ($i=0; $i < strlen($fileKey)-1; $i+=2){
                    $string .= chr(hexdec($fileKey[$i].$fileKey[$i+1]));
                }*/
                $status = 1;
                $data['thumbnailUrl'] = $thumbnailUrl;
                $data['originalName'] = $filename;
                $data['size'] = $filesize;
                $data['type'] = $filetype;
                $data['fileKey'] = $fileKey;
                $message = '上传成功';
            } else {
                $message = "上传失败";
            }
        } else {
            $message = "参数错误";
        }
        return response()->json([
            'status' => $status,
            'msg' => $message,
            'data' => $data,
        ]);
    }
}

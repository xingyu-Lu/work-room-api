<?php

namespace App\Http\Controllers\Api\Head;

use App\Exceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use OSS\OssClient;
use OSS\Core\OssException;

class FilesController extends Controller
{
    public function down(Request $request)
    {
        $params = $request->all();

        // $s = Storage::url($params['file_path']);
        // var_dump($s);exit;

        $file_exists = Storage::disk('public')->exists($params['file_path']);


        if (!$file_exists) {
            throw new BaseException(['msg' => '文件不存在']);
        }

        return Storage::disk('public')->download($params['file_path']);
    }

    public function upload(Request $request)
    {
        $user = auth('h-api')->user();

        if (!$user) {
            throw new BaseException(['msg' => '未登录', 'status' => '401']);
        }
        
        $params = $request->all();

        $path = [];

        $basket = $params['basket'];

        $file = $request->file('file');

        $allow_file_extension = ['jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'xlsx', 'xls', 'pdf', 'zip', 'rar', 'mp4'];

        if (!in_array($file->extension(), $allow_file_extension)) {
            throw new BaseException(['msg' => '不能上传' . $file->extension() . '格式的文件']);
        }

        // if (in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
        //     $img = Image::make($file);
        //     $img->insert(public_path() . '/suiying.png', 'bottom-right');
        //     $img->save();
        // }

        if (round($file->getSize()/1024/1024, 2) > 200) {
            throw new BaseException(['msg' => '上传文件过大']);
        }

        // 存阿里oss
        $accessKeyId = env('ACCESSKEYID', '');
        $accessKeySecret = env('ACCESSKEYSECRET', '');
        $endpoint = "https://oss-cn-shenzhen.aliyuncs.com";
        $bucket= "ybsyoss";
        $object = $basket . '/' . $file->getClientOriginalName();
        $filePath = $file->path();

        $path = '//oss.666120.cn/' . $object;

        $options = array(
            OssClient::OSS_HEADERS => array(
                'x-oss-object-acl' => 'public-read',
            ),
        );

        try{
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

            $ossClient->uploadFile($bucket, $object, $filePath, $options);
        } catch(OssException $e) {
            throw new BaseException(['msg' => $e->getMessage()]);
        }

        // 存储文件
        // $path = $file->storeAs($basket . '/' . date('Ym'), time() . '-' . $file->getClientOriginalName(), 'public');

        // 写入数据库
        $insert_data = [
            'storage' => 1,
            'file_url' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_size_m' => round($file->getSize()/1024/1024, 2) . 'M',
            'file_type' => $file->getMimeType() ?? '',
            'real_name' => $file->getClientOriginalName(),
            'extension' => $file->extension() ?? '',
        ];

        $res = UploadFile::create($insert_data);

        $res->src = $res->file_url;

        // $pre_path = $request->server('REQUEST_SCHEME') . '://' .$request->server('HTTP_HOST');

        // $url = $pre_path . Storage::url($res['file_url']);

        // $res->src = $url;

        return responder()->success($res);
    }

    public function uploads(Request $request)
    {
        $params = $request->all();

        $path = [];

        $res_arr = [];

        $basket = $params['basket'];

        $files = $request->file('file');

        foreach ($files as $key => $value) {
            // 存储文件
            $path = $file->storeAs($basket . '/' . date('Ym'), time() . '-' . $file->getClientOriginalName(), 'public');

            // 写入数据库
            $insert_data = [
                'storage' => 0,
                'file_url' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'real_name' => $file->getClientOriginalName(),
                'extension' => $file->extension(),
            ];

            $res = UploadFile::create($insert_data);

            $res_arr[] = $res;   
        }

        return responder()->success($res_arr);
    }
}

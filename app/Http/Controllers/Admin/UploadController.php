<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    const UPLOAD_KEY = 'file';

    protected $allowImageTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/bmp',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
    ];

    public function ueditor(Request $request)
    {
        switch ($request->action) {
            case 'uploadimage':
                return $this->postImage();

            default:
                return $this->getConfig($request);
        }
    }

    /**
     * 获取上传配置.
     *
     * @return array
     */
    public function getConfig(Request $request)
    {
        return  [
                    'imageUrl' => '/admin/upload/image',
                    'imagePath' => '/attachments/',
                    'imageFieldName' => 'file',
                    'imageMaxSize' => 2048000,
                    'imageCompressEnable' => true,
                    'imageCompressBorder' => 1600,
                    'imageUrlPrefix' => $request->root().'/',
                    'imageActionName' => 'uploadimage',
                    'imageAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],
                ];
    }

    /**
     * 上传图片.
     *
     * @return json
     */
    public function postImage()
    {
        if (!Input::hasFile(self::UPLOAD_KEY)) {
            throw new Exception('no file found.', 422);
        }

        $file = Input::file(self::UPLOAD_KEY);
        $mime = $file->getMimeType();

        $ext = $this->isImage($mime);
        $filesize = $file->getSize();

        $this->checkSize($filesize);

        if (!$ext) {
            throw new Exception('Error file type', 422);
        }

        $originalName = $file->getClientOriginalName();

        $filename = md5_file($file->getRealpath()).'.'.$ext;

        $datedir = date('Ym').'/';
        $dir = config('image.storage_path').$datedir;

        is_dir($dir) || mkdir($dir, 0755, true);

        if (!file_exists($dir.$filename)) {
            $file->move($dir, $filename);
        }

        $response = [
            'originalName' => $originalName,
            'name' => $originalName,
            'size' => $filesize,
            'type' => ".{$ext}",
            'path' => $datedir.$filename,
            'url' => config('image.prefix').'/'.$datedir.$filename,
            'state' => 'SUCCESS',
        ];

        return json_encode($response);
    }

    /**
     * 检查大小.
     *
     * @param int $size
     *
     * @throws Exception If too big.
     */
    protected function checkSize($size)
    {
        if ($size > config('image.upload_max_size')) {
            throw new Exception('Too big file.', 422);
        }
    }

    /**
     * 是否上传的是图片.
     *
     * @param string $mime
     *
     * @return bool
     */
    protected function isImage($mime)
    {
        return array_search($mime, $this->allowImageTypes);
    }
}

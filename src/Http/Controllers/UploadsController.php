<?php

namespace Jonexyz\WangEditorV5\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UploadsController extends Controller
{
    private $rule;
    private $dir_path;

    private function imgUpload()
    {
        $this->rule = ['jpg', 'png', 'gif', 'jpeg','bmp','pdf','webp']; //允许的图片后缀
        $this->dir_path = 'uploads/'.config('admin.upload.directory.image'); // 文件存储路径
    }

    private function videoUpload()
    {
        $this->rule = ['mp4', 'wav', 'avi','mpeg','mov','flv','mpg','rmvb','rm','3gp','swf','wmv','m4a','mp3','flac','mov','ape','aac']; //允许的视频音频文件后缀
        $this->dir_path = 'uploads/'.config('admin.upload.directory.file'); // 文件存储路径
    }

    public function img(Request $request)
    {
        if ($request->hasFile('images')) {
            $this->imgUpload();
            $rule = $this->rule;
            $dir_path = $this->dir_path;

            $file = $request->file('images'); //接前台图片
            $clientName = $file->getClientOriginalName();
            $size = $file->getSize();
            // $tmpName = $file->getFileName();
            // $realPath = $file->getRealPath();

            $entension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($entension), $rule)) {
                return $res = ['errno' => 0, 'data' => [
                    "errno"=> 1, // 只要不等于 0 就行
                    "message"=> "图片文件后缀不在允许范围内"
                ]];
            }

            $clientName = $this->checkFileExist($clientName);
            $path =$file->move($dir_path, $clientName)->getPathname();
            $path = str_replace("\\","/",$path);
            $path_arr =[
                'url'=> '/'.$path,
                'alt'=>$clientName.'.'.$entension,
                'href'=>'/'.$path

            ];
            $this->callbackUpload($path,$size,1);
            return $res = ['errno' => 0, 'data' => $path_arr];
        }
    }

    public function video(Request $request)
    {
        if ($request->hasFile('videos')) {
            $this->videoUpload();
            $rule = $this->rule;
            $dir_path = $this->dir_path;

            $file = $request->file('videos'); //接前台图片
            $clientName = $file->getClientOriginalName();
            $size = $file->getSize();
            // $tmpName = $file->getFileName();
            // $realPath = $file->getRealPath();

            $entension = $file->getClientOriginalExtension();
            if (!in_array(strtolower($entension), $rule)) {
                return $res = ['errno' => 0, 'data' => [
                    "errno"=> 1, // 只要不等于 0 就行
                    "message"=> "视频文件后缀不在允许范围内"
                ]];
            }
            $clientName = $this->checkFileExist($clientName);
            $path = $file->move($dir_path, $clientName)->getPathname();
            $path = str_replace("\\","/",$path);
            $path_arr =[
                'url'=> '/'.$path,
                'alt'=>$clientName.'.'.$entension,
                'href'=>'/'.$path

            ];
            $this->callbackUpload($path,$size,2);
            return $res = ['errno' => 0, 'data' => $path_arr];
        }
    }

    /**
     * 校验文件名是否存在并生成新的文件名
     * @param $clientName
     * @return string
     */
    private function checkFileExist($clientName)
    {
        $i = 1;
        while (true){
            $path = $this->dir_path.'/'.$clientName;
            $path = public_path($path);

            if(!is_file($path)) return $clientName;
            $i++;
            $arr = explode('.',$clientName);
            $arr[0] = $arr[0].'-'.$i;
            $clientName  = implode('.',$arr);
        }
    }

    /**
     * @param $path string 文件路径
     * @param $size int 文件大小
     * @param $type int 1 img, 2 video
     */
    private function callbackUpload($path,$size,$type)
    {
        if(function_exists('wangeditor5_uplaod_callback')){
            wangeditor5_uplaod_callback($path,$size,$type);
        }
    }
}

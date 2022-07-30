laravel-admin extension
======

### wangEditor 5 富文本编辑器插件

1. 仅适用与 laravel-admin 1.* 版本

2. 食用步骤

```
// 安装扩展
composer require jonexyz/wang-editor-v5

// 发布静态资源包
php artisan vendor:publish --tag=wang-editor-v5

```

3. 编辑器设置



```
'extensions' => [
        'wang-editor-v5' => [
            'enable' => true,
            'default'=>[
                'placeholder'=>'请输入内容...',
                'height'=>'600px',
                'width'=>'100%',

                // 图片上传相关设置
                'uploadImage'=>[

                    // 上传接口
                    'server'=> '/api/upload_img',

                    // 10M 以下插入 base64
                    //'base64LimitSize'=> 10 * 1024 * 1024,

                    // form-data fieldName ，默认值 'wangeditor-uploaded-image'
                    'fieldName'=> 'your-custom-name',

                    // 单个文件的最大体积限制，默认为 2M
                    'maxFileSize'=> 1 * 1024 * 1024, // 1M

                    // 最多可上传几个文件，默认为 100
                    'maxNumberOfFiles'=> 10,

                    // 选择文件时的类型限制，默认为 ['image/*'] 。如不想限制，则设置为 []
                    'allowedFileTypes' => ['image/*'],

                    // 自定义上传参数，例如传递验证的 token 等。参数会被添加到 formData 中，一起上传到服务端。
                    'meta'=> [
                        'token'=> 'xxx',
                        'otherKey'=> 'yyy'
                    ],

                    // 将 meta 拼接到 url 参数中，默认 false
                    'metaWithUrl'=> false,

                    // 自定义增加 http  header
                    'headers'=> [
                        'Accept'=> 'text/x-json',
                        'otherKey'=> 'xxx'
                    ],

                    // 跨域是否传递 cookie ，默认为 false
                    'withCredentials'=> true,

                    // 超时时间，默认为 10 秒
                    'timeout'=> 5 * 1000, // 5 秒
                ],

                //  上传视频
                'uploadVideo'=>[
                    // 上传入口api
                    'server'=> '/api/upload_video',

                    // form-data fieldName ，默认值 'wangeditor-uploaded-video'
                    'fieldName'=> 'your-custom-name',

                    // 单个文件的最大体积限制，默认为 10M
                    'maxFileSize'=> 5 * 1024 * 1024, // 5M

                    // 最多可上传几个文件，默认为 5
                    'maxNumberOfFiles'=> 3,

                    // 选择文件时的类型限制，默认为 ['video/*'] 。如不想限制，则设置为 []
                    'allowedFileTypes'=> ['video/*'],

                    // 自定义上传参数，例如传递验证的 token 等。参数会被添加到 formData 中，一起上传到服务端。
                    'meta'=> [
                    'token'=> 'xxx',
                        'otherKey'=> 'yyy'
                    ],

                    // 将 meta 拼接到 url 参数中，默认 false
                    'metaWithUrl'=> false,

                    // 自定义增加 http  header
                    'headers'=> [
                    'Accept'=> 'text/x-json',
                        'otherKey'=> 'xxx'
                    ],

                    // 跨域是否传递 cookie ，默认为 false
                    'withCredentials'=> true,

                    // 超时时间，默认为 30 秒
                    'timeout'=> 15 * 1000, // 15 秒

                    // 视频不支持 base64 格式插入
                ]

            ],
            'article'=>[
                'height'=>'100px',
               
            ]

        ]
    ],
```


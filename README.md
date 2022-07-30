laravel-admin extension
======

### wangEditor 5 富文本编辑器插件

##### 仅限于 wangEditor 5 简单使用，满足基本的富文本编辑器需求，复杂的富文本编辑器使用场景，可参考此代码，依据 laravel-admin 文档描述的插件开发流程自行开发插件

1. 仅适用与 laravel-admin 1.* 版本

2. 食用步骤

```
// 安装扩展
composer require jonexyz/wang-editor-v5

// 发布静态资源包
php artisan vendor:publish --tag=wang-editor-v5

```

3. 编辑器设置，可以一个页面使用多个富文本编辑器

'default' 表示默认配置，当数据表字段与配置键名不一致时，取 default 对应的配置


'article' 表示针对数据表字段 'article' 使用 wangEditor 5 富文本编辑器插件

` $form->wangEditor('article', __('文章')); `

设置信息参考如下：
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
                'placeholder'=>'请输入内容...',
                'height'=>'600px',
                'width'=>'100%',
               
            ]

        ]
    ],
```

具体使用参考如下：
```
 protected function form()
    {
        $form = new Form(new Post());

        $form->text('title', __('标题'));
        
        // 使用的是默认配置 default 
        $form->wangEditor('content', __('内容'));
        
        // 使用的是配置 article 
        $form->wangEditor('article', __('文章'));

        return $form;
    }
```

4. 图片上传api返回格式,
参考官方文档：
https://www.wangeditor.com/v5/menu-config.html#%E5%9B%BE%E7%89%87
```
// 单图
{
    "errno": 0, // 注意：值是数字，不能是字符串
    "data": {
        "url": "xxx", // 图片 src ，必须
        "alt": "yyy", // 图片描述文字，非必须
        "href": "zzz" // 图片的链接，非必须
    }
}

// 多图
{
    "errno": 0, // 注意：值是数字，不能是字符串
    "data": [
         {
            "url": "xxx", // 图片 src ，必须
            "alt": "yyy", // 图片描述文字，非必须
            "href": "zzz" // 图片的链接，非必须
          },
          {
            "url": "xxx", // 图片 src ，必须
            "alt": "yyy", // 图片描述文字，非必须
            "href": "zzz" // 图片的链接，非必须
          }    
     ]
}

//图片上传失败
{
    "errno": 1, // 只要不等于 0 就行
    "message": "失败信息"
}

```

5. 视频上传api返回格式，参考官方文档：
               https://www.wangeditor.com/v5/menu-config.html#%E8%A7%86%E9%A2%91
```
// 单个视频
{
    "errno": 0, // 注意：值是数字，不能是字符串
    "data": {
        "url": "xxx", // 视频 src ，必须
        "poster": "xxx.png" // 视频封面图片 url ，可选
    }
}

// 多个视频
{
    "errno": 0, // 注意：值是数字，不能是字符串
    "data":[
        {
            "url": "xxx", // 视频 src ，必须
            "poster": "xxx.png" // 视频封面图片 url ，可选
        }, 
        {
            "url": "xxx", // 视频 src ，必须
            "poster": "xxx.png" // 视频封面图片 url ，可选
         }
      ]
}

//上传失败的返回格式
{
    "errno": 1, // 只要不等于 0 就行
    "message": "失败信息"
}


```

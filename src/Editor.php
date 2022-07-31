<?php

namespace Jonexyz\WangEditorV5;

use Encore\Admin\Form\Field;

class Editor extends Field
{
    protected $view = 'wang-editor-v5::editor';

    protected static $js = [
        'vendor/laravel-admin-ext/wang-editor-v5/wangeditor5.1.14/index.js',
    ];

    protected static $css = [
        'vendor/laravel-admin-ext/wang-editor-v5/wangeditor5.1.14/css/style.css',
    ];

    public function render()
    {
        $id = $this->formatName($this->id);

        $config_arr = (array) WangEditorV5::config();

        if(isset($config_arr['default'])) $config= $config_arr['default'];

        if(isset($config_arr[$id])) $config= $config_arr[$id];

        if(empty($config)) $config = [];


        $config = array_merge([
            'placeholder'  => 'Type here...',

        ], $config, $this->options);

        $config['uploadImage']['meta']['_token'] = csrf_token();
        $uploadImage = json_encode($config['uploadImage']);

        $config['uploadVideo']['meta']['_token'] = csrf_token();
        $uploadVideo = json_encode($config['uploadVideo']);

        $this->script = <<<EOT

const E{$this->id} = window.wangEditor

    // 切换语言
    const LANG{$this->id} = location.href.indexOf('lang=en') > 0 ? 'en' : 'zh-CN'
    E{$this->id}.i18nChangeLanguage(LANG{$this->id})

    // 初始化
    let htmla{$this->id} = document.getElementById('input-{$this->id}').value

    window.editor = E{$this->id}.createEditor({
      selector: '#{$this->id}',
      html: htmla{$this->id},
      config: {
        placeholder: '{$config['placeholder']}',
        MENU_CONF: {
          uploadImage: $uploadImage,
          uploadVideo: $uploadVideo
        },
        onChange(editor) {
          // console.log(editor.getHtml())

          // 赋值给表单接收
          document.getElementById('input-{$this->id}').value = editor.getHtml()

          // 选中文字
          const selectionText = editor.getSelectionText()
          document.getElementById('selected-length-{$this->id}').innerHTML = selectionText.length
          // 全部文字
          const text = editor.getText().replace('/\\n|\\r/mg', '')
          document.getElementById('total-length-{$this->id}').innerHTML = text.length
        }
      }
    })

    window.toolbar = E{$this->id}.createToolbar({
      editor,
      selector: '#editor-toolbar-{$this->id}',
      config: {}
    })
EOT;
        return parent::render();
    }
}

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

        $config['uploadImage']['meta']['token'] = csrf_token();
        $uploadImage = json_encode($config['uploadImage']);

        $config['uploadVideo']['meta']['token'] = csrf_token();
        $uploadVideo = json_encode($config['uploadVideo']);

        $this->script = <<<EOT

const E = window.wangEditor

    // 切换语言
    const LANG = location.href.indexOf('lang=en') > 0 ? 'en' : 'zh-CN'
    E.i18nChangeLanguage(LANG)

    // 初始化
    let htmla = document.getElementById('input-{$this->id}').value

    window.editor = E.createEditor({
      selector: '#{$this->id}',
      html: htmla,
      config: {
        placeholder: '{$config['placeholder']}',
        MENU_CONF: {
          uploadImage: $uploadImage,
          uploadVideo: $uploadVideo
        },
        onChange(editor) {
          // console.log(editor.getHtml())

          // 赋值给表单接收
          document.getElementById('input-content').value = editor.getHtml()

          // 选中文字
          const selectionText = editor.getSelectionText()
          document.getElementById('selected-length').innerHTML = selectionText.length
          // 全部文字
          const text = editor.getText().replace('/\\n|\\r/mg', '')
          document.getElementById('total-length').innerHTML = text.length
        }
      }
    })

    window.toolbar = E.createToolbar({
      editor,
      selector: '#editor-toolbar',
      config: {}
    })
EOT;
        return parent::render();
    }
}

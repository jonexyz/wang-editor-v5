<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        @php
            $width = config('admin.extensions.wang-editor-v5.'.$column.'.width');
            $width = $width?:config('admin.extensions.wang-editor-v5.default.width');
            $with = $width?:'100%';

            $height = config('admin.extensions.wang-editor-v5.'.$column.'.height');
            $height = $height?:config('admin.extensions.wang-editor-v5.default.height');
            $height = $height?:'500px';
        @endphp

        <div style="border: 1px solid #ccc;">
            <div id="editor-toolbar" style="border-bottom: 1px solid #ccc;"></div>
            <div id="{{$id}}" style="width: {{$with}}; height: {{$height}};">
                @if(!empty(old($column, $value)))

                @else
                    <p></p>
                @endif
            </div>
        </div>

        <p style="background-color: #f1f1f1;">
            文本长度: <span id="total-length"></span>；
            所选文本长度: <span id="selected-length"></span>；
        </p>

        <input id="input-{{$id}}" type="hidden" name="{{$name}}" value="{{ old($column, $value) }}" />

        @include('admin::form.help-block')

    </div>
</div>

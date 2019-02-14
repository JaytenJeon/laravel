@extends('layouts.app')
@section('tui')
    <script src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('bower_components/tui-code-snippet/dist/tui-code-snippet.js') }}"></script>
    <script src="{{ asset('bower_components/markdown-it/dist/markdown-it.js') }}"></script>
    <script src="{{ asset('bower_components/to-mark/dist/to-mark.js') }}"></script>
    <script src="{{ asset('bower_components/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('bower_components/highlightjs/highlight.pack.js') }}"></script>
    <script src="{{ asset('bower_components/squire-rte/build/squire-raw.js') }}"></script>
    <script src="{{ asset('bower_components/tui-editor/dist/tui-editor-Editor-all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('bower_components/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/highlightjs/styles/github.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/tui-editor/dist/tui-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/tui-editor/dist/tui-editor-contents.css') }}">
@endsection
@section('content')

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <strong class="font-weight-bold  d-inline-block">게시판</strong>
                </div>
                <div class="card-body p-3 pr-3 pl-3">
                    <div class="container">
                        <form method="POST" action={{ route('posts.update', $post['id']) }}>
                        {!! csrf_field() !!}
                        {{ method_field('PUT')}}
                        <div class="form-group row">
                            <div class="col-md">
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title')?:$post['title'] }}" id="title"
                                       placeholder="제목을 입력하세요">
                                @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                @endif
                            </div>

                        </div>
                        <div id="editSection" class="form-control {{ $errors->has('text') ? ' is-invalid' : '' }}"></div>
                        @if ($errors->has('text'))
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('text') }}</strong>
                                        </span>
                        @endif
                        <textarea name="text" id="text" style="display:none"></textarea>

                        <div class="form-group  mb-0 mt-2">
                            <button type="submit" class="col-md btn btn-primary">
                                {{ __('수정하기') }}
                            </button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script >
        var text = "{{join("\\n",explode("\r\n",$post['text']))}}"
        document.addEventListener("DOMContentLoaded", function(event) {
            var editor = tui.Editor.factory({
                el: document.getElementById('editSection'),
                initialEditType: 'markdown',
                previewStyle: 'vertical',
                height: 300,
                initialValue: text
            });
            document.getElementById('submit').addEventListener("click", function(event){
                document.getElementById('text').value = editor.getValue();
            });
        })
    </script>
@stop
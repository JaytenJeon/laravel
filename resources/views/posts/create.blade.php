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
                            <form id='form' method="POST" action={{ route('posts.store') }}>
                                {!! csrf_field() !!}
                                <div class="form-group row">
                                    <div class="col-md">
                                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" id="title"
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
                                    <button id='submitBtn' type="submit" class="col-md btn btn-primary">
                                        {{ __('작성하기') }}
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
        var tempFiles = {};
        var finalFiles = [];
        document.addEventListener("DOMContentLoaded", function(event) {
            var editor = tui.Editor.factory({
                el: document.getElementById('editSection'),
                initialEditType: 'markdown',
                previewStyle: 'vertical',
                height: 500,
                initialValue: '{{ old('text') }}',
                events: {
                    'change': function(){
                        document.getElementById('text').value = editor.getValue();
                    }
                },
                hooks: {
                    'addImageBlobHook': function(blob, callback){
                        var url=URL.createObjectURL(blob);
                        tempFiles[url] = blob;
                        callback(url);
                        return false;
                    }
                }

            });
            var form = document.forms.namedItem('form');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                if(Object.keys(tempFiles).length == 0){
                    form.submit();
                    return false;
                }
                var title = document.getElementById('title').value;
                var text = document.getElementById('text').value;
                if(title=="" || text==""){
                    form.submit();
                    return false;
                }
                var regex = /\((blob:.*?)\)/g;
                var m ;
                while((m = regex.exec(text)) !== null){
                    finalFiles.push(tempFiles[m[1]]);
                }


                var fd = new FormData(document.forms.namedItem('form'));
                var xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    if (this.status == 200) {
                        var json = JSON.parse(xhr.response);

                        for (var key in json) {
                            // alert(key);
                            var input = document.createElement("input");
                            input.setAttribute('type', 'hidden');
                            input.setAttribute('name', 'images[]');
                            input.setAttribute('value', key);
                            // console.log(key);
                            form.appendChild(input);
                        }
                        form.submit();

                    }
                    return false;
                };
                xhr.open("POST", '{{route('images.store')}}');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName("csrf-token")[0].content);

                for(var i in finalFiles){
                    fd.append('files[]',finalFiles  [i]);
                }
                console.log(fd.getAll('files[]'));
                xhr.send(fd);

            });
        })



    </script>
@stop

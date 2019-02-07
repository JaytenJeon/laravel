@extends('layouts.app')
@section('tui')
    <script src="{{ asset('bower_components/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('bower_components/tui-code-snippet/dist/tui-code-snippet.js') }}"></script>
    <script src="{{ asset('bower_components/markdown-it/dist/markdown-it.js') }}"></script>
    <script src="{{ asset('bower_components/to-mark/dist/to-mark.js') }}"></script>
    <script src="{{ asset('bower_components/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('bower_components/highlightjs/highlight.pack.js') }}"></script>
    <script src="{{ asset('bower_components/squire-rte/build/squire-raw.js') }}"></script>
    <script src="{{ asset('bower_components/tui-editor/dist/tui-editor-Viewer.min.js') }}"></script>
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
                    <div class="card-header text-center p-2">

                        <a href="{{ route('posts.index',['page'=>session('page')])}}"  class="float-left btn btn-outline-primary">목록</a>

                        <strong class="font-weight-bold  d-inline-block p-1 m-1">게시판</strong>
                        <div class="float-right">
                            @if( auth()->user()->id == $post['postable_id'])
                            <a href="{{route('posts.edit',$post['id'])}}"  class="btn btn-outline-primary">수정</a>
                            <button data-toggle="modal" data-target="#exampleModal"  class="btn btn-outline-danger">삭제</button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">삭제 안내</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                정말로 게시물을 삭제하겠습니까?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                                                <form class="float-right ml-1" action="{{ route('posts.destroy',$post['id']) }}" method="post">
                                                    {!! method_field('delete') !!}
                                                    {!! csrf_field() !!}
                                                    <button type="submit"   class="btn btn-danger">삭제</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="card-body p-3 pr-3 pl-3">
                        <div class="container">
                            {!! csrf_field() !!}
                            <div class="form-group row">
                                <div class="col-md">
                                    <h4>{{$post['title']}}</h4>
                                    <hr class=" mb-0">
                                </div>

                            </div>
                            <div id="editSection"></div>
                                {{--<div class="form-group row">--}}
                                    {{--<div class="col-md">--}}

                                        {{--{!! nl2br(e($post['text']))!!}--}}

                                    {{--</div>--}}

                                {{--</div>--}}

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
            var editor = new tui.Editor({
                el: document.getElementById('editSection'),
                height: 300,
                initialValue: text

            });
        })
    </script>
@endsection
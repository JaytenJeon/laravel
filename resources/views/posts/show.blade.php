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
            <div class="col-md-8">
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


                        </div>

                    </div>
                </div>
                <div class="h6 mt-4"><strong>{{$comments->count()}} Comments</strong></div>
                @foreach($comments as $comment)
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>{!!$comment->authorable->fixed_nickname?$comment->authorable->fixed_nickname . '<span class="badge badge-warning ml-2">'.'고정닉'.'</span>':$comment->authorable->unfixed_nickname.'<span class="badge badge-secondary ml-2">'.'비고정닉'.'</span>'!!}</strong>
                            <small class="ml-2">{{elapsedTime(strtotime($comment->updated_at))}}</small>
                            @if($comment->authorable->id == auth()->user()->id)
                                <button data-toggle="modal" data-target="#commentModal" class="close"  aria-label="Close" onClick="closeClick({{$comment->id}})">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            @endif
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{$comment->text}}</p>
                        </div>
                    </div>
                @endforeach
                <!-- Modal -->
                <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">삭제 안내</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                정말로 댓글을 삭제하겠습니까?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                                <form id="comment-close-form" class="float-right ml-1" action="" method="post">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
                                    <button type="submit"   class="btn btn-danger">삭제</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{route('comments.store')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="post_id" value="{{$post['id']}}">
                    <div class="card">
                        <div class="card-header">
                            <strong>{{auth()->user()->fixed_nickname}}</strong>
                            {!!auth()->user()->fixed_nickname?'<span class="badge badge-warning ml-2">'.'고정닉'.'</span>':'<span class="badge badge-secondary ml-2">'.'비고정닉'.'</span>'!!}</strong>
                        </div>

                        <div class="card-body p-2">
                            <textarea name="text" type="text" class="form-control {{ $errors->has('text') ? ' is-invalid' : '' }}" name="" id="comment" placeholder="댓글을 입력해주세요" style="resize: none" autofocus></textarea>
                            @if ($errors->has('text'))
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="card-footer p-2">
                            <button type="submit" class="btn btn-primary  float-right">작성하기</button>
                        </div>

                     </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script >
        function closeClick(id) {
            console.log(id);
            var url = document.location.origin + "/comments/" + id;
            console.log(url);
            document.getElementById('comment-close-form').setAttribute('action',url);
        }
        var text = "{{join("\\n",explode("\r\n",$post['text']))}}"
        document.addEventListener("DOMContentLoaded", function(event) {
            var editor = new tui.Editor({
                el: document.getElementById('editSection'),
                height: 300,
                initialValue: text

            });
            document.getElementById('comment').focus();
        })
    </script>
@endsection
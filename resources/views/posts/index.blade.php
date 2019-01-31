@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center p-2">

                        <strong class="font-weight-bold  d-inline-block p-1 m-1">프로그래밍 갤러리</strong>
                        <a href="{{route('posts.create')}}"  class="float-md-right btn btn-outline-primary">글쓰기</a>
                    </div>

                    <div class="card-body p-0 pr-3 pl-3">
                        <table class="table table-hover">
                            <thead  >
                            <tr>
                                <th style="width:5%"g>번호</th>
                                <th style="width:70%" class="text-center">제목</th>
                                <th style="width:25%" class="text-center">작성자</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td scope="row">{{$post->id}}</td>
                                    <td>{{$post->title}}</td>
                                    <td class="text-center">{{$post->postable->fixed_nickname?:$post->postable->unfixed_nickname }} {!! $post->postable->fixed_nickname?'<span class="badge badge-warning">'.'고정닉'.'</span>':'<span class="badge badge-light">'.'비고정닉'.'</span>'  !!}</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>


                    </div>


                </div>

            </div>
            @if($posts->count())
                <div class="m-3 text-center">
                    {!! $posts->links() !!}
                </div>
            @endif

        </div>

    </div>

@endsection

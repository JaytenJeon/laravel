@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">프로그래밍 갤러리</div>
                    <div class="card-body p-0 pr-3 pl-3">
                        <table class="table">
                            <thead  >
                            <tr>
                                <th>번호</th>
                                <th class="text-center">제목</th>
                                <th>작성자</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td scope="row">{{$post->id}}</td>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->user_name}}</td>
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

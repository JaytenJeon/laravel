@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center p-2">
                        <a href="{{  url()->previous()}}"  class="float-md-left btn btn-outline-primary">목록</a>

                        <strong class="font-weight-bold  d-inline-block p-1 m-1">프로그래밍 갤러리</strong>
                        <div class="float-right">

                            <a href="#"  class="btn btn-outline-primary">수정</a>
                            <a href="#"  class="btn btn-outline-danger">삭제</a>
                        </div>

                    </div>
                    <div class="card-body p-3 pr-3 pl-3">
                        <div class="container">
                                {!! csrf_field() !!}
                                <div class="form-group row">
                                    <div class="col-md">
                                        <h4>{{$post['title']}}</h4>
                                        <hr>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md">
                                        {{$post['text']}}
                                    </div>

                                </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
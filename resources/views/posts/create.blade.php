@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <strong class="font-weight-bold  d-inline-block">프로그래밍 갤러리</strong>
                    </div>
                    <div class="card-body p-3 pr-3 pl-3">
                        <div class="container">
                            <form method="POST" action={{ route('posts.store') }}>
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
                                <div id="editSection"></div>


                                <div class="form-group  mb-0 mt-2">
                                    <button type="submit" class="col-md btn btn-primary">
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
    <script>
        var editor = tui.Editor.factory({
            el: document.getElementById('editSection'),
            initialEditType: 'markdown',
            previewStyle: 'vertical',
            height: 300
        });
    </script>
@endsection
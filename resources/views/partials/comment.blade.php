<div class="row m-1">
@if($ml>0)
    <div class="col-{{$ml}}">
    </div>
@endif
    
    @if($comment->trashed())

        <div class="card mb-3 col-{{12-$ml}} p-0">
            <div class="card-body bg-light" data-toggle="collapse" data-target="#collapseExample{{$comment->id}}" aria-expanded="false" aria-controls="collapseExample"  style="cursor:pointer;">
                <strike class="card-text">삭제된 댓글 입니다.</strike>
            </div>
        </div>
    @else
        <div class="card mb-3 col-{{12-$ml}} p-0">
            <div class="card-header">
                <strong>{!!$comment->authorable->fixed_nickname?$comment->authorable->fixed_nickname . '<span class="badge badge-warning ml-2">'.'고정닉'.'</span>':$comment->authorable->unfixed_nickname.'<span class="badge badge-secondary ml-2">'.'비고정닉'.'</span>'!!}</strong>
                <small class="ml-2">{{elapsedTime(strtotime($comment->updated_at))}}</small>
                @if($comment->authorable->id == auth()->user()->id)
                    <button data-toggle="modal" data-target="#commentModal" class="close"  aria-label="Close" onClick="closeClick({{$comment->id}})">
                        <span aria-hidden="true">&times;</span>
                    </button>

                @endif
            </div>

            <div class="card-body" data-toggle="collapse" data-target="#collapseExample{{$comment->id}}" aria-expanded="false" aria-controls="collapseExample"  style="cursor:pointer;">
                <p class="card-text">{{$comment->text}}</p>
            </div>
        </div>
    @endif

</div>
<form class="collapse ml-5 mb-3" id="collapseExample{{$comment->id}}" method="POST" action="{{route('comments.store')}}">
    {!! csrf_field() !!}
    <input type="hidden" name="comment_id" value="{{$comment->id}}">
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
@if($comment->replies->count() > 0)

    @foreach($comment->replies as $comment)
        @include('partials.comment', [$comment, 'ml'=>$ml+1])
    @endforeach
@endif


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //

    public function store(Request $request)
    {
        //
        $request->validate(['text' => ['required', 'string']]);
        $post = \App\Post::find($request['post_id']);
        $comment = auth()->user()->comments()->make(['text'=>$request['text']])->commentable()->associate($post)->save();
        if(! $comment){
            return back()->with('flash_message', '댓글 작성에 실패했습니다')->withInput();
        }
        return back();


    }
    public function destroy($id)
    {
        //
        $comment = \App\Comment::find($id);
        if(auth()->user() != $comment->authorable){
            return redirect(route('posts.index'))->with(['flash_message'=>'권한이 없습니다', 'flash_type'=>'danger'])->withInput();
        }
        $result = $comment->delete();
        if(!$result){
            return back()->with(['flash_message', '댓글을 삭제하지 못했습니다.', 'flash_type'=>'danger'])->withInput();
        }
        return back()->with('flash_message', '댓글을 삭제했습니다.')->withInput();

    }
}

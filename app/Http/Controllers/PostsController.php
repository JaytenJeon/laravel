<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = \App\Post::orderBy('id','desc')->paginate(10);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\StorePost $request)
    {
        //

        $images = null;
        if($request->has('images')) {
            $pattern = '/\((blob:.*?)\)/';
            $images = \App\Image::whereIn('id', $request->input('images'))->get();

            foreach ($images as $image){
//                $path = '('.url("images/{$image->name}").')';
                $path = '('.asset("storage/files/{$image->name}").')';

                $request['text'] = preg_replace($pattern, $path, $request['text'], 1);
            }
        }


        $post = auth()->user()->posts()->create($request->all());
        if(!$post){
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        if(! $images==null){
            $images->each(function ($image) use($post){
                $image->post()->associate($post);
                $image->save();
            });
//            echo dd($images);
        }else{

        }
        return redirect(route('posts.index'))->with('flash_message', '글이 저장되었습니다.')->withInput();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {
        //
        $post = \App\Post::find($id);
        if(!$post){
            return redirect(route('posts.index'))->with(['flash_message'=>'비정상적인 접근입니다.', 'flash_type'=>'danger']);
        }
        $comments = $post->comments()->get();
        return view('posts.show',compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $post = \App\Post::find($id);
        if(auth()->user()->id != $post->postable_id){
            return redirect(route('posts.index'))->with(['flash_message'=>'권한이 없습니다', 'flash_type'=>'danger'])->withInput();
        }
        return view('posts.edit',compact('post'));

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $pasedown = new \Parsedown();
        $pasedown ->setSafeMode(true);
        $request['text'] = $pasedown->text(htmlspecialchars($request['text']));
        $post = \App\Post::find($id);
        if(($post['postable_id']!=auth()->user()->id) || !$post){
            return redirect(route('posts.index'))->with(['flash_message'=>'권한이 없습니다', 'flash_type'=>'danger'])->withInput();

        }
        $result = $post->update($request->all());
        if(!$result){
            return back()->with(['flash_message', '글을 수정하지 못했습니다.', 'flash_type'=>'danger'])->withInput();
        }
        return redirect(route('posts.show',$id))->with('flash_message', '글을 수정했습니다.')->withInput();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = \App\Post::find($id);
        if(auth()->user()->id != $post->postable_id){
            return redirect(route('posts.index'))->with(['flash_message'=>'권한이 없습니다', 'flash_type'=>'danger'])->withInput();
        }
        $result = $post->delete();
        if(!$result){
            return back()->with(['flash_message', '글을 삭제하지 못했습니다.', 'flash_type'=>'danger'])->withInput();
        }
        return redirect(route('posts.index'))->with('flash_message', '글을 삭제했습니다.')->withInput();

    }
}

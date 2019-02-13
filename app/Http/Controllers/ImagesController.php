<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function store(Request $request)
    {
        //
        if(! $request->hasFile('files')){
            return response() -> json('File not found', 422);
        }

//        dd($request->file('files'));
        $files = $request->file('files');
        $images = array();
        foreach ($files as $file){
//            echo $file->getClientOriginalName();
            $origin_name = $file->getClientOriginalName();
            $name = time().'_'.str_replace(' ', '_',$origin_name);
            $path = $file->storeAs('public/files',$name);
            $image = \App\Image::create(['name'=> $name, 'origin_name'=> $origin_name]);
            $images[$image->id] = $path;
        }

        return response()->json($images);
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
    }
}

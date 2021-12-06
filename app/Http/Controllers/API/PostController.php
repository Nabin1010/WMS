<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Validator;


class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post :: all();
        return $this->sendResponse(new PostResource($posts), 'post listed successfully.');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [

            'title' => 'required',
            'task_details' =>'required',
            'status' =>'required',
            'user_id' => 'required',
            'remarks'=> 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $post = Post::create($input);
        return $this->sendResponse(new PostResource($post), 'post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post  = Post::find($id);
        if (is_null($post)) {
            return $this->sendError('role not found.');
        }
        return $this->sendResponse(new PostResource($post), 'post retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        // return $request;
        $post = Post::findOrFail($id);
        if (is_null($post)) {
            return $this->sendError('post not found.');
        }
        $input = $request->all();
        $validator = Validator::make($input,[
            'title' => 'required',
            'task_details' =>'required',
            'status' =>'required',
            'user_id' => 'required',
            'remarks'=> 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $post->title = $input['title'];
        $post->status = $input['status'];
        $post->task_details = $input['task_details'];
        $post->status = $input['status'];
        $post->remarks = $input['remarks'];
        $post->update();
        return $this->sendResponse(new PostResource($post), 'post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (is_null($post)) {
            return $this->sendError('post not found.');
        }
        $post->delete();
        return $this->sendResponse([], 'post deleted successfully.');
    }
}

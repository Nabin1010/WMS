<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\CommentResource;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment :: all();
        return $this->sendResponse(new CommentResource($comments), 'comments listed successfully.');
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

            
            'comment' =>'required',
            'post_id' =>'required',
            'user_id' => 'required',
          
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $comment = Comment::create($input);
        return $this->sendResponse(new CommentResource($comment), 'comment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment  = Comment::find($id);
        if (is_null($comment)) {
            return $this->sendError('comment not found.');
        }
        return $this->sendResponse(new CommentResource($comment), 'comment retrieved successfully.');
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
        $comment = Comment::findOrFail($id);
        if (is_null($comment)) {
            return $this->sendError('comment not found.');
        }
        $input = $request->all();
        $validator = Validator::make($input, [

            
            'comment' =>'required',
            'post_id' =>'required',
            'user_id' => 'required',
          
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $comment->comment = $input['comment'];
        $comment->post_id = $input['post_id'];
        $comment->user_id = $input['user_id'];
        $comment->update();
        return $this->sendResponse(new CommentResource($comment), 'comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (is_null($comment)) {
            return $this->sendError('comment not found.');
        }
        $comment->delete();
        return $this->sendResponse([], 'comment deleted successfully.');
    }
}

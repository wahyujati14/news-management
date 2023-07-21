<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Comment;

use Validator;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $news_id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
            ]);

        }
        
        $news = News::find($news_id);

        if (is_null($news)) {

            return response()->json([
                "success" => false,
                "message" => "News not found.",
            ]);

        }

        $comment = Comment::create([
            'keterangan' => $request->keterangan,
            'news_id' => $news->id,
            'created_by' => $request->user_id,
        ]);

        if($comment) {

            return response()->json([
                "success" => true,
                "message" => "Comment created successfully.",
            ]);

        } else {

            return response()->json([
                "success" => false,
                "message" => "Comment Create News."
            ]);

        }
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
        $input = $request->all();

        $validator = Validator::make($input, [
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
            ]);

        }
        
        $comment = Comment::find($id);

        if (is_null($comment)) {

            return response()->json([
                "success" => false,
                "message" => "Comment not found.",
            ]);

        }
    
        $update = $comment->update([
            'keterangan' => $request->keterangan,
            'updated_by' => $request->user_id,
        ]);

        if($update) {

            return response()->json([
                "success" => true,
                "message" => "Comment updated successfully.",
            ]);

        } else {

            return response()->json([
                "success" => false,
                "message" => "Failed Update Comment."
            ]);

        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (is_null($comment)) {

            return response()->json([
                "success" => false,
                "message" => "Comment not found.",
            ]);

        }
                    
        $update = $comment->update([
            'deleted_by' => $request->user_id,
        ]);

        $comment->delete();

        return response()->json([
            "success" => true,
            "message" => "Comment deleted successfully.",
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();
        return response()->json([
            "success" => true,
            "message" => "News List",
            "data" => $news
        ]);
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
            'judul' => 'required',
            'slug' => 'required',
            'gambar' => 'required',
            'deskripsi' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $news = News::create($input);
        return response()->json([
            "success" => true,
            "message" => "News created successfully.",
            "data" => $news
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);
        if (is_null($news)) {
            return $this->sendError('News not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "News retrieved successfully.",
            "data" => $news
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'judul' => 'required',
            'slug' => 'required',
            'gambar' => 'required',
            'deskripsi' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $news->name = $input['name'];
        $news->detail = $input['detail'];
        $news->save();
        return response()->json([
            "success" => true,
            "message" => "News updated successfully.",
            "data" => $news
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully.",
            "data" => $news
        ]);
    }
}

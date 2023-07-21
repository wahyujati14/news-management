<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Resources\NewsResource;
use App\Http\Resources\NewsDetailResource;

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
        $news = News::with('comment')->paginate(10);

        $data = NewsResource::collection($news->items());

        $pagination = collect([
            'page'  => $news->currentPage(),
            'total_page' => $news->lastPage(),
            'limit' => $news->perPage(),
            'total_data' => $news->total(),
        ]);
            
        $result = [
            'pagination'  => $pagination,
            'news' => $data,
        ];

        return response()->json([
            "success" => true,
            "message" => "News List",
            "data" => $result
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
            'gambar' => 'required|mimes:jpg,png,jpeg|max:2048',
            'deskripsi' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
            ]);

        }

        if($request->file('gambar')) {

            $gambar = time().'.'.$request->gambar->extension();  
       
            $request->gambar->move(public_path('uploads'), $gambar);
    
        } else {

            $gambar = '';  

        }
      
        $news = News::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
            'created_by' => $request->user_id,
        ]);

        if($news) {

            return response()->json([
                "success" => true,
                "message" => "News created successfully.",
            ]);

        } else {

            return response()->json([
                "success" => false,
                "message" => "Failed Create News."
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::with('comment')->find($id);
        if (is_null($news)) {

            return response()->json([
                "success" => false,
                "message" => "News not found.",
            ]);

        }

        $result = NewsDetailResource::make($news);

        return response()->json([
            "success" => true,
            "message" => "News retrieved successfully.",
            "data" => $result
        ]);
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
            'judul' => 'required',
            'gambar' => 'sometimes|mimes:jpg,png,jpeg|max:2048',
            'deskripsi' => 'required'
        ]);
        if ($validator->fails()) {

            return response()->json([
                "success" => false,
                "message" => $validator->errors(),
            ]);

        }
        
        $news = News::find($id);

        if (is_null($news)) {

            return response()->json([
                "success" => false,
                "message" => "News not found.",
            ]);

        }

        if($request->file('gambar')) {

            $gambar = time().'.'.$request->gambar->extension();  
       
            $request->gambar->move(public_path('uploads'), $gambar);
                    
            $update = $news->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambar,
                'updated_by' => $request->user_id,
            ]);
    
        } else {
                    
            $update = $news->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'updated_by' => $request->user_id,
            ]);

        }

        if($update) {

            return response()->json([
                "success" => true,
                "message" => "News updated successfully.",
            ]);

        } else {

            return response()->json([
                "success" => false,
                "message" => "Failed Update News."
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
        $news = News::find($id);

        if (is_null($news)) {

            return response()->json([
                "success" => false,
                "message" => "News not found.",
            ]);

        }
                    
        $update = $news->update([
            'deleted_by' => $request->user_id,
        ]);

        $news->delete();

        return response()->json([
            "success" => true,
            "message" => "News deleted successfully.",
        ]);
    }
}

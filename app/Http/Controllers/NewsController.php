<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News as AppNews;

use App\Http\Resources\NewsResource;

class NewsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $news = AppNews::latest()->paginate(5);

        return new NewsResource(true, 'List Data', $news);
    }
}

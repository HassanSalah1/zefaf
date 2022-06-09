<?php

namespace App\Http\Controllers\Api\Home;

use App\Entities\UserRoles;
use App\Http\Controllers\Controller;
use App\Services\Api\Home\ArticleApiService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //


    public function getArticles(Request $request){
        $data = $request->all();
        return ArticleApiService::getArticles($data);
    }

    public function getArticleData(Request $request , $id){
        $data = $request->all();
        $data['id'] = $id;
        return ArticleApiService::getArticleData($data);
    }

    public function downloadArticle(Request $request , $id){
        $data = $request->all();
        $data['id'] = $id;
        return ArticleApiService::downloadArticle($data);
    }

}

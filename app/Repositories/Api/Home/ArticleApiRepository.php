<?php

namespace App\Repositories\Api\Home;

use App\Entities\HttpCode;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CountryResource;
use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\App;
use PDF;

class ArticleApiRepository
{

    public static function getArticles(array $data)
    {
        if (isset($data['page']))
            $page = $data['page'];
        else
            $page = 1;
        $per_page = 20;
        $offset = $per_page * ($page - 1);
        $articles = Article::where(function ($query) use ($data) {
            if (isset($data['keyword'])) {
                $query->where('title_ar' , 'LIKE', '%'. $data['keyword']. '%');
                $query->orWhere('title_en' , 'LIKE', '%'. $data['keyword']. '%');
            }
        })->orderBy('id', 'desc');
        $count = $articles->get()->count();
        $articles = $articles->offset($offset)
            ->skip($offset)
            ->take($per_page)
            ->get();
        $articles = new Paginator(CountryResource::collection($articles), $count, $per_page);
        return [
            'data' => $articles,
            'message' => 'success',
            'code' => HttpCode::SUCCESS
        ];
    }

    public static function getArticleData(array $data)
    {
        $article = Article::where(['id' => $data['id']])->first();
        if ($article) {
            $article = new ArticleResource($article);
            return [
                'data' => $article,
                'message' => 'success',
                'code' => HttpCode::SUCCESS
            ];
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }


    public static function downloadArticle(array $data)
    {
        $article = Article::where(['id' => $data['id']])->first();
        if ($article) {
            return PDF::loadHTML((App::getLocale() === 'ar' ? '<html dir="rtl">' : '<html>') . '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>body { font-family: DejaVu Sans, sans-serif; }</style></head><body>' . $article->description)
                ->setPaper('a4', 'landscape')
                ->setWarnings(true)
                ->download($article->title_en . '_' . time() . '.pdf');
        }
        return [
            'message' => trans('api.general_error_message'),
            'code' => HttpCode::ERROR
        ];
    }
}

<?php

namespace App\Services\Api\Home;

use App\Repositories\Api\Home\ArticleApiRepository;
use App\Repositories\General\UtilsRepository;

class ArticleApiService
{


    public static function getArticles(array $data)
    {
        $response = ArticleApiRepository::getArticles($data);
        return UtilsRepository::handleResponseApi($response);
    }

    public static function getArticleData(array $data)
    {
        $response = ArticleApiRepository::getArticleData($data);
        return UtilsRepository::handleResponseApi($response);
    }


    public static function downloadArticle(array $data)
    {
        $response = ArticleApiRepository::downloadArticle($data);
        return $response;
    }
}

?>

<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Services\Api\Client\ActionService;
use Illuminate\Http\Request;

class ActionController extends Controller
{

    public function setWeddingDate(Request $request)
    {
        $data = $request->all();
        return ActionService::setWeddingDate($data);
    }

    public function getWeddingDate(Request $request)
    {
        $data = $request->all();
        return ActionService::getWeddingDate($data);
    }

    public function setPartner(Request $request)
    {
        $data = $request->all();
        return ActionService::setPartner($data);
    }

    public function getCategoryTips(Request $request)
    {
        $data = $request->all();
        return ActionService::getCategoryTips($data);
    }

    public function getCategories(Request $request)
    {
        $data = $request->all();
        return ActionService::getCategories($data);
    }


    public function getSubCategories(Request $request)
    {
        $data = $request->all();
        return ActionService::getSubCategories($data);
    }

    public function clickCategories(Request $request)
    {
        $data = $request->all();
        return ActionService::clickCategories($data);
    }

}

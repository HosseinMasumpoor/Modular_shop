<?php

namespace Modules\Blog\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Modules\Blog\Http\Requests\v1\Article\StoreArticleRequest;
use Modules\Blog\Http\Requests\v1\Article\UpdateArticleRequest;
use Modules\Blog\Services\BlogService;
use Modules\Core\Http\Controllers\CoreController;

class BlogController extends CoreController
{
    public function __construct(private readonly BlogService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->service->list()->paginate(config('app.default_paginate_number', 10));
        return successResponse($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request) {
        $data = $request->validated();
        $result = $this->service->store($data);
        if($result){
            return successResponse($result);
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return $this->service->getItem($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, $id) {
        $data = $request->validated();
        $result = $this->service->update($id, $data);
        if($result){
            return successResponse($result);
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $result = $this->service->delete($id);
        if($result){
            return successResponse([]);
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    public function getImage($id){
        $image = $this->service->getImage($id);
        return fileResponse($image);
    }

    public function getThumbnail($id){
        $thumbnail = $this->service->getThumbnail($id);
        return fileResponse($thumbnail);
    }
}

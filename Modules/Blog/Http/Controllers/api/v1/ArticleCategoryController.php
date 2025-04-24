<?php

namespace Modules\Blog\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Http\Requests\V1\Category\ArticleCategoryRequest;
use Modules\Blog\Services\ArticleCategoryService;
use Modules\Core\Http\Controllers\CoreController;

class ArticleCategoryController extends CoreController
{
    public function __construct(private readonly ArticleCategoryService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->list()->paginate(config('app.default_paginate_number', 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleCategoryRequest $request) {
        $data = $request->validated();
        $result = $this->service->store($data);
        if($result) {
            return successResponse($result, __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleCategoryRequest $request, $id) {
        $data = $request->validated();
        $result = $this->service->update($id, $data);
        if($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $result = $this->service->delete($id);
        if($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }
}

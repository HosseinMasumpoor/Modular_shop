<?php

namespace Modules\Category\Http\Controllers\v1;

use Modules\Category\Http\Requests\v1\StoreCategoryRequest;
use Modules\Category\Http\Requests\v1\UpdateCategoryRequest;
use Modules\Category\Services\CategoryService;
use Modules\Core\Http\Controllers\CoreController;

class CategoryController extends CoreController
{
    public function __construct(private readonly CategoryService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->service->list()->paginate(config('app.default_paginate_number', 10));
        return successResponse($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $result = $this->service->store($request->validated());
        if ($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        } else {
            return failedResponse(self::ERROR_RESPONSE);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $result = $this->service->update($request->validated(), $id);
        if ($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        } else {
            return failedResponse(self::ERROR_RESPONSE);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->service->delete($id);
        if ($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        } else {
            return failedResponse(__(self::ERROR_RESPONSE));
        }
    }
}

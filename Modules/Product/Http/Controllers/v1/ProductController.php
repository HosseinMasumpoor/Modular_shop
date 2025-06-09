<?php

namespace Modules\Product\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Enums\ResponseCode;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Product\Http\Requests\Product\ProductStoreRequest;
use Modules\Product\Http\Requests\Product\ProductUpdateRequest;
use Modules\Product\Services\ProductService;

class ProductController extends CoreController
{
    public function __construct(private readonly ProductService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->service->list()->paginate($request->per_page ?? config('app.default_paginate_number'));
        return successResponse($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $result = $this->service->store($request->validated());
        if($result){
            return successResponse([], __(self::SUCCESS_RESPONSE), ResponseCode::CREATED);
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = $this->service->findById($id);
        return successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $result = $this->service->update($id, $request->validated());
        if($result){
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->service->delete($id);
        if($result){
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }
}

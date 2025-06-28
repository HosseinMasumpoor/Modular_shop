<?php

namespace Modules\Product\Http\Controllers\v1;

use Illuminate\Http\Request;
use Modules\Core\Enums\ResponseCode;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Product\Http\Requests\Brand\BrandStoreRequest;
use Modules\Product\Http\Requests\Brand\BrandUpdateRequest;
use Modules\Product\Services\BrandService;

class BrandController extends CoreController
{
    public function __construct(private readonly BrandService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->service->list()->get();
        return successResponse($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
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
    public function update(BrandUpdateRequest $request, $id)
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

    public function getLogo(string $id)
    {
        $logo =  $this->service->getLogo($id);
        return fileResponse($logo);
    }
}

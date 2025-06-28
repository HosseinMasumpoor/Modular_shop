<?php

namespace Modules\Product\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Core\Enums\ResponseCode;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Product\Http\Requests\v1\ProductAttribute\ProductAttributeStoreRequest;
use Modules\Product\Http\Requests\v1\ProductAttribute\ProductAttributeUpdateRequest;
use Modules\Product\Services\ProductAttributeService;

class ProductAttributeController extends CoreController
{

    public function __construct(private readonly ProductAttributeService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $productId)
    {
        $data = $this->service->findByProductId($productId);
        return successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeStoreRequest $request) {
        $data = $request->validated();
        $result = $this->service->store($data);

        if($result)
        {
            return successResponse([], __(self::SUCCESS_RESPONSE), ResponseCode::CREATED);
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $result = $this->service->findById($id);
        return successResponse($result);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeUpdateRequest $request, $id) {
        $data = $request->validated();
        $result = $this->service->update($id, $data);
        if($result)
        {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $result = $this->service->delete($id);
        if($result)
        {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }
}

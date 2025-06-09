<?php

namespace Modules\FAQ\Http\Controllers\v1;


use Modules\Core\Http\Controllers\CoreController;
use Modules\FAQ\Http\Requests\v1\StoreFAQRequest;
use Modules\FAQ\Http\Requests\v1\UpdateFAQRequest;
use Modules\FAQ\Services\FAQService;

class FAQController extends CoreController
{
    public function __construct(private readonly FAQService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = $this->service->list()->paginate(config('core.pagination_number'));
        return successResponse($faqs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFAQRequest $request)
    {
        $result = $this->service->store($request->validated());
        if ($result) {
            return successResponse($result, __(self::SUCCESS_RESPONSE));
        } else {
            return failedResponse(__(self::ERROR_RESPONSE));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFAQRequest $request, string $id)
    {
        $result = $this->service->update($id, $request->validated());
        if ($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        } else {
            return failedResponse(__(self::ERROR_RESPONSE));
        }
    }

    public function changeOrder(string $id, string $substituteId)
    {
        $result = $this->service->changeOrder($id, $substituteId);
        if ($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        } else {
            return failedResponse(__(self::ERROR_RESPONSE));
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

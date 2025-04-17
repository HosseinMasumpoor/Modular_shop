<?php

namespace Modules\Role\Http\Controllers\v1;

use Modules\Core\Http\Controllers\CoreController;
use Modules\Role\Http\Requests\v1\RoleRequest;
use Modules\Role\Repositories\RoleRepository;

class RoleController extends CoreController
{
    public function __construct(protected RoleRepository $repository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->repository->index()->paginate(config('app.default_paginate_number', 10));
        return successResponse($roles);
    }

    public function show($id){
        $record =$this->repository->findByField('id', $id);
        return successResponse($record);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) {
        $data = $request->validated();
        $result = $this->repository->newItem($data);
        if($result) {
            return successResponse($result, __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $id) {
        $data = $request->validated();
        $result = $this->repository->updateItem($id, $data);
        if($result) {
            return successResponse([], __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $record = $this->repository->remove($id);
        if($record){
            return successResponse($record, __(self::SUCCESS_RESPONSE));
        }
        return failedResponse(__(self::ERROR_RESPONSE));
    }
}

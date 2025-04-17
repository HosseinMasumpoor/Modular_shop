<?php

namespace Modules\Admin\Http\Controllers\v1;

use Modules\Admin\Http\Requests\V1\LoginAdminRequest;
use Modules\Admin\Http\Requests\V1\StoreAdminRequest;
use Modules\Admin\Http\Requests\V1\UpdateAdminRequest;
use Modules\Admin\Repositories\AdminRepository;
use Modules\Core\Enums\ResponseCode;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Role\Repositories\AdminRoleRepository;
use Modules\Role\Traits\CheckPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends CoreController
{
    use CheckPermission;

    public function __construct(protected AdminRepository $repository, protected AdminRoleRepository $roleRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

//         if (!$this->can("read-admin")) {
//             return failedResponse("", ResponseCode::NOT_ACCESS);
//         };


        $list = $this->repository->index()->paginate(config('app.default_paginate_number', 10));
        return successResponse($list);

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
    public function update(UpdateAdminRequest $request, string $id)
    {
        $data = $request->validated();

        if(isset($data["password"])){
            $data["password"] = Hash::make($data["password"]);
        }

        if(isset($data["role_id"])){
            $this->roleRepository->updateItem($id, [
                "role_id" => $data["role_id"],
                "admin_id" => $id
            ]);
        }

        $result = $this->repository->updateItem($id, $data);
        return successResponse($result, __(self::SUCCESS_RESPONSE));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {

    }

    public function loginAdmin(LoginAdminRequest $request)
    {
        $data = $request->validated();
        $admin = $this->repository->findByField('username', $data['username']);

        if(!$admin || !Hash::check($data['password'], $admin->password)) {
            return failedResponse(__('admin::messages.login.invalid'));
        }

        $token = $admin->createToken("authTokenAdmin")->plainTextToken;
        $admin['token'] = "Bearer " . $token;

        return successResponse($admin, __('admin::messages.login.success'));
    }

    public function store(StoreAdminRequest $request)
    {
        $request->merge([
            'password' => Hash::make($request->password),
        ]);
        $admin = $this->repository->newItem([
            "username" => $request->username,
            "name" => $request->name,
            "password" => $request->password,
        ]);

        if ($request->has("role_id")) {
            $this->roleRepository->newItem([
                "admin_id" => $admin->id,
                "role_id" => $request->role_id
            ]);
        }

        return successResponse($admin, __(self::SUCCESS_RESPONSE));
    }
}

<?php

namespace Modules\Role\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Role\Http\Requests\v1\RolePermissionsRequest;
use Modules\Role\Repositories\RolePermissionRepository;
use Throwable;

class RolePermissionController extends CoreController
{
    public function __construct(private RolePermissionRepository $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('role::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RolePermissionsRequest $request) {
        $data = $request->validated();
        $roleId = $data['role_id'];
        try {
            DB::beginTransaction();
            $this->repository->remove($roleId);
            foreach($data['permissions'] as $permission) {
                $this->repository->newItem([
                    'role_id' => $roleId,
                    'permission_id' => $permission['id']
                ]);
            }
            DB::commit();

            return successResponse([], __(self::SUCCESS_RESPONSE));
        }catch(Throwable){
            DB::rollBack();
            return failedResponse(__(self::ERROR_RESPONSE));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}

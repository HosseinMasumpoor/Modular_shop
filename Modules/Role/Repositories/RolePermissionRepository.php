<?php

namespace Modules\Role\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Repository;
use Modules\Role\Models\RolePermission;

class RolePermissionRepository extends Repository
{
    public string|Model $model = RolePermission::class;

    public function remove($roleId): int
    {
        return $this->query()->where('role_id', $roleId)->delete();
    }
}

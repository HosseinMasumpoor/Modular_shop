<?php

namespace Modules\Role\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Repository;
use Modules\Role\Models\Permission;

class PermissionRepository extends Repository
{
    public string|Model $model = Permission::class;
}

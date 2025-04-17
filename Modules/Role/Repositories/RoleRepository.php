<?php

namespace Modules\Role\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Repository;
use Modules\Role\Models\Role;

class RoleRepository extends Repository
{
    public string|Model $model = Role::class;
}

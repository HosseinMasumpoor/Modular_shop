<?php

namespace Modules\Role\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait CheckPermission
{
    private function can(string $permission): bool
    {
        $adminId = auth('admin')->id();
        $query = "select permissions.key from permissions
                inner join role_permissions on permissions.id = role_permissions.permission_id
                inner join roles on roles.id = role_permissions.role_id
                inner join admin_roles on roles.id = admin_roles.role_id
                inner join admins on admins.id = admin_roles.admin_id
                where admins.id = $adminId";

        $keys = Arr::pluck(DB::select($query),'key');

        return in_array($permission, $keys);
    }
}

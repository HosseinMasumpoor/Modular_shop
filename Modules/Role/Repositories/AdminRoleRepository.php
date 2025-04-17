<?php

namespace Modules\Role\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Repositories\Repository;
use Modules\Role\Models\AdminRole;

class AdminRoleRepository extends Repository
{
    public string|Model $model = AdminRole::class;

    public function updateItem($adminId, $data)
    {
        $record = $this->findByField("admin_id", $adminId);

        foreach ($data as $key => $value) {
            $record->{$key} = $value;
        }

        return $record->save();
    }
}

<?php

namespace Modules\Admin\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;
use Modules\Admin\Models\Admin;
use Modules\Core\Interfaces\RepositoryInterface;
use Modules\Core\Repositories\Repository;

class AdminRepository extends Repository
{
    public string|Model $model = Admin::class;
}

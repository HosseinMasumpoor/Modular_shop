<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Role\Database\Factories\AdminRoleFactory;

class AdminRole extends Model
{
    use HasFactory;
    protected $table = 'admin_roles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): AdminRoleFactory
    // {
    //     // return AdminRoleFactory::new();
    // }
}

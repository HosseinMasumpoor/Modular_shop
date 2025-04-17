<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Role\Database\Factories\RolePermissionFactory;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'role_permissions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): RolePermissionFactory
    // {
    //     // return RolePermissionFactory::new();
    // }
}

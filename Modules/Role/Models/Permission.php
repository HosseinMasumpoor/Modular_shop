<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Role\Database\Factories\PermissionFactory;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): PermissionFactory
    // {
    //     // return PermissionFactory::new();
    // }
}

<?php

namespace Modules\Role\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Role\Database\Factories\RoleFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): RoleFactory
    // {
    //     // return RoleFactory::new();
    // }
}

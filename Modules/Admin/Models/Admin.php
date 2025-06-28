<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\Factories\AdminFactory;
use Modules\Role\Models\AdminRole;
use Modules\Role\Models\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{

    use HasFactory, SoftDeletes,HasApiTokens,Notifiable,Authenticatable;
    protected $guarded=[];
    protected $hidden=['password'];

    protected $fillable=[
        "name",
        "username",
        "password",
        "role_id",
    ];

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }


    public function role(): HasOneThrough
    {
        return $this->hasOneThrough(Role::class,AdminRole::class,"admin_id","id","","role_id");
    }

}

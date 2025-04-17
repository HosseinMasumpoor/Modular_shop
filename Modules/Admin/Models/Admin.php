<?php

namespace Modules\Admin\Models;

use Modules\Role\Models\AdminRole;
use Modules\Role\Models\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{

    use SoftDeletes,HasApiTokens,Notifiable,Authenticatable;
    protected $guarded=[];
    protected $hidden=['password'];

    protected $fillable=[
        "name",
        "username",
        "password",
        "role_id",
    ];


    public function role(): HasOneThrough
    {
        return $this->hasOneThrough(Role::class,AdminRole::class,"admin_id","id","","role_id");
    }

}

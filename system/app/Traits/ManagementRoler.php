<?php

namespace App\Traits;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

trait ManagementRoler
{
    public function newRole($guard_name, $name)
    {
        $response = Role::firstOrCreate(['guard_name' => $guard_name, 'name' => $name]);
        return $response;
    }
    public function createRole($models, $role)
    {
        $models->assignRole($role);
    }
    public function create_role_users($result, $role)
    {
        if (!$roler = $this->newRole("api", $role))
            return ["error" => "role instansi could not be created"];
        $m = \App\Models\User::find($result['data']['user_id']);
        $this->createRole($m, $roler);
    }
}

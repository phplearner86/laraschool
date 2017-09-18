<?php  

namespace App\Observers;

use App\Role;

class RoleObserver{

    public function creating(Role $role)
    {
        $role->slug = str_slug($role->name);
    }
}
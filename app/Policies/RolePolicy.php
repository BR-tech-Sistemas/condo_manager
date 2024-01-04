<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy extends BasePolicy
{
    public string $permission = 'roles';
}

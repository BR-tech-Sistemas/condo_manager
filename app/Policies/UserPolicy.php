<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends BasePolicy
{
    public ?string $permission = 'users';
}

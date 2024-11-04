<?php

namespace App\Policies;

use App\Models\Rule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RulePolicy extends BasePolicy
{
    public ?string $permission = 'rules';
}

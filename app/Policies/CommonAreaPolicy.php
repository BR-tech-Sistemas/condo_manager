<?php

namespace App\Policies;

use App\Models\CommonArea;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommonAreaPolicy extends BasePolicy
{
    public ?string $permission = 'common-areas';
}

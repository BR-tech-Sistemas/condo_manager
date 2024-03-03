<?php

namespace App\Policies;

use App\Models\Annoucement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy extends BasePolicy
{
    public ?string $permission = 'announcements';
}

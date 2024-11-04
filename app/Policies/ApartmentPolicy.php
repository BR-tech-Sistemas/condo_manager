<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ApartmentPolicy extends BasePolicy
{
    public ?string $permission = 'apartments';

    public function update(User $user, ?Model $model = null)
    {
        if ($user->hasAnyRole(['super-admin', 'admin', 'Síndico'])) {
            return true;
        }

        return $user->hasPermissionTo("{$this->permission} edit") or $user->apartments->contains($model->id);
    }
}

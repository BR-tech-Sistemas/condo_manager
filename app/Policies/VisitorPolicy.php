<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class VisitorPolicy extends BasePolicy
{
    public ?string $permission = 'visitors';

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function update(User $user, ?Model $model = null): bool
    {
        if ($user->hasAnyRole(['super-admin', 'admin', 'Síndico'])) {
            return true;
        }

        return $user->hasPermissionTo("{$this->permission} edit") and $user->apartments->contains($model->apartment_id);
    }
}

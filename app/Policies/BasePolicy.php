<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
    public ?string $permission = null;

    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isSuperAdmin() || is_null($this->permission)) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function viewAny(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} list");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function view(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} list");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function create(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function update(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} edit");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function delete(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} delete");
    }

    /**
     * Determine whether the user can delete whatever model.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function deleteAny(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} delete");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function restore(User $user, ?Model $model = null)
    {
        return $user->hasPermissionTo("{$this->permission} restore");
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Model|null $model
     * @return bool
     */
    public function forceDelete(User $user, ?Model $model = null): bool
    {
        return $user->hasPermissionTo("{$this->permission} delete");
    }
}

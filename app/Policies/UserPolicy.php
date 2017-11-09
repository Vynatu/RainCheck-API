<?php

namespace RainCheck\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use RainCheck\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Gives all access to an administrator to this resource.
     *
     * @param \RainCheck\Models\User $user
     * @param string                 $ability
     *
     * @return bool|void
     */
    public function before(User $user, string $ability)
    {
        if ($user->is_admin && $ability != 'delete') return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \RainCheck\Models\User $user
     * @param  \RainCheck\Models\User $model
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \RainCheck\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \RainCheck\Models\User $user
     * @param  \RainCheck\Models\User $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \RainCheck\Models\User $user
     * @param  \RainCheck\Models\User $model
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        // Prevent deletion of itself
        return $user->is_admin && $user->id != $model->id;
    }
}

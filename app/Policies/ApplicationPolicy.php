<?php

namespace App\Policies;

use App\Application;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any resources.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the resource.
     *
     * @param  \App\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        //
    }

    /**
     * Determine whether the user can create resources.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param  \App\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function update(User $user, Application $application)
    {
        if($user->roles()->first()->type == 1){
            return true;
        }else{
            return $user->id === $application->user_id;   
        }
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  \App\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function delete(User $user, Application $application)
    {
        if($user->roles()->first()->type == 1){
            return true;
        }else{
            return $user->id === $application->user_id;   
        }
    }

    /**
     * Determine whether the user can restore the resource.
     *
     * @param  \App\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function restore(User $user, Application $application)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the resource.
     *
     * @param  \App\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function forceDelete(User $user, Application $application)
    {
        //
    }
}

<?php

namespace App\Policies;

use App\BusinessProposal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessProposalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any business proposals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the business proposal.
     *
     * @param  \App\User  $user
     * @param  \App\BusinessProposal  $businessProposal
     * @return mixed
     */
    public function view(User $user, BusinessProposal $businessProposal)
    {
        if($user->roles()->first()->type == 1){
            return true;
        }elseif($user->id === $businessProposal->user_id){
            return true;
        }else{
            return $businessProposal->is_approved === 1;   
        }
    }

    /**
     * Determine whether the user can create business proposals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the business proposal.
     *
     * @param  \App\User  $user
     * @param  \App\BusinessProposal  $businessProposal
     * @return mixed
     */
    public function update(User $user, BusinessProposal $businessProposal)
    {
        if($user->roles()->first()->type == 1){
            return true;
        }else{
            return $user->id === $businessProposal->user_id;   
        }
    }

    

    /**
     * Determine whether the user can delete the business proposal.
     *
     * @param  \App\User  $user
     * @param  \App\BusinessProposal  $businessProposal
     * @return mixed
     */
    public function delete(User $user, BusinessProposal $businessProposal)
    {
        if($user->roles()->first()->type == 1){
            return true;
        }else{
            return $user->id === $businessProposal->user_id;   
        }
    }

    /**
     * Determine whether the user can restore the business proposal.
     *
     * @param  \App\User  $user
     * @param  \App\BusinessProposal  $businessProposal
     * @return mixed
     */
    public function restore(User $user, BusinessProposal $businessProposal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the business proposal.
     *
     * @param  \App\User  $user
     * @param  \App\BusinessProposal  $businessProposal
     * @return mixed
     */
    public function forceDelete(User $user, BusinessProposal $businessProposal)
    {
        //
    }
}

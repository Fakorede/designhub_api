<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invitation  $invitation
     * @return mixed
     */
    public function update(User $user, Invitation $invitation)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invitation  $invitation
     * @return mixed
     */
    public function delete(User $user, Invitation $invitation)
    {
        return $invitation->sender_id === $user->id;
    }

    /**
     * Determine whether the user can respond to invitation
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invitation  $invitation
     * @return mixed
     */
    public function respond(User $user, Invitation $invitation)
    {
        return $invitation->recipient_email === $user->email;
    }

    /**
     * Determine whether the user can resend invitation
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invitation  $invitation
     * @return mixed
     */
    public function resend(User $user, Invitation $invitation)
    {
        return $user->isOwnerOfTeam($invitation->team);
    }

    
}

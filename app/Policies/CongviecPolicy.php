<?php

namespace App\Policies;

use App\User;
use App\Congviec;
use Illuminate\Auth\Access\HandlesAuthorization;

class CongviecPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the congviec.
     *
     * @param  \App\User  $user
     * @param  \App\Congviec  $congviec
     * @return mixed
     */
    public function congviec_index(User $user)
    {
        return TRUE;
    }
}

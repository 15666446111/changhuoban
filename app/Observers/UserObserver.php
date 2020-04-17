<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     * 1. Init User Wallet Table Datas
     * 2. Init User Relation Table Datas.
     * 3. Init User RelaName Table Datas.
     * @param  \App\App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        /* 1. Init User Wallet*/
        \App\UserWallet::create([ 'user_id'   =>  $user->id ]);

        /* 2. Init User Relation*/
        \App\UserRelation::create([ 'user_id' =>  $user->id, 'parents' => User::getParentStr($user->parent) ]);

        /* 3. Init uSER Rela Name*/
        \App\UserRealname::create([ 'user_id'   =>  $user->id ]);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}

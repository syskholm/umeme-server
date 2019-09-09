<?php

namespace App\Observers;

use App\Data\Models\Admin;

class AdminObserver
{
    /**
     * Handle the Admin retrieve event and add User attributes to an admin.
     *
     * @param  \App\Data\Models\Admin  $adminUser
     */
    public function retrieved(Admin $adminUser)
    {
        $attributes = $adminUser->user()->get()->first()->toArray();
        unset($attributes['id'], $attributes['email']);
        foreach ($attributes as $key => $value) {
            $adminUser->setAttribute($key, $value);
        }
    }
}

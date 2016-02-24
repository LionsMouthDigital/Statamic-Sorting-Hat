<?php

namespace Statamic\Addons\SortingHat;

use Statamic\API\UserGroups;
use Statamic\Extend\Listener;

class SortingHatListener extends Listener
{
    /**
     * The events to be listened for, and the methods to call.
     *
     * @var array
     */
    public $events = [
        'user.registered' => 'register',
    ];

    public function register($user)
    {
        // Don't try to do anything if there's nothing to do.
        if (empty(array_get($_POST, 'sorting_hat'))) {
            return;
        }

        $groups = array_get($_POST, 'sorting_hat.groups', []);
        $roles  = array_get($_POST, 'sorting_hat.roles', []);

        // Add the user to each of the specified groups.
        foreach ($groups as $group) {
            $group = UserGroups::get($group);
            $group->addUser($user);
            $group->save();
        }

        // Combine existing roles with those newly assigned w/o duplicating any.
        $roles = array_values(array_unique(array_merge(
            $roles,
            $user->get('roles', [])
        )));
        // Set the user roles and save.
        $user->set('roles', $roles);
        $user->save();
    }
}

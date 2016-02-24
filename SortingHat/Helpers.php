<?php

namespace Statamic\Addons\SortingHat;

use Statamic\Extend\Addon;

use Statamic\API\Roles;
use Statamic\API\UserGroups;

class Helpers extends Addon
{
    /**
     * Get a Role ID from its slug.
     *
     * @author Curtis Blackwell
     * @param  string $roleSlug
     * @return String
     */
    public static function getRoleId($roleSlug)
    {
        return Roles::slug($roleSlug)->uuid();
    }

    /**
     * Get a UserGroup ID from its slug.
     *
     * @author Curtis Blackwell
     * @param  string $groupSlug
     * @return String
     */
    public static function getGroupId($groupSlug)
    {
        return UserGroups::slug($groupSlug)->uuid();
    }
}

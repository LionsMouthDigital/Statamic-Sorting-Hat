<?php

namespace Statamic\Addons\SortingHat;

use Statamic\Addons\SortingHat\Forms as SortingHatForms;
use Statamic\Addons\SortingHat\Helpers as SortingHat;
use Statamic\Extend\Tags;

/**
 * Anters tags for The Sorting Hat.
 */
class SortingHatTags extends Tags
{
    /**
     * Pseudo-constructor.
     *
     * @author Curtis Blackwell
     * @return void
     * @ignore
     */
    public function init()
    {
        $this->forms = new SortingHatForms;
    }

    /**
     * Generate an HTML input to help assign new registrants to roles/groups.
     *
     * @author Curtis Blackwell
     * @param string $name  The input's name.
     * @param string $value The role/group's slug. Pipe-separate for multiple.
     * @return string
     */
    public function field()
    {
        $name   = $this->getParam('name');
        $values = $this->getList(['value', 'values']);

        $inputs = '';
        // Replace slugs with IDs to prevent jerks from manipulating the system.
        foreach ($values as $value) {
            switch ($name) {
                case 'role':
                case 'roles':
                    $value = SortingHat::getRoleId($value);
                    break;

                case 'group':
                case 'groups':
                    $value = SortingHat::getGroupId($value);
                    break;
            }

            $inputs .= $this->forms->generateInput($name, $value);
        }

        return $inputs;
    }
}

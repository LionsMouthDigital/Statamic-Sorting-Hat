<?php

namespace Statamic\Addons\SortingHat;

use Statamic\Addons\SortingHat\Forms as SortingHatForms;
use Statamic\Addons\SortingHat\Helpers as SortingHat;
use Statamic\API\Parse;
use Statamic\API\UserGroups;
use Statamic\Extend\Tags;

/**
 * Antlers tags for The Sorting Hat.
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

    /**
     * Loop through all User Groups and their data.
     *
     * @author Curtis Blackwell
     * @param boolean $useContext Whether to use the current context.
     * @return string
     */
    public function userGroups()
    {
        // Figure out the appropriate context value.
        $useContext = $this->getParamBool(['use_context', 'context']);
        $context    = $useContext ? $this->context : [];

        // Convert all user groups' data to Antlers array.
        $userGroups = UserGroups::all();
        foreach ($userGroups as &$userGroup) {
            $tags[] = $userGroup->toArray();
        }

        // _____ly, sage, rosemary and thyme.
        return Parse::templateLoop($this->content, $tags, null, $context);
    }

    /**
     * Get the data for a specified User Group.
     *
     * @author Curtis Blackwell
     * @param string  $title      The User Group's title.
     * @param string  $slug       The User Group's slug.
     *                            `title` has priority.
     * @param boolean $useContext Whether to use the current context.
     * @return string|boolean     Parsed template or whether the group exists.
     */
    public function userGroup()
    {
        $title = $this->getParam(['title', 'name', 'group']);
        $slug  = $this->getParam('slug');

        // Figure out the appropriate context value.
        $useContext = $this->getParamBool(['use_context', 'context']);
        $context    = $useContext ? $this->context : [];

        $userGroup = isset($title)
            ? UserGroups::get($title)
            : UserGroups::slug($slug);

        // If not a tag pair, this should be a conditional. Check to see if
        // the specified group exists.
        if (!$this->content) {
            return isset($userGroup);
        }

        // Parsupial. Returns false if no User Group found.
        return isset($userGroup)
            ? Parse::template($this->content, $userGroup->toArray(), $context)
            : null;
    }
}

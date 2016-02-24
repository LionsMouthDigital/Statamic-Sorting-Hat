<?php

namespace Statamic\Addons\SortingHat;

use Statamic\Extend\Addon;

class Forms extends Addon
{
    /**
     * Generate an input for use with The Sorting Hat.
     *
     * @author Curtis Blackwell
     * @param  string $name  The value of the name attribute.
     * @param  string $value The value of the value attribute.
     * @return string
     */
    public function generateInput($name, $value)
    {
        $i = $this->flash->get($name, 0);

        $input = '<input type="hidden" name="sorting_hat['.$name.']['.$i.']" value="'.$value.'">';

        $i++;
        $this->flash->put($name, $i);

        return $input;
    }
}

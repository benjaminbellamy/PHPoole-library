<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Menu;

use PHPoole\Collection\AbstractItem;
use ArrayAccess;
use PHPoole\Collection\ItemArrayAccessTrait;

/**
 * Class Entry
 * @package PHPoole\Menu
 */
class Entry extends AbstractItem implements ArrayAccess
{
    use ItemArrayAccessTrait;

    /**
     * Set menu entry name
     *
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        $this->properties['name'] = $value;
        return $this;
    }

    /**
     * Set menu entry URL
     *
     * @param $value
     * @return $this
     */
    public function setUrl($value)
    {
        $this->properties['url'] = $value;
        return $this;
    }

    /**
     * Set menu entry weight
     *
     * @param $value
     * @return $this
     */
    public function setWeight($value)
    {
        $this->properties['weight'] = $value;
        return $this;
    }
}
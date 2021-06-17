<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade\itemtype;

use pocketmine\item\Item;

interface ItemType {

    /**
     * Check whether or not an item falls under the item type
     *
     * @param Item $item
     * @return bool
     */
    public function isOfType(Item $item) : bool;

}
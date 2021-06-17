<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade\itemtype;

use AndreasHGK\Mana\utils\Set;
use pocketmine\item\Item;

class IDType implements ItemType {

    private Set $ids;

    public function __construct(array $ids) {
        $this->ids = Set::create($ids);
    }

    public function isOfType(Item $item) : bool {
        return $this->ids[$item->getId()];
    }

}
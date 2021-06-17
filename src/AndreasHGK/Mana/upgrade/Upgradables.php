<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade;

use pocketmine\item\Item;

class Upgradables {

    /** @var Upgradable[] */
    private array $list;

    /**
     * Add an upgradable object to the list
     * These usually dont need to be removed
     *
     * @param Upgradable $u
     */
    public function add(Upgradable $u) : void {
        $this->list[] = $u;
    }

    /**
     * Get all upgradables
     *
     * @return Upgradable[]
     */
    public function getAll() : array {
        return $this->list;
    }

    /**
     * Try to find the right category for an item
     *
     * @param Item $item
     * @return Upgradable|null
     */
    public function matchItem(Item $item) : ?Upgradable {
        foreach($this->list as $v) {
            if($v->getItemType()->isOfType($item)) return $v;
        }
        return null;
    }

}
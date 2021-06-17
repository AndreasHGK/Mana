<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade;

use AndreasHGK\Mana\upgrade\itemtype\ItemType;

class Upgradable {

    private ItemType $itemType;

    /** @var Upgrade[] */
    private array $upgrades;

    public function __construct(ItemType $itemType, array $upgrades) {
        $this->itemType = $itemType;
        $this->upgrades = $upgrades;
    }

    /**
     * Get the item type that these upgrades apply to
     *
     * @return ItemType
     */
    public function getItemType() : ItemType {
        return $this->itemType;
    }

    /**
     * Get all the upgrades that the user can choose from for this item type
     *
     * @return Upgrade[]
     */
    public function getUpgrades() : array {
        return $this->upgrades;
    }

}
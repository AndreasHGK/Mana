<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade;

use pocketmine\item\Item;

interface Upgrade {

    /**
     * Get the actual name of the upgrade,
     * for example 'Efficiency' if this upgrades efficiency on an item
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Get the display name, can include the level
     *
     * @param int $level
     * @return string
     */
    public function getDisplayName(int $level) : string;

    /**
     * Get the text that should appear on form buttons when doing /upgrade
     * Exclude the price in mana for this
     *
     * @param int $level
     * @return string
     */
    public function getButtonText(int $level) : string;

    /**
     * Returns the price it costs to upgrade to the level (= $level)
     *
     * @param int $level
     * @return int
     */
    public function getPrice(int $level) : int;

    /**
     * Get the maximum level that this upgrade can have
     *
     * @return int
     */
    public function getMaxLevel() : int;

    /**
     * Get the current level that an item
     *
     * @param Item $item
     * @return int
     */
    public function getLevel(Item $item) : int;

    /**
     * Apply the upgrade to an item with a certain level
     *
     * @param Item $item
     * @param int $level
     * @return Item
     */
    public function apply(Item $item, int $level) : Item;

}
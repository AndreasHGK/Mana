<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade\itemtype;

use pocketmine\block\BlockToolType;
use pocketmine\item\Item;

class ToolType implements ItemType {

    private int $type;

    public function __construct(int $type) {
        $this->type = $type;
    }

    public function isOfType(Item $item) : bool {
        return ($this->type & $item->getBlockToolType()) !== 0;
    }

    public static function Tools() : ToolType {
        return new self(BlockToolType::TYPE_PICKAXE | BlockToolType::TYPE_AXE | BlockToolType::TYPE_SHOVEL);
    }

}
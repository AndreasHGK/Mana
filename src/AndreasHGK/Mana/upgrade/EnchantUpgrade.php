<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\upgrade;


use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\lang\TextContainer;
use pocketmine\Server;

class EnchantUpgrade implements Upgrade {

    private const NAMES = [
        0  => "PROTECTION",
        1  => "FIRE PROTECTION",
        2  => "FEATHER FALLING",
        3  => "BLAST PROTECTION",
        4  => "PROJECTILE PROTECTION",
        5  => "THORNS",
        6  => "RESPIRATION",
        7  => "DEPTH STRIDER",
        8  => "AQUA AFFINITY",
        9  => "SHARPNESS",
        10 => "SMITE",
        11 => "BANE OF ARTHROPODS",
        12 => "KNOCKBACK",
        13 => "FIRE ASPECT",
        14 => "LOOTING",
        15 => "EFFICIENCY",
        16 => "SILK TOUCH",
        17 => "UNBREAKING",
        18 => "FORTUNE",
        19 => "POWER",
        20 => "PUNCH",
        21 => "FLAME",
        22 => "INFINITY",
        23 => "LUCK OF THE SEA",
        24 => "LURE",
        25 => "FROST WALKER",
        26 => "MENDING",
        27 => "BINDING",
        28 => "VANISHING",
        29 => "IMPALING",
        30 => "RIPTIDE",
        31 => "LOYALTY",
        32 => "CHANNELING",
        33 => "MULTISHOT",
        34 => "PIERCING",
        35 => "QUICK CHARGE",
        36 => "SOUL SPEED",
    ];

    private string $name;

    private Enchantment $enchantment;
    private int $maxLevel;

    private int $basePrice;
    private int $levelPriceIncrement;

    public function __construct(int $basePrice, int $levelPriceIncrement, Enchantment $enchantment, int $maxLevel = null) {
        $this->basePrice = $basePrice;
        $this->levelPriceIncrement = $levelPriceIncrement; // the amount to add to the price for each level

        $this->enchantment = $enchantment;
        $this->maxLevel = $maxLevel ?? $enchantment->getMaxLevel();

        //Format it bc im lazy
        $a = explode(" ", strtolower(self::NAMES[$enchantment->getId()]));
        foreach($a as $key => $string) {
            $a[$key] = ucfirst($string);
        }
        //Keep the name in memory for performance
        $this->name = implode(" ", $a);
    }

    public function getName() : string {
        return $this->name;
    }

    public function getDisplayName(int $level) : string {
        if($this->maxLevel === 1) return $this->getName();
        return $this->getName() . " " . $level;
    }

    public function getButtonText(int $level) : string {
        return "§8" . $this->getDisplayName($level);
    }

    public function getMaxLevel() : int {
        return $this->maxLevel;
    }

    public function getPrice(int $level) : int {
        return $this->basePrice + ($level - 1) * $this->levelPriceIncrement;
    }

    public function getLevel(Item $item) : int {
        return ($ench = $item->getEnchantment($this->enchantment->getId())) === null ? 0 : $ench->getLevel();
    }

    public function apply(Item $item, int $level) : Item {
        $item->addEnchantment(new EnchantmentInstance($this->enchantment, $level));
        return $item;
    }

}
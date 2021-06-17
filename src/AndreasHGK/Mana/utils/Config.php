<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\utils;

use AndreasHGK\Mana\Mana;
use AndreasHGK\Mana\upgrade\EnchantUpgrade;
use AndreasHGK\Mana\upgrade\itemtype\IDType;
use AndreasHGK\Mana\upgrade\itemtype\ToolType;
use AndreasHGK\Mana\upgrade\Upgradable;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\utils\Config as PMConfig;

class Config {

    public static function read(PMConfig $cfg) : void {
        $mana = Mana::getInstance();
        $mana->getProvider()->setDefaultMana($cfg->get("default-mana", 100));

        // todo improve config reading
        $upgradables = $mana->getUpgradables();
        $configUpgradables = $cfg->get("upgradables", []);
        if(!empty($configUpgradables)) {
            foreach($configUpgradables as $item) {
                $upgradables->add(self::readUpgradable($item));
            }
            $mana->getLogger()->info("loaded ".count($configUpgradables)." upgradables");
        } else {
            $mana->getLogger()->warning("loaded 0 upgradables");
        }
    }

    public static function readUpgradable(array $item) : Upgradable {
        $type = $item["item_type"] ?? null;
        if(is_array($type)) {
            foreach($type as $i) {
                if(!is_int($i)) {
                    throw new \ErrorException("Entries in item type array must be integers");
                }
            }
            $itemtype = new IDType($type);
        } elseif(is_string($type)) {
            switch(strtolower($type)) {
                case "tools":
                    $itemtype = ToolType::Tools();
                    break;
                default:
                    throw new \ErrorException("Unknown item type '".$type."' in upgradables entry");
            }
        } else {
            throw new \ErrorException("Missing required key 'item_type' in upgradables entry");
        }

        $u = [];
        if(!isset($item["item_upgrades"])) throw new \ErrorException("Missing required key 'item_upgrades' in upgradables entry");
        foreach($item["item_upgrades"] as $upgradeData) {

            $type = $upgradeData["type"] ?? null;
            if($type === null) throw new \ErrorException("Missing required key 'type' in item_upgrades entry");

            switch(strtolower($type)) {
                case "enchant":
                    if(!isset($upgradeData["enchant_name"])) throw new \ErrorException("Missing required key 'enchant_name' in enchant entry");
                    $name = $upgradeData["enchant_name"];
                    $ench = Enchantment::getEnchantmentByName($name);
                    if($ench == null) {
                        throw new \ErrorException("Unknown enchant name '".$type."' in enchant entry");
                    }

                    $u[] = new EnchantUpgrade($upgradeData["base_price"], $upgradeData["price_increment"], $ench, $upgradeData["max_level"] ?? null);
                    break;
                default:
                    throw new \ErrorException("Unknown upgrade type '".$type."' in item_upgrades entry");
            }
        }
        if(empty($u)) throw new \ErrorException("Missing entries in key 'item_upgrades' in upgradables entry");

        return new Upgradable($itemtype, $u);
    }

}
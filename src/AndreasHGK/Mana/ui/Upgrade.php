<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\ui;

use AndreasHGK\Mana\integration\ScoreHud;
use AndreasHGK\Mana\Mana;
use pocketmine\Player;
use xenialdan\customui\elements\Button;
use xenialdan\customui\windows\SimpleForm;

class Upgrade {

    public static function UpgradeMenu(Player $player) : void {
        $plugin = Mana::getInstance();
        $provider = $plugin->getProvider();
        $upgradables = $plugin->getUpgradables();

        $currentMana = $provider->getMana($player->getXuid());
        $form = new SimpleForm("§r§3§lItem Upgrading", "§r§7You currently have §3§l".$currentMana." Mana§r§7. To upgrade your item, select one of the upgrades below.");

        $item = $player->getInventory()->getItemInHand();
        $upgradable = $upgradables->matchItem($item);
        if($upgradable === null) {
            $player->sendMessage("§r§cYou cannot upgrade this item.");
            return;
        }

        foreach($upgradable->getUpgrades() as $upgrade) {
            $level = $upgrade->getLevel($item) + 1;

            $price = $upgrade->getPrice($level);

            if($upgrade->getMaxLevel() < $level) {
                $text = $upgrade->getButtonText($level - 1) . "\n" . "§r§cMax Level";
            } else {
                $text = $upgrade->getButtonText($level) . "\n" . "§r§3§l" . $price . " Mana";
            }

            $form->addButton(new class($text, $price, $upgrade) extends Button{

                private \AndreasHGK\Mana\upgrade\Upgrade $up;
                private int $originalPrice;

                public function __construct($text, int $originalPrice, \AndreasHGK\Mana\upgrade\Upgrade $up) {
                    $this->up = $up;
                    $this->originalPrice = $originalPrice;
                    parent::__construct($text);
                }

                public function handle($value, Player $player) {
                    $provider = Mana::getInstance()->getProvider();

                    $item = $player->getInventory()->getItemInHand();
                    $lvl = $this->up->getLevel($item) + 1;
                    $price = $this->up->getPrice($lvl);

                    if($this->up->getMaxLevel() < $lvl) {
                        $player->sendMessage("§r§cThis upgrade has already reached it's maximum level.");
                        return parent::handle($value, $player);
                    }

                    if($price !== $this->originalPrice) {
                        $player->sendMessage("§r§cPlease do not switch items while trying to upgrade!");
                        return parent::handle($value, $player);
                    }

                    $mana = $provider->getMana($player->getXuid());
                    if($mana < $price) {
                        $player->sendMessage("§r§cYou cannot afford this upgrade!");
                        return parent::handle($value, $player);
                    }
                    $provider->addMana($player->getXuid(), - $price);

                    ScoreHud::getInstance()->updateTag($player, ScoreHud::TAG_MANA, (string)($mana - $price));

                    $player->getInventory()->setItemInHand($this->up->apply($item, $lvl));
                    $player->sendMessage("§r§7You upgraded §b§l".$this->up->getName()."§r§7 to level §b§l".$lvl."§r§7.");
                    return parent::handle($value, $player);
                }
            });
        }

        $player->sendForm($form);
    }

}
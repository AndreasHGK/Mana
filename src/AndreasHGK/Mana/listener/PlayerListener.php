<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\listener;

use AndreasHGK\Mana\integration\ScoreHud;
use AndreasHGK\Mana\Mana;
use AndreasHGK\SellAll\event\PlayerSellEvent;
use Ifera\ScoreHud\event\PlayerTagUpdateEvent;
use Ifera\ScoreHud\scoreboard\ScoreTag;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;

class PlayerListener implements Listener {

    public function onJoin(PlayerJoinEvent $event) : void {
        $p = $event->getPlayer();
        $provider = Mana::getInstance()->getProvider();

        // Check whether or not a player has been registered, and if not register them
        if(!$provider->exists($p->getXuid())) {
            $provider->register($p->getXuid());
        }
    }

    public function onSell(PlayerSellEvent $event) : void {
        $p = $event->getPlayer();
        $provider = Mana::getInstance()->getProvider();

        $provider->addMana($p->getXuid(), $event->getItems());
        // check if ScoreHud is loaded
        ScoreHud::getInstance()->updateTag($p, ScoreHud::TAG_MANA, (string)$provider->getMana($p->getXuid()));
        $p->sendMessage("§r§7You gained §b§l".$event->getItems()." Mana§r§7 by selling items.");

        $pk = new LevelSoundEventPacket();
        $pk->sound = LevelSoundEventPacket::SOUND_NOTE;
        $pk->position = $p->getPosition();
        $pk->extraData = (15 << 8) | 255;
        $p->sendDataPacket($pk);
    }

}
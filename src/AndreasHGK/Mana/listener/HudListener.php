<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\listener;

use AndreasHGK\Mana\Mana;
use Ifera\ScoreHud\event\TagsResolveEvent;
use pocketmine\event\Listener;

class HudListener implements Listener {

    function onTagResolve(TagsResolveEvent $event) : void {
        $p = $event->getPlayer();
        $provider = Mana::getInstance()->getProvider();
        $tag = $event->getTag();

        switch($tag->getName()) {
            case "mana.value":
                $tag->setValue((string)$provider->getMana($p->getXuid()));
                break;
        }
    }

}
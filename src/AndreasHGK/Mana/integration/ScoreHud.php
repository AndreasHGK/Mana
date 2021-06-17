<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\integration;

use AndreasHGK\Mana\listener\HudListener;
use AndreasHGK\Mana\Mana;
use AndreasHGK\Mana\provider\Provider;
use Ifera\ScoreHud\event\PlayerScoreTagEvent;
use Ifera\ScoreHud\event\PlayerTagUpdateEvent;
use Ifera\ScoreHud\scoreboard\ScoreTag;
use pocketmine\Player;

class ScoreHud {

    public const TAG_MANA = "mana.value";

    private static self $instance;
    public static function getInstance() : self {
        if(!isset(self::$instance)) return self::$instance = new self;
        return self::$instance;
    }

    private bool $isLoaded = false;
    private Provider $provider;

    /**
     * Check for ScoreHud
     */
    public function check() : void {
        if(class_exists(\Ifera\ScoreHud\ScoreHud::class)) {
            $this->isLoaded = true;
            Mana::getInstance()->getServer()->getPluginManager()->registerEvents(new HudListener(), Mana::getInstance());
            $this->provider = Mana::getInstance()->getProvider();
        }
    }

    /**
     * Check if the scorehud plugin is loaded
     *
     * @return bool
     */
    public function isLoaded() : bool {
        return $this->isLoaded;
    }

    public function updateTag(Player $p, string $id, string $value) : void {
        if(!$this->isLoaded()) return;
        $ev = new PlayerTagUpdateEvent($p, new ScoreTag($id, $value));
        $ev->call();
    }

}
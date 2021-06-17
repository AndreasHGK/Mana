<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana;

use AndreasHGK\Mana\command\ManaCommand;
use AndreasHGK\Mana\command\UpgradeCommand;
use AndreasHGK\Mana\integration\ScoreHud;
use AndreasHGK\Mana\listener\PlayerListener;
use AndreasHGK\Mana\provider\JsonProvider;
use AndreasHGK\Mana\provider\Provider;
use AndreasHGK\Mana\upgrade\Upgradables;
use AndreasHGK\Mana\utils\Config;
use pocketmine\plugin\PluginBase;

class Mana extends PluginBase{

    private static self $instance;

    public static function getInstance() : self {
        return self::$instance;
    }

    private Provider $provider;
    private Upgradables $upgradables;

    /**
     * Get the data provider that stores mana for players
     *
     * @return Provider
     */
    public function getProvider() : Provider {
        return $this->provider;
    }

    /**
     * Get the object that stores all upgradables
     *
     * @return Upgradables
     */
    public function getUpgradables() : Upgradables {
        return $this->upgradables;
    }

    public function onLoad() : void {
        self::$instance = $this;
        $this->saveDefaultConfig();

        $this->provider = new JsonProvider($this->getDataFolder() . "mana.json");
        $this->upgradables = new Upgradables();

        Config::read($this->getConfig());
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $this);

        ScoreHud::getInstance()->check();

        $this->getServer()->getCommandMap()->registerAll("mana", [
            new ManaCommand(),
            new UpgradeCommand(),
        ]);
    }

    public function onDisable() {
        $this->provider->close();
    }

}

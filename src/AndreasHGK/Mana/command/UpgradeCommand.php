<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\command;

use AndreasHGK\Mana\ui\Upgrade;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class UpgradeCommand extends Command {

    public function __construct() {
        parent::__construct("upgrade", "upgrade the item in your hand using mana", "/upgrade", ["upgradeitem"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player) return false;
        Upgrade::UpgradeMenu($sender);
        return true;
    }

}
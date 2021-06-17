<?php
/*
 * Copyright (c) 2021 AndreasHGK < https://github.com/AndreasHGK >
 */

declare(strict_types=1);

namespace AndreasHGK\Mana\command;

use AndreasHGK\Mana\Mana;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class ManaCommand extends Command {

    public function __construct() {
        parent::__construct("mana", "check your mana", "/mana", ["mymana"]);
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool {
        if(!$sender instanceof Player) {
            return false;
        }

        $mana = Mana::getInstance()->getProvider()->getMana($sender->getXuid());
        $sender->sendMessage("§r§7You currently have §b§l${mana} Mana§r§7.");
        return true;
    }

}
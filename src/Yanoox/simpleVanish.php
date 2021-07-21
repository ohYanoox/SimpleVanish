<?php

namespace Yanoox;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\command\CommandMap;
use Yanoox\commands\vanishCommands;

class simpleVanish extends PluginBase{

    public $vanish = [];

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register("vanish", new vanishCommands($this));
        
        $this->getLogger()->info(TextFormat::WHITE . "[" . TextFormat::GRAY . "SimpleVanish" . TextFormat::WHITE . "] - " .TextFormat::GOLD . "simpleVanish created by Yanoox");
    }
}

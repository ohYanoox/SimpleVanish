<?php

namespace Yanoox\commands;

use Yanoox\simpleVanish;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\utils\TextFormat;

class vanishCommands extends Command{
    
    const PREFIX = TextFormat::WHITE . "[" . TextFormat::GRAY . "SimpleVanish" . TextFormat::WHITE . "] - ";
    public $vanishList = [];
    
    private $v;
    
    
    public function __construct(simpleVanish $plugin){
        parent::__construct("vanish");
        $this->setDescription("be vanished");
        $this->setPermission("vanish.permission");
        $this->setAliases(["v",
        "van"
        ]);
        $this->v = $plugin;
        
    }
    
    public function execute(CommandSender $sender, $alias, array $args){
        if(!$sender instanceof Player){
                $sender->sendMessage(self::PREFIX .TextFormat::RED . "Utilise cette commande en jeu.");
            
        }
        if (!$sender->hasPermission("vanish.permission")){
                $sender->sendMessage(self::PREFIX . "Tu n'as pas la permission pour utiliser cette commande.");
            
        }
        if($sender instanceof Player){
            if($sender->hasPermission("vanish.permission")){
                if (empty($args[0])){
                    if (!isset($this->vanishList[$sender->getName()])){
                            $this->vanishList[$sender->getName()] = true;
                            $sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
                            $sender->setNameTagVisible(false);
                            $sender->setAllowFlight(true);
                            $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "Tu es désormais invisible !");
                        }
                        elseif(isset($this->vanishList[$sender->getName()])) {
                            unset($this->vanishList[$sender->getName()]);
                            $sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
                            $sender->setNameTagVisible(true);
                            $sender->setAllowFlight( false);
                            $sender->sendMessage(self::PREFIX . TextFormat::RED . "Sois vigilant !" .TEXTFORMAT::GREEN . " tu es visible !");
                    }
                    return false;
                
                }
                if (isset($args[0])) {
                    if ($target = $this->v->getServer()->getPlayer($args[0])) {
                        if (!isset($this->vanishList[$target->getName()])){
                            $this->vanishList[$target->getName()] = true;
                            $target->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
                            $target->setNameTagVisible(false);
                            $target->setAllowFlight(true);
                            $target->sendMessage(self::PREFIX . TextFormat::GREEN . $sender->getName() . " t'as rendu invisible !");
                            $sender->sendMessage(self::PREFIX . TextFormat::GREEN . "Tu as rendu " . $target->getName() . " invisible !");
                        }
                        elseif(isset($this->vanishList[$target->getName()])) {
                            unset($this->vanishList[$target->getName()]);
                            $target->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
                            $target->setNameTagVisible(true);
                            $target->setAllowFlight( false);
                            $target->sendMessage(self::PREFIX . TextFormat::RED . $sender->getName() . " t'as rendu visible !");
                            $sender->sendMessage(self::PREFIX . TextFormat::RED . "Tu as rendu " . $target->getName() . " visible !");
                            
                        }
                    }
                    else {
                        $sender->sendMessage(self::PREFIX . TextFormat::RED . "Erreur, le joueur n'a pas été trouvé :/");
                    }
                    
                }

            }
            return true;
        }
    }
}

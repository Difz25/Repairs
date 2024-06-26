<?php

namespace GDifz25\Repairs\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use Difz25\Repairs\Main;

class RepairCommand extends Command {

    private Main $plugin;
    
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        parent::__construct($this->plugin->getConfig()->get("repair"), $this->plugin->getConfig()->get("repair-description"), "/repair", [""]);
        $this->setPermission("repair.use");
    }
    public function execute(CommandSender $player, string $label, array $args): bool {
        $config = $this->plugin->getConfig();
        if(!$player instanceof Player){
            $player->sendMessage($config->get("run-ingame"));
            return false;
        }

        if(!$player->hasPermission("repair.use")) {
            $player->sendMessage($config->get("no-permission"));
              return false;
        }

        $item = $player->getInventory()->getItem($player->getInventory()->getHeldItemIndex());
        if ($item->isNull()) {
            $player->sendMessage($config->get("repair-noitem"));
            return false;
        }

        if(!$item instanceof Tool && !$item instanceof Armor){
            $player->sendMessage($config->get("instanceof"));
            return false;
        }

        $item->setDamage(0);
        $player->getInventory()->setItemInHand($item);
        $player->sendMessage($this->plugin->getConfig()->get("repair-succes"));
        return true;
    }
 }

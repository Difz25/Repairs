<?php

namespace Difz25\Repairs\commands;

use Difz25\Repairs\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use jojoe77777\FormAPI\CustomForm;

class RenameCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct($this->plugin->getConfig()->get("rename"), $this->plugin->getConfig()->get("rename-description"), "/rename", [""]);
        $this->setPermission("rename.use");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool
    {
        $config = $this->plugin->getConfig();
        if (!$sender instanceof Player) {
            $this->RenameForm($sender);
            $sender->sendMessage($config->get("run-ingame"));
            return false;
        }

        if (!$sender->hasPermission("rename")) {
            $sender->sendMessage($config->get("no-permission"));
            return false;
        }
        return true;
    }

    private function RenameForm(Player $player){
        $form = new CustomForm(function (Player $player, array $result) {
            if ($result === null) {
                return true;
            }
            $name = $result[0];
            $item = $player->getInventory()->getItemInHand();
            $item->setCustomName($name);
            $player->getInventory()->setItemInHand($item);
        });
        $form->setTitle($this->plugin->getConfig()->get("rename-title"));
        $form->addLabel($this->plugin->getConfig()->get("rename-label"));
        $form->addInput("Name");
        $player->sendForm($form);
    }
}


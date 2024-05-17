<?php

namespace Difz25\Repairs\commands;

use Difz25\Repairs\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use jojoe77777\FormAPI\CustomForm;

class LoreCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct($this->plugin->getConfig()->get("lore"), $this->plugin->getConfig()->get("lore-description"), "/lore", [""]);
        $this->setPermission("lore.use");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool
    {
        $config = $this->plugin->getConfig();
        if (!$sender instanceof Player) {
            $this->LoreForm($sender);
            $sender->sendMessage($config->get("run-ingame"));
            return false;
        }

        if (!$sender->hasPermission("lore")) {
            $sender->sendMessage($config->get("no-permission"));
            return false;
        }
        return true;
    }

    private function LoreForm(Player $player){
        $form = new CustomForm(function (Player $player, array $result) {
            if ($result === null) {
                return true;
            }
            $lore = $result[0];
            $loreitem = $player->getInventory()->getItemInHand();
            $loreitem->setLore($lore);
            $player->getInventory()->setItemInHand($loreitem);
        });
        $form->setTitle($this->plugin->getConfig()->get("lore-title"));
        $form->addLabel($this->plugin->getConfig()->get("lore-label"));
        $form->addInput("Lore");
        $player->sendForm($form);
    }
}

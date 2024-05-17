<?php

namespace Difz25\Repairs;

use Difz25\Repairs\commands\RepairAllCommand;
use Difz25\Repairs\commands\RepairCommand;
use Difz25\Repairs\commands\RenameCommand;
use Difz25\Repairs\commands\LoreCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

    public Config $config;

    public function onEnable(): void {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", 2);
        $this->getServer()->getCommandMap()->register("repair", new RepairCommand($this));
        $this->getServer()->getCommandMap()->register("repair-all", new RepairAllCommand($this));
        $this->getServer()->getCommandMap()->register("rename", new RenameCommand($this));
        $this->getServer()->getCommandMap()->register("lore", new LoreCommand($this));
    }
}

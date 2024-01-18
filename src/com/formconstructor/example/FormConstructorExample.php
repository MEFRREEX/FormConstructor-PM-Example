<?php

declare(strict_types=1);

namespace com\formconstructor\example;

use pocketmine\plugin\PluginBase;
use com\formconstructor\example\command\CustomFormCommand;
use com\formconstructor\example\command\ModalFormCommand;
use com\formconstructor\example\command\SimpleFormCommand;

class FormConstructorExample extends PluginBase {

    public function onEnable(): void {
        $this->getServer()->getCommandMap()->register("FCE", new SimpleFormCommand());
        $this->getServer()->getCommandMap()->register("FCE", new ModalFormCommand());
        $this->getServer()->getCommandMap()->register("FCE", new CustomFormCommand());
    }
}

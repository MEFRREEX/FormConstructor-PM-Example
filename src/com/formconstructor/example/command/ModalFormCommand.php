<?php

namespace com\formconstructor\example\command;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use com\formconstructor\form\ModalForm;

class ModalFormCommand extends Command {

    public function __construct() {
        parent::__construct("modalform", "ModalForm");
        $this->setPermission("formconstructor.example");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            return;
        }

        // Creating a form
        $form = new ModalForm("Test modal form");
        $form->addContent("New content line");

        $form->setPositiveButton("Positive button")
             ->setNegativeButton("Negative button");

        // Setting the form handler
        // Result returns true if a positive button was clicked and false if a negative button was clicked
        $form->setHandler(function (Player $pl, bool $result) {
            $pl->sendMessage("You clicked " . ($result ? "correct" : "wrong") . " button!");
        });

        // Setting the form close handler
        $form->setCloseHandler(fn(Player $pl) => $pl->sendMessage("You closed the form!"));

        // Sending the form
        $form->send($sender);
    }
}
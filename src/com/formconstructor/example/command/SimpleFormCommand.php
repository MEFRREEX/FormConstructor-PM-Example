<?php

namespace com\formconstructor\example\command;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use com\formconstructor\form\element\simple\Button;
use com\formconstructor\form\element\simple\ImageType;
use com\formconstructor\form\SimpleForm;

class SimpleFormCommand extends Command {

    public function __construct() {
        parent::__construct("simpleform", "SimpleForm");
        $this->setPermission("formconstructor.example");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            return;
        }

        // Creating a form
        $form = new SimpleForm("Sample title");
        $form->addContent("New content line");

        // Easiest way to add a button
        $form->addButton(new Button("Button", function (Player $pl, Button $b) {
                $pl->sendMessage("Button clicked: " . $b->getName() . " (" . $b->getIndex() . ")");
            }))

            // Button with image
            ->addButton((new Button("Button with image"))
                ->setImage(ImageType::PATH, "textures/items/diamond"))

            // Another way to add a button
            ->addButton((new Button("Another button"))
                ->setImage(ImageType::PATH, "textures/blocks/stone")
                ->onClick(function (Player $pl, Button $b) {
                    $pl->sendMessage("Another button clicked: " . $b->getName() . " (" . $b->getIndex() . ")");
                }));

        // Setting the form close handler
        $form->setCloseHandler(function (Player $pl) {
            $pl->sendMessage("You closed the form!");
        });

        // Sending the form
        $form->send($sender);
    }
}
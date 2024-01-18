<?php

namespace com\formconstructor\example\command;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use com\formconstructor\form\CustomForm;
use com\formconstructor\form\element\custom\Dropdown;
use com\formconstructor\form\element\custom\Input;
use com\formconstructor\form\element\custom\Slider;
use com\formconstructor\form\element\custom\StepSlider;
use com\formconstructor\form\element\custom\Toggle;
use com\formconstructor\form\element\SelectableElement;
use com\formconstructor\form\response\CustomFormResponse;

class CustomFormCommand extends Command {

    public function __construct() {
        parent::__construct("customform", "CustomForm");
        $this->setPermission("formconstructor.example");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            return;
        }

        // Creating a form
        $form = new CustomForm("Test custom form");

        $form->addContent("Test label")
            ->addElement("input", (new Input("Input"))
                ->setPlaceholder("Text")
                ->setDefaultValue("Default value"))
            ->addElement("slider", new Slider("Slider", 1, 100, 1, 1))
            ->addElement("stepslider", (new StepSlider("Step slider"))
                ->addText("1")
                ->addText("2")
                ->addText("3"))
            ->addElement("dropdown", (new Dropdown("Dropdown"))
                ->addText("Element 1")
                ->addText("Element 2")
                ->addText("Element 3"))
            ->addElement("dropdown1", (new Dropdown("Second dropdown"))
                ->addElement(new SelectableElement("Option 1"))
                ->addElement(new SelectableElement("Option 2"))
                ->addElement(new SelectableElement("Option with value", 15)))
            ->addElement("toggle", new Toggle("Toggle", false));

        // Setting the form handler
        $form->setHandler(function (Player $pl, CustomFormResponse $response) {
            $input = $response->getInput("input")->getValue();

            $slider = $response->getSlider("slider")->getValue();
            $stepslider = $response->getStepSlider("stepslider")->getValue();
            $dropdown = $response->getDropdown("dropdown")->getValue();

            // Getting the value we set in SelectableElement
            $dropdownValue = $response->getDropdown("dropdown1")->getValue()->getValue();

            $toggle = $response->getToggle("toggle")->getValue();

            $pl->sendMessage("Input: " . $input . ", Slider: " . $slider . ", Step Slider: " . $stepslider . ", Dropdown: " . $dropdown . ", Toggle: " . $toggle);
            $pl->sendMessage("Second dropdown value: " . $dropdownValue);
        });

        // Sending the form
        $form->send($sender);
    }
}
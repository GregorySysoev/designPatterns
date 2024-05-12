<?php

declare(strict_types=1);

class Radio
{
    public function turnOn(): void
    {
        echo "Radio starts working... Wololololooooo... \n";
    }

    public function turnOff(): void
    {
        echo "Radio turns off \n";
    }
}

interface CommandInterface
{
    public function executeOn(): void;

    public function executeOff(): void;
}

class RadioOnCommand implements CommandInterface
{
    public function __construct(
        private Radio $radio
    ) {
    }

    public function executeOn(): void
    {
        $this->radio->turnOn();
    }

    public function executeOff(): void
    {
        $this->radio->turnOff();
    }
}

$radio = new Radio();

$radioOnCommand = new RadioOnCommand($radio);

$radioOnCommand->executeOn();

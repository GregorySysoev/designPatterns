<?php

declare(strict_types=1);

abstract class Component
{
    public function __construct(
        protected string $name
    ) {
    }

    abstract public function print(int $countSpaces): string;
}

class DirectoryComponent extends Component
{
    /**
     * @var array<string, Component>
     */
    private array $components = [];

    public function addComponent(Component $component): void {
        $componentName = $component->name;
        if ($componentName === '') {
            return;
        }

        $this->components[$componentName] = $component;
    }

    public function removeComponent(Component $component): void {
        $componentName = $component->name;
        if ($componentName === '') {
            return;
        }

        unset($this->components[$componentName]);
    }

    public function print(int $countSpaces): string
    {
        $currentDir = str_repeat(' ', $countSpaces) . "$this->name/";

        $result = "$currentDir\n";

        foreach ($this->components as $component) {
            $result .= $component->print($countSpaces + 4);
        }

        return $result;
    }
}

class FileComponent extends Component
{
    public function print(int $countSpaces): string
    {
        return str_repeat(' ', $countSpaces) . sprintf("%s\n", $this->name);
    }
}

$img2 = new FileComponent('img2.jpeg');
$img = new FileComponent("img.png");
$bin = new DirectoryComponent("bin");
$bin->addComponent($img);
$bin->addComponent($img2);

$tmpFile = new FileComponent("tmp.txt");

$tmpDir = new DirectoryComponent("tmp");
$tmpDir->addComponent($tmpFile);
$tmpDir->addComponent($bin);

$userDirectory = new DirectoryComponent("main");
$userDirectory->addComponent($tmpDir);

$userDirectory2 = new DirectoryComponent("Alice");
$userDirectory2->addComponent(new FileComponent('familyPhoto.jpeg'));

$usersDirectory = new DirectoryComponent("users");
$usersDirectory->addComponent($userDirectory);
$usersDirectory->addComponent($userDirectory2);


echo $usersDirectory->print(0);

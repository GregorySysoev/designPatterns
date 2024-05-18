<?php

declare(strict_types=1);

class MenuItem
{
    public function __construct(
        private readonly string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}

interface MenuItemIteratorInterface
{
    public function getCurrent(): false|MenuItem;

    public function moveNext(): void;
}

class MenuArrayIterator implements MenuItemIteratorInterface
{
    /**
     * @param MenuItem[] $menu
     */
    public function __construct(
        private array $menu
    ) {
    }

    public function getCurrent(): false|MenuItem
    {
        return current($this->menu);
    }

    public function moveNext(): void
    {
        next($this->menu);
    }
}

interface MenuAggregatorInterface
{
    public function getIterator(): MenuItemIteratorInterface;
}

class ArrayMenu implements MenuAggregatorInterface
{
    /**
     * @var array<string, MenuItem>
     */
    private array $menu = [];

    public function addToMenu(MenuItem $item): void
    {
        $this->menu[$item->getName()] = $item;
    }

    public function getIterator(): MenuItemIteratorInterface
    {
        return new MenuArrayIterator($this->menu);
    }
}

$borsh = new MenuItem('Borsh');
$hinkali = new MenuItem('Hinkali');
$pizza = new MenuItem('Pizza');

$menu = new ArrayMenu();
$menu->addToMenu($borsh);
$menu->addToMenu($hinkali);
$menu->addToMenu($pizza);

$menuIterator = $menu->getIterator();

while ($menuItem = $menuIterator->getCurrent()) {
    echo "{$menuItem->getName()} \n";

    $menuIterator->moveNext();
}

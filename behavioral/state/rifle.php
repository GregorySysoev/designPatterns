<?php

// Выдуманный пример: винтовка и режимы стрельбы

declare(strict_types=1);

class Rifle
{
    private FireMode $singleShot;
    private FireMode $burstShot;
    private FireMode $automaticShot;
    private FireMode $currentFireMode;
    private int $bulletsCount;

    public function __construct()
    {
        $this->singleShot = new SingleShot($this);
        $this->burstShot = new BurstShot($this);
        $this->automaticShot = new AutomaticShot($this);
        $this->currentFireMode = $this->singleShot;
        $this->bulletsCount = 30;
    }

    public function shoot(): void
    {
        $this->currentFireMode->shoot();
    }

    public function getBulletsCount(): int
    {
        return $this->bulletsCount;
    }

    public function fireBullets(int $bulletsCountFired): void
    {
        $bulletsLeftCount = $this->bulletsCount - $bulletsCountFired;
        $this->bulletsCount = max($bulletsLeftCount, 0);
    }

    public function switchFireMode(FireModeEnum $currentFireMode): void
    {
        $this->currentFireMode = match ($currentFireMode) {
            FireModeEnum::SingleShot => $this->singleShot,
            FireModeEnum::BurstShot => $this->burstShot,
            FireModeEnum::AutomaticShot => $this->automaticShot,
        };
    }
}

enum FireModeEnum
{
    case SingleShot;
    case BurstShot;
    case AutomaticShot;
}

abstract class FireMode
{
    protected Rifle $rifle;

    public function __construct(Rifle $rifle)
    {
        $this->rifle = $rifle;
    }

    public abstract function shoot(): void;
}

class SingleShot extends FireMode
{
    private const BULLETS_TO_FIRE = 1;

    public function shoot(): void
    {
        $this->rifle->fireBullets(self::BULLETS_TO_FIRE);
    }
}

class BurstShot extends FireMode
{
    private const BULLETS_TO_FIRE = 3;

    public function shoot(): void
    {
        $this->rifle->fireBullets(self::BULLETS_TO_FIRE);
    }
}

class AutomaticShot extends FireMode
{
    public function shoot(): void
    {
        $this->rifle->fireBullets($this->rifle->getBulletsCount());
    }
}


$ak12 = new Rifle();

$ak12->shoot();
$ak12->shoot();
$ak12->switchFireMode(FireModeEnum::BurstShot);
$ak12->shoot();


echo "Пуль в магазине: {$ak12->getBulletsCount()}. Ожидалось: 25 \n";

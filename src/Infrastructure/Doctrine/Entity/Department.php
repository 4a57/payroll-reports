<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'departments')]
class Department
{
    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 15)]
    private string $bonusType;

    #[ORM\Column(type: 'integer')]
    private int $bonusValue;

    public function __construct(int $id, string $name, string $bonusType, int $bonusValue)
    {
        $this->id = $id;
        $this->name = $name;
        $this->bonusType = $bonusType;
        $this->bonusValue = $bonusValue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBonusType(): string
    {
        return $this->bonusType;
    }

    public function getBonusValue(): int
    {
        return $this->bonusValue;
    }
}

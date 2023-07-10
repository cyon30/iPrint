<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'dbo_items')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private int $id;

    #[ORM\Column(name: 'icode', type: 'string', length: 8, nullable: false)]
    private string $code;

    #[ORM\Column(name: 'idesc', type: 'string',  nullable: true)]
    private string $description;

    #[ORM\Column(name: 'ibin', type: 'string', length: 5, nullable: false)]
    private string $bin;

    #[ORM\Column(name: 'ibar', type: 'string', length: 8, nullable: false)]
    private string $bar;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: ItemPrint::class)]
    private PersistentCollection $prints;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Item
     */
    public function setId(int $id): Item
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Item
     */
    public function setCode(string $code): Item
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Item
     */
    public function setDescription(string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getBin(): string
    {
        return $this->bin;
    }

    /**
     * @param string $bin
     * @return Item
     */
    public function setBin(string $bin): Item
    {
        $this->bin = $bin;
        return $this;
    }

    /**
     * @return string
     */
    public function getBar(): string
    {
        return $this->bar;
    }

    /**
     * @param string $bar
     * @return Item
     */
    public function setBar(string $bar): Item
    {
        $this->bar = $bar;
        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getPrints(): PersistentCollection
    {
        return $this->prints;
    }

    /**
     * @param ItemPrint $prints
     * @return Item
     */
    public function addPrint(ItemPrint $prints): Item
    {
        $this->prints->add($prints);
        return $this;
    }
}
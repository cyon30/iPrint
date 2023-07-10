<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: 'item_print')]
class ItemPrint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Item::class, fetch: 'EAGER', inversedBy: 'prints')]
    #[ORM\JoinColumn(name: 'item_id', referencedColumnName: 'id')]
    private Item $item;

    #[ORM\Column(name: 'print_date', type: 'datetime', nullable: false)]
    private DateTime $printDate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ItemPrint
     */
    public function setId(int $id): ItemPrint
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return ItemPrint
     */
    public function setItem(Item $item): ItemPrint
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPrintDate(): DateTime
    {
        return $this->printDate;
    }

    /**
     * @param DateTime $printDate
     * @return ItemPrint
     */
    public function setPrintDate(DateTime $printDate): ItemPrint
    {
        $this->printDate = $printDate;
        return $this;
    }
}
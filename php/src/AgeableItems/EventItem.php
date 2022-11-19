<?php

declare(strict_types=1);

namespace GildedRose\AgeableItems;

use GildedRose\Item;

class EventItem implements AgeableItemsInterface
{
    private readonly Item $item;

    public function __construct(Item $item) {
        $this->item = $item;
    }

    public function calculateQualityDiff() : int
    {
        // Quality drops to 0 after the concert
        if ($this->item->sell_in < 1) {
            return -$this->item->quality;
        }
        // Quality increases by 3 when there are 5 days or less
        if ($this->item->sell_in <= 5) {
            return 3;
        }
        
        // Quality increases by 2 when there are 10 days or less
        if ($this->item->sell_in <= 10) {
            return 2;
        }

        return 1;
    }

    public function calculateSellInDiff() : int
    {
        return -1;
    }
}
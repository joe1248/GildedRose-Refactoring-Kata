<?php

declare(strict_types=1);

namespace GildedRose\AgeableItems;

use GildedRose\Item;

final class RewardingItem implements AgeableItemsInterface
{
    private readonly Item $item;

    public function __construct(Item $item) {
        $this->item = $item;
    }
    
    public function calculateQualityDiff() : int
    {
        // Until the sell by date, increases in quality the older it gets, so daily by +1
        if ($this->item->sell_in > 0) {
            return 1;
        }

        // Once the sell by date has passed, Quality increases twice as fast so daily by +2
        return 2;
    }

    public function calculateSellInDiff() : int
    {
        return -1;
    }
}
<?php

declare(strict_types=1);

namespace GildedRose\AgeableItems;

use GildedRose\Item;

class ConjuredPerishableItem implements AgeableItemsInterface
{
    private readonly Item $item;

    public function __construct(Item $item) {
        $this->item = $item;
    }

    public function calculateQualityDiff() : int
    {
        // Until the sell by date has passed, Quality degrades daily by -2
        if ($this->item->sell_in > 0) {
            return -2;
        }

        // Once the sell by date has passed, Quality degrades twice as fast, so daily by -4
        return -4;
    }

    public function calculateSellInDiff() : int
    {
        return -1;
    }
}
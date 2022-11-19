<?php

declare(strict_types=1);

namespace GildedRose\AgeableItems;

final class StableItem implements AgeableItemsInterface
{
    public function calculateQualityDiff() : int
    {
        return 0;
    }
    public function calculateSellInDiff() : int
    {
        return 0;
    }
}
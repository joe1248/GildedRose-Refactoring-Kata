<?php

declare(strict_types=1);

namespace GildedRose\AgeableItems;

interface AgeableItemsInterface
{
    public function calculateQualityDiff() : int;
    public function calculateSellInDiff() : int;
}
<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\AgeableItems\ConjuredPerishableItem;
use GildedRose\AgeableItems\EventItem;
use GildedRose\AgeableItems\PerishableItem;
use GildedRose\AgeableItems\RewardingItem;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item = $this->updateQualityOfOneItem($item);
        }
    }

    private function updateQualityOfOneItem(Item $item): Item
    {
        switch($item->name) {
            // Stable items
            case 'Sulfuras, Hand of Ragnaros':
                
                return $item;

            // Rewarding items
            case 'Aged Brie':
                $ageableItem = new RewardingItem($item);
                break;

            // Event items
            case 'Backstage passes to a TAFKAL80ETC concert':
                $ageableItem = new EventItem($item);
                break;

            // Conjured Perishable items
            case 'Conjured Mana Cake':
                $ageableItem = new ConjuredPerishableItem($item);
                break;

            // Perishable items
            default:
                $ageableItem = new PerishableItem($item);
                break;
        }
        $item->quality += $ageableItem->calculateQualityDiff();
        $item->sell_in += $ageableItem->calculateSellInDiff();

        // The Quality of an item is never negative
        $item->quality = max(0, $item->quality);

        // The Quality of an item is above 50
        $item->quality = min(50, $item->quality);
    
        return $item;
    }
}
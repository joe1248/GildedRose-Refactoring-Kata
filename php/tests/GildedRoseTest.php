<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @dataProvider provideItemData
     */
    public function testUpdateQuality(
        array $itemToday,
        string $itemTomorrow,
    ): void
    {
        $items = [new Item(...$itemToday)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame($itemTomorrow, $items[0]->__toString());
    }

    /**
    * @return string[][]
    */
    public function provideItemData()
    {
        yield 'PerishableItem : Quality goes down' => [
            ['+5 Dexterity Vest', 10, 20],
            '+5 Dexterity Vest, 9, 19'
        ];
        yield 'PerishableItem : Once the sell by date has passed, Quality degrades twice as fast' => [
            ['+5 Dexterity Vest', 0, 10],
            '+5 Dexterity Vest, -1, 8'
        ];
        yield 'PerishableItem: The Quality of an item is never negative' => [
            ['+5 Dexterity Vest', -2, 1],
            '+5 Dexterity Vest, -3, 0'
        ];
        yield 'RewardingItem: increases in quality the older it gets' => [
            ['Aged Brie', 2, 0],
            'Aged Brie, 1, 1'
        ];
        yield 'RewardingItem: quality increases twice as fast after sell-by date' => [
            ['Aged Brie', 0, 2],
            'Aged Brie, -1, 4'
        ];
        yield 'RewardingItem: "Aged Brie" quality increases until maximum 50' => [
            ['Aged Brie', -24, 50],
            'Aged Brie, -25, 50'
        ];
        yield 'Stable item: Sulfuras never has to be sold or decreases in Quality' => [
            ['Sulfuras, Hand of Ragnaros', -1, 80],
            'Sulfuras, Hand of Ragnaros, -1, 80'
        ];
        yield 'Event item: increases in Quality as its SellIn value approaches' => [
            ['Backstage passes to a TAFKAL80ETC concert', 15, 20],
            'Backstage passes to a TAFKAL80ETC concert, 14, 21'
        ];
        yield 'Event item: Quality increases by 2 when there are 10 days or less' => [
            ['Backstage passes to a TAFKAL80ETC concert', 10, 25],
            'Backstage passes to a TAFKAL80ETC concert, 9, 27'
        ];
        yield 'Event item: Quality increases by 3 when there are 5 days or less' => [
            ['Backstage passes to a TAFKAL80ETC concert', 5, 35],
            'Backstage passes to a TAFKAL80ETC concert, 4, 38'
        ];
        yield 'Event item: Quality never increase above 50' => [
            ['Backstage passes to a TAFKAL80ETC concert', 5, 50],
            'Backstage passes to a TAFKAL80ETC concert, 4, 50'
        ];
        yield 'Event item: Quality drops to 0 after the concert' => [
            ['Backstage passes to a TAFKAL80ETC concert', 0, 50],
            'Backstage passes to a TAFKAL80ETC concert, -1, 0'
        ];
    }
}

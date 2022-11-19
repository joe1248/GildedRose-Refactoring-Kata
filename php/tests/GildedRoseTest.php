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
            ['+5 Dexterity Vest', 10, 0],
            '+5 Dexterity Vest, 9, 0'
        ];
        yield 'RewardingItem: "Aged Brie" actually increases in Quality the older it gets' => [
            ['Aged Brie', 2, 0],
            'Aged Brie, 1, 1'
        ];
        yield 'RewardingItem: "Aged Brie" quality increases twice as fast after sell-by date' => [
            ['Aged Brie', 0, 2],
            'Aged Brie, -1, 4'
        ];
        yield 'RewardingItem: "Aged Brie" quality increases until maximum 50' => [
            ['Aged Brie', -24, 50],
            'Aged Brie, -25, 50'
        ];
        
    }
}

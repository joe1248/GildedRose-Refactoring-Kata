<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /**
     * @dataProvider providePerishableItemData
     */
    public function testPerishableItem(
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
    public function providePerishableItemData()
    {
        yield 'Quality goes down' => [
            ['+5 Dexterity Vest', 10, 20],
            '+5 Dexterity Vest, 9, 19'
        ];
        yield 'Once the sell by date has passed, Quality degrades twice as fast' => [
            ['+5 Dexterity Vest', 0, 10],
            '+5 Dexterity Vest, -1, 8'
        ];
        yield 'The Quality of an item is never negative' => [
            ['+5 Dexterity Vest', 10, 0],
            '+5 Dexterity Vest, 9, 0'
        ];
    }
}

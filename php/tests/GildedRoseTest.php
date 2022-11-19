<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testPerishableItem(): void
    {
        $items = [new Item('+5 Dexterity Vest', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('+5 Dexterity Vest', $items[0]->name);
    }
}
/*
-------- day 0 --------
name, sellIn, quality
+5 Dexterity Vest, 10, 20

-------- day 1 --------
name, sellIn, quality
+5 Dexterity Vest, 9, 19

-------- day 2 --------
name, sellIn, quality
+5 Dexterity Vest, 8, 18

-------- day 3 --------
name, sellIn, quality
+5 Dexterity Vest, 7, 17

-------- day 4 --------
name, sellIn, quality
+5 Dexterity Vest, 6, 16

-------- day 5 --------
name, sellIn, quality
+5 Dexterity Vest, 5, 15

-------- day 6 --------
name, sellIn, quality
+5 Dexterity Vest, 4, 14

-------- day 7 --------
name, sellIn, quality
+5 Dexterity Vest, 3, 13

-------- day 8 --------
name, sellIn, quality
+5 Dexterity Vest, 2, 12

-------- day 9 --------
name, sellIn, quality
+5 Dexterity Vest, 1, 11
*/
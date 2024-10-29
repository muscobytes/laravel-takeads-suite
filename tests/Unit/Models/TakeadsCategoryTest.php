<?php

namespace Muscobytes\Laravel\Takeads\Suite\Tests\Unit\Models;

use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsCategory;
use Muscobytes\Laravel\Takeads\Suite\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TakeadsCategory::class)]
class TakeadsCategoryTest extends TestCase
{
    public function test_category_creation()
    {
        $external_id = 43;
        $category = TakeadsCategory::create([
            'external_id' => 43
        ]);
        $this->assertNotNull($category);
        $this->assertIsInt($category->external_id);
        $this->assertSame($category->external_id, $external_id);
        $this->assertEquals(1, TakeadsCategory::count());

    }
}
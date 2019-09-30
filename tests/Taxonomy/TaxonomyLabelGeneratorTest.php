<?php

namespace Ryvon\Plugin\Taxonomy;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class TaxonomyLabelGeneratorTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        Monkey\setUp();
        Monkey\Functions\stubTranslationFunctions();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Monkey\tearDown();
    }

    /**
     * @return void
     */
    public function testGenerate(): void
    {
        $generator = new TaxonomyLabelGenerator();

        $this->assertEquals([
            'name' => 'Categories',
            'singular_name' => 'Category',
            'add_new_item' => 'Add New Category',
            'edit_item' => 'Edit Category',
            'view_item' => 'View Category',
            'search_items' => 'Search Categories',
            'not_found' => 'No categories found.',
            'parent_item_colon' => 'Parent Category:',
            'all_items' => 'All Categories',
            'menu_name' => 'Categories',
            'update_item' => 'Update Category',
            'new_item_name' => 'New Category Name',
            'parent_item' => 'Parent Category',
            'popular_items' => 'Popular Categories',
            'separate_items_with_commas' => 'Separate categories with commas',
            'add_or_remove_items' => 'Add or remove categories',
            'choose_from_most_used' => 'Choose from the most used categories',
            'back_to_items' => '&larr; Back to Categories',
        ], $generator->generate('Category', 'Categories', 'default'));
    }
}

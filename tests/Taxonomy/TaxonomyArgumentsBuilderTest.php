<?php

namespace Ryvon\Plugin\Taxonomy;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class TaxonomyArgumentsBuilderTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        Monkey\setUp();
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
    public function testGetSet(): void
    {
        $labelGenerator = $this->createMock(TaxonomyLabelGeneratorInterface::class);
        $labelGenerator->expects($this->once())
            ->method('generate')
            ->willReturnCallback(static function (string $singular, string $plural, string $textDomain): array {
                return [
                    'name' => $plural,
                    'singular_name' => $singular,
                ];
            });

        /** @var TaxonomyLabelGeneratorInterface $labelGenerator */

        $builder = new TaxonomyArgumentsBuilder($labelGenerator);

        $this->assertEquals([], $builder->build());

        $this->assertNull($builder->getLabel());
        $builder->setLabel('Category');
        $this->assertEquals('Category', $builder->getLabel());

        $this->assertNull($builder->getLabels());
        $builder->setLabels(['name' => 'Category']);
        $this->assertEquals(['name' => 'Category'], $builder->getLabels());

        $builder->generateLabels('Category', 'Categories', 'default');
        $this->assertEquals(['name' => 'Categories', 'singular_name' => 'Category'], $builder->getLabels());

        $this->assertNull($builder->getPublic());
        $builder->setPublic(true);
        $this->assertTrue($builder->getPublic());

        $this->assertNull($builder->getPubliclyQueryable());
        $builder->setPubliclyQueryable(true);
        $this->assertTrue($builder->getPubliclyQueryable());

        $this->assertNull($builder->getShowUi());
        $builder->setShowUi(true);
        $this->assertTrue($builder->getShowUi());

        $this->assertNull($builder->getShowInMenu());
        $builder->setShowInMenu(true);
        $this->assertTrue($builder->getShowInMenu());

        $this->assertNull($builder->getShowInNavMenus());
        $builder->setShowInNavMenus(true);
        $this->assertTrue($builder->getShowInNavMenus());

        $this->assertNull($builder->getShowInRest());
        $builder->setShowInRest(true);
        $this->assertTrue($builder->getShowInRest());

        $this->assertNull($builder->getRestBase());
        $builder->setRestBase('document_categories');
        $this->assertEquals('document_categories', $builder->getRestBase());

        $this->assertNull($builder->getRestControllerClass());
        $builder->setRestControllerClass('\WP_REST_Terms_Controller_Test');
        $this->assertEquals('\WP_REST_Terms_Controller_Test', $builder->getRestControllerClass());

        $this->assertNull($builder->getShowTagCloud());
        $builder->setShowTagCloud(true);
        $this->assertTrue($builder->getShowTagCloud());

        $this->assertNull($builder->getShowInQuickEdit());
        $builder->setShowInQuickEdit(true);
        $this->assertTrue($builder->getShowInQuickEdit());

        $this->assertNull($builder->getMetaBoxCallback());
        $builder->setMetaBoxCallback([$this, 'callbackMetaBox']);
        $this->assertEquals([$this, 'callbackMetaBox'], $builder->getMetaBoxCallback());

        $this->assertNull($builder->getShowAdminColumn());
        $builder->setShowAdminColumn(true);
        $this->assertTrue($builder->getShowAdminColumn());

        $this->assertNull($builder->getDescription());
        $builder->setDescription('Description');
        $this->assertEquals('Description', $builder->getDescription());

        $this->assertNull($builder->getHierarchical());
        $builder->setHierarchical(true);
        $this->assertTrue($builder->getHierarchical());

        $this->assertNull($builder->getUpdateCountCallback());
        $builder->setUpdateCountCallback([$this, 'callbackUpdateCount']);
        $this->assertEquals([$this, 'callbackUpdateCount'], $builder->getUpdateCountCallback());

        $this->assertNull($builder->getQueryVar());
        $builder->setQueryVar('document_category');
        $this->assertEquals('document_category', $builder->getQueryVar());

        $this->assertNull($builder->getRewrite());
        $builder->setRewrite(['slug' => 'document_category']);
        $this->assertEquals(['slug' => 'document_category'], $builder->getRewrite());

        $this->assertNull($builder->getCapabilities());
        $builder->setCapabilities([TaxonomyCapability::ASSIGN_TERMS => 'edit_posts']);
        $this->assertEquals([TaxonomyCapability::ASSIGN_TERMS => 'edit_posts'], $builder->getCapabilities());

        $this->assertNull($builder->getSort());
        $builder->setSort(true);
        $this->assertTrue($builder->getSort());

        $this->assertEquals([
            'label' => 'Category',
            'labels' => ['name' => 'Categories', 'singular_name' => 'Category'],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rest_base' => 'document_categories',
            'rest_controller_class' => '\WP_REST_Terms_Controller_Test',
            'show_tagcloud' => true,
            'show_in_quick_edit' => true,
            'meta_box_cb' => [$this, 'callbackMetaBox'],
            'show_admin_column' => true,
            'description' => 'Description',
            'hierarchical' => true,
            'update_count_callback' => [$this, 'callbackUpdateCount'],
            'query_var' => 'document_category',
            'rewrite' => ['slug' => 'document_category'],
            'capabilities' => [TaxonomyCapability::ASSIGN_TERMS => 'edit_posts'],
            'sort' => true,
        ], $builder->build());
    }

    public function callbackMetaBox(): void
    {
    }

    public function callbackUpdateCount(): void
    {
    }
}

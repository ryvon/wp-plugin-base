<?php

namespace Ryvon\Plugin\PostType;

use PHPUnit\Framework\TestCase;

class PostTypeArgumentsBuilderTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetSet(): void
    {
        $labelGenerator = $this->createMock(PostTypeLabelGeneratorInterface::class);
        $labelGenerator->expects($this->once())
            ->method('generate')
            ->willReturnCallback(static function (string $singular, string $plural, string $textDomain): array {
                return [
                    'name' => $plural,
                    'singular_name' => $singular,
                ];
            });

        /** @var PostTypeLabelGeneratorInterface $labelGenerator */

        $builder = new PostTypeArgumentsBuilder($labelGenerator);

        $this->assertEquals([], $builder->build());

        $this->assertNull($builder->getLabel());
        $builder->setLabel('Document');
        $this->assertEquals('Document', $builder->getLabel());

        $this->assertNull($builder->getLabels());
        $builder->setLabels(['name' => 'Document']);
        $this->assertEquals(['name' => 'Document'], $builder->getLabels());

        $builder->generateLabels('Document', 'Documents', 'default');
        $this->assertEquals(['name' => 'Documents', 'singular_name' => 'Document'], $builder->getLabels());

        $this->assertNull($builder->getDescription());
        $builder->setDescription('Description');
        $this->assertEquals('Description', $builder->getDescription());

        $this->assertNull($builder->getPublic());
        $builder->setPublic(true);
        $this->assertTrue($builder->getPublic());

        $this->assertNull($builder->getExcludeFromSearch());
        $builder->setExcludeFromSearch(true);
        $this->assertTrue($builder->getExcludeFromSearch());

        $this->assertNull($builder->getPubliclyQueryable());
        $builder->setPubliclyQueryable(true);
        $this->assertTrue($builder->getPubliclyQueryable());

        $this->assertNull($builder->getShowUi());
        $builder->setShowUi(true);
        $this->assertTrue($builder->getShowUi());

        $this->assertNull($builder->getShowInNavMenus());
        $builder->setShowInNavMenus(true);
        $this->assertTrue($builder->getShowInNavMenus());

        $this->assertNull($builder->getShowInMenu());
        $builder->setShowInMenu(true);
        $this->assertTrue($builder->getShowInMenu());

        $this->assertNull($builder->getShowInAdminBar());
        $builder->setShowInAdminBar(true);
        $this->assertTrue($builder->getShowInAdminBar());

        $this->assertNull($builder->getMenuPosition());
        $builder->setMenuPosition(20);
        $this->assertEquals(20, $builder->getMenuPosition());

        $this->assertNull($builder->getMenuIcon());
        $builder->setMenuIcon('document-icon');
        $this->assertEquals('document-icon', $builder->getMenuIcon());

        $this->assertNull($builder->getCapabilityType());
        $builder->setCapabilityType('document');
        $this->assertEquals('document', $builder->getCapabilityType());

        $this->assertNull($builder->getCapabilities());
        $builder->setCapabilities([PostTypeCapability::READ_POST => 'read_document']);
        $this->assertEquals([PostTypeCapability::READ_POST => 'read_document'], $builder->getCapabilities());

        $this->assertNull($builder->getMapMetaCapabilities());
        $builder->setMapMetaCapabilities(true);
        $this->assertTrue($builder->getMapMetaCapabilities());

        $this->assertNull($builder->getHierarchical());
        $builder->setHierarchical(true);
        $this->assertTrue($builder->getHierarchical());

        $this->assertNull($builder->getSupports());
        $builder->setSupports([PostTypeSupports::TITLE, PostTypeSupports::REVISIONS]);
        $this->assertEquals([PostTypeSupports::TITLE, PostTypeSupports::REVISIONS], $builder->getSupports());

        $this->assertNull($builder->getMetaBoxCallback());
        $builder->setMetaBoxCallback([$this, 'callbackMetaBox']);
        $this->assertEquals([$this, 'callbackMetaBox'], $builder->getMetaBoxCallback());

        $this->assertNull($builder->getTaxonomies());
        $builder->setTaxonomies(['document_category']);
        $this->assertEquals(['document_category'], $builder->getTaxonomies());

        $this->assertNull($builder->getHasArchive());
        $builder->setHasArchive(true);
        $this->assertTrue($builder->getHasArchive());

        $this->assertNull($builder->getRewrite());
        $builder->setRewrite(['slug' => 'document']);
        $this->assertEquals(['slug' => 'document'], $builder->getRewrite());

        $this->assertNull($builder->getQueryVar());
        $builder->setQueryVar('document');
        $this->assertEquals('document', $builder->getQueryVar());

        $this->assertNull($builder->getCanExport());
        $builder->setCanExport(true);
        $this->assertTrue($builder->getCanExport());

        $this->assertNull($builder->getDeleteWithUser());
        $builder->setDeleteWithUser(true);
        $this->assertTrue($builder->getDeleteWithUser());

        $this->assertNull($builder->getShowInRest());
        $builder->setShowInRest(true);
        $this->assertTrue($builder->getShowInRest());

        $this->assertNull($builder->getRestBase());
        $builder->setRestBase('documents');
        $this->assertEquals('documents', $builder->getRestBase());

        $this->assertNull($builder->getRestControllerClass());
        $builder->setRestControllerClass('\WP_REST_Terms_Controller_Test');
        $this->assertEquals('\WP_REST_Terms_Controller_Test', $builder->getRestControllerClass());

        $this->assertEquals([
            'label' => 'Document',
            'labels' => ['name' => 'Documents', 'singular_name' => 'Document'],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => true,
            'rest_base' => 'documents',
            'rest_controller_class' => '\WP_REST_Terms_Controller_Test',
            'description' => 'Description',
            'hierarchical' => true,
            'query_var' => 'document',
            'rewrite' => ['slug' => 'document'],
            'capabilities' => [PostTypeCapability::READ_POST => 'read_document'],
            'exclude_from_search' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 20,
            'menu_icon' => 'document-icon',
            'capability_type' => 'document',
            'map_meta_cap' => true,
            'supports' => [PostTypeSupports::TITLE, PostTypeSupports::REVISIONS],
            'register_meta_box_cb' => [$this, 'callbackMetaBox'],
            'taxonomies' => ['document_category'],
            'has_archive' => true,
            'can_export' => true,
            'delete_with_user' => true,
        ], $builder->build());
    }

    public function callbackMetaBox(): void
    {
    }
}

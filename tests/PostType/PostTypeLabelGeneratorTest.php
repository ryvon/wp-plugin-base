<?php

namespace Ryvon\Plugin\PostType;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

class PostTypeLabelGeneratorTest extends TestCase
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
        $generator = new PostTypeLabelGenerator();

        $this->assertEquals([
            'name' => 'Documents',
            'singular_name' => 'Document',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Document',
            'edit_item' => 'Edit Document',
            'new_item' => 'New Document',
            'view_item' => 'View Document',
            'view_items' => 'View Documents',
            'search_items' => 'Search Documents',
            'not_found' => 'No documents found.',
            'not_found_in_trash' => 'No documents found in Trash.',
            'parent_item_colon' => 'Parent Document:',
            'all_items' => 'All Documents',
            'archives' => 'Document Archives',
            'attributes' => 'Document Attributes',
            'insert_into_item' => 'Insert into document',
            'uploaded_to_this_item' => 'Uploaded to this document',
            'menu_name' => 'Documents',
            'filter_items_list' => 'Filter documents list',
            'items_list_navigation' => 'Documents list navigation',
            'items_list' => 'Documents list',
            'name_admin_bar' => 'Document',
            'item_published' => 'Document published.',
            'item_published_privately' => 'Document published privately.',
            'item_reverted_to_draft' => 'Document reverted to draft.',
            'item_scheduled' => 'Document scheduled.',
            'item_updated' => 'Document updated.',
        ], $generator->generate('Document', 'Documents', 'default'));
    }
}

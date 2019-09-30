<?php

namespace Ryvon\Plugin\PostType;

class PostTypeLabelGenerator implements PostTypeLabelGeneratorInterface
{
    /**
     * @param string $singular
     * @param string $plural
     * @param string $textDomain
     * @return array
     */
    public function generate(string $singular, string $plural, string $textDomain = 'default'): array
    {
        $lowerSingular = strtolower($singular);
        $lowerPlural = strtolower($plural);
        return [
            'name' => _x($plural, 'post type general name', $textDomain),
            'singular_name' => _x($singular, 'post type singular name', $textDomain),
            'add_new' => __('Add New', $textDomain),
            'add_new_item' => __("Add New {$singular}", $textDomain),
            'edit_item' => __("Edit {$singular}", $textDomain),
            'new_item' => __("New {$singular}", $textDomain),
            'view_item' => __("View {$singular}", $textDomain),
            'view_items' => __("View {$plural}", $textDomain),
            'search_items' => __("Search {$plural}", $textDomain),
            'not_found' => __("No {$lowerPlural} found.", $textDomain),
            'not_found_in_trash' => __("No {$lowerPlural} found in Trash.", $textDomain),
            'parent_item_colon' => __("Parent {$singular}:", $textDomain),
            'all_items' => __("All {$plural}", $textDomain),
            'archives' => __("{$singular} Archives", $textDomain),
            'attributes' => __("{$singular} Attributes", $textDomain),
            'insert_into_item' => __("Insert into {$lowerSingular}", $textDomain),
            'uploaded_to_this_item' => __("Uploaded to this {$lowerSingular}", $textDomain),
//          'featured_image' => __('Featured Image', $textDomain),
//          'set_featured_image' => __('Set featured image', $textDomain),
//          'remove_featured_image' => __('Remove featured image', $textDomain),
//          'use_featured_image' => __('Use as featured image', $textDomain),
            'menu_name' => _x($plural, 'admin menu', $textDomain),
            'filter_items_list' => __("Filter {$lowerPlural} list", $textDomain),
            'items_list_navigation' => __("{$plural} list navigation", $textDomain),
            'items_list' => __("{$plural} list", $textDomain),
            'name_admin_bar' => _x($singular, 'add new on admin bar', $textDomain),
            'item_published' => __("{$singular} published.", $textDomain),
            'item_published_privately' => __("{$singular} published privately.", $textDomain),
            'item_reverted_to_draft' => __("{$singular} reverted to draft.", $textDomain),
            'item_scheduled' => __("{$singular} scheduled.", $textDomain),
            'item_updated' => __("{$singular} updated.", $textDomain),
        ];
    }
}

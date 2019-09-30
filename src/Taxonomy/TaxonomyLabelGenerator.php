<?php

namespace Ryvon\Plugin\Taxonomy;

class TaxonomyLabelGenerator implements TaxonomyLabelGeneratorInterface
{
    /**
     * @param string $singular
     * @param string $plural
     * @param string $textDomain
     * @return array
     */
    public function generate(string $singular, string $plural, string $textDomain = 'default'): array
    {
        $lowerPlural = strtolower($plural);
        return [
            'name' => _x($plural, 'taxonomy general name', $textDomain),
            'singular_name' => _x($singular, 'taxonomy singular name', $textDomain),
            'menu_name' => _x($plural, 'admin menu', $textDomain),
            'all_items' => __("All {$plural}", $textDomain),
            'edit_item' => __("Edit {$singular}", $textDomain),
            'view_item' => __("View {$singular}", $textDomain),
            'update_item' => __("Update {$singular}", $textDomain),
            'add_new_item' => __("Add New {$singular}", $textDomain),
            'new_item_name' => __("New {$singular} Name", $textDomain),
            'parent_item' => __("Parent {$singular}", $textDomain),
            'parent_item_colon' => __("Parent {$singular}:", $textDomain),
            'search_items' => __("Search {$plural}", $textDomain),
            'popular_items' => __("Popular {$plural}", $textDomain),
            'separate_items_with_commas' => __("Separate {$lowerPlural} with commas", $textDomain),
            'add_or_remove_items' => __("Add or remove {$lowerPlural}", $textDomain),
            'choose_from_most_used' => __("Choose from the most used {$lowerPlural}", $textDomain),
            'not_found' => __("No {$lowerPlural} found.", $textDomain),
            'back_to_items' => __("&larr; Back to {$plural}", $textDomain),
        ];
    }
}

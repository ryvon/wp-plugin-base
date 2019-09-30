<?php

namespace Ryvon\Plugin\Taxonomy;

abstract class TaxonomyCapability
{
    public const MANAGE_TERMS = 'manage_terms';

    public const EDIT_TERMS = 'edit_terms';

    public const DELETE_TERMS = 'delete_terms';

    public const ASSIGN_TERMS = 'assign_terms';

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        return [
            static::MANAGE_TERMS,
            static::EDIT_TERMS,
            static::DELETE_TERMS,
            static::ASSIGN_TERMS,
        ];
    }
}

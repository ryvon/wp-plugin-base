<?php

namespace Ryvon\Plugin\PostType;

abstract class PostTypeSupports
{
    /**
     * Post type title (includes slug).
     */
    public const TITLE = 'title';

    public const EDITOR = 'editor';

    public const AUTHOR = 'author';

    /**
     * Featured image support, current theme must also support
     * {@link https://codex.wordpress.org/Post_Thumbnails Post Thumbnails})
     */
    public const THUMBNAIL = 'thumbnail';

    public const EXCERPT = 'excerpt';

    public const TRACKBACKS = 'trackbacks';

    public const CUSTOM_FIELDS = 'custom-fields';

    /**
     * Allow comments. Will also will see comment count balloon on edit screen.
     */
    public const COMMENTS = 'comments';

    /**
     * Content revisions.
     */
    public const REVISIONS = 'revisions';

    /**
     * Menu order, hierarchical must be true to show Parent option
     */
    public const PAGE_ATTRIBUTES = 'page-attributes';

    /**
     * Add post formats, see {@link https://wordpress.org/support/article/post-formats/ Post Formats}.
     */
    public const POST_FORMATS = 'post-formats';

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        return [
            static::TITLE,
            static::EDITOR,
            static::AUTHOR,
            static::THUMBNAIL,
            static::EXCERPT,
            static::TRACKBACKS,
            static::CUSTOM_FIELDS,
            static::COMMENTS,
            static::REVISIONS,
            static::PAGE_ATTRIBUTES,
            static::POST_FORMATS,
        ];
    }
}

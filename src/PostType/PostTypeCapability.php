<?php

namespace Ryvon\Plugin\PostType;

abstract class PostTypeCapability
{
    // Meta capabilities
    public const EDIT_POST = 'edit_post';

    public const READ_POST = 'read_post';

    public const DELETE_POST = 'delete_post';

    // Primitive capabilities used outside of map_meta_cap():

    /**
     * Controls whether objects of this post type can be edited.
     */
    public const EDIT_POSTS = 'edit_posts';

    /**
     * Controls whether objects of this type owned by other users can be edited. If the post type does not support an
     * author, then this will behave like edit_posts.
     */
    public const EDIT_OTHERS_POSTS = 'edit_others_posts';

    /**
     * Controls publishing objects of this post type.
     */
    public const PUBLISH_POSTS = 'publish_posts';

    /**
     * Controls whether private objects can be read.
     */
    public const READ_PRIVATE_POSTS = 'read_private_posts';

    // Primitive capabilities used within map_meta_cap():

    /**
     * Controls whether objects of this post type can be read.
     */
    public const READ = 'read';

    /**
     * Controls whether objects of this post type can be deleted.
     */
    public const DELETE_POSTS = 'delete_posts';

    /**
     * Controls whether private objects can be deleted.
     */
    public const DELETE_PRIVATE_POSTS = 'delete_private_posts';

    /**
     * Controls whether published objects can be deleted.
     */
    public const DELETE_PUBLISHED_POSTS = 'delete_published_posts';

    /**
     * Controls whether objects owned by other users can be can be deleted. If the post type does not support an author,
     * then this will behave like delete_posts.
     */
    public const DELETE_OTHERS_POSTS = 'delete_others_posts';

    /**
     * Controls whether private objects can be edited.
     */
    public const EDIT_PRIVATE_POSTS = 'edit_private_posts';

    /**
     * Controls whether published objects can be edited.
     */
    public const EDIT_PUBLISHED_POSTS = 'edit_published_posts';

    /**
     * Controls whether new objects can be created.
     */
    public const CREATE_POSTS = 'create_posts';

    /**
     * @return array
     */
    public static function getConstants(): array
    {
        return [
            static::EDIT_POST,
            static::READ_POST,
            static::DELETE_POST,
            static::EDIT_POSTS,
            static::EDIT_OTHERS_POSTS,
            static::PUBLISH_POSTS,
            static::READ_PRIVATE_POSTS,
            static::READ,
            static::DELETE_POSTS,
            static::DELETE_PRIVATE_POSTS,
            static::DELETE_PUBLISHED_POSTS,
            static::DELETE_OTHERS_POSTS,
            static::EDIT_PRIVATE_POSTS,
            static::EDIT_PUBLISHED_POSTS,
            static::CREATE_POSTS,
        ];
    }
}

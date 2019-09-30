<?php

namespace Ryvon\Plugin\PostType;

/**
 * @see https://codex.wordpress.org/Function_Reference/register_post_type
 */
class PostTypeArgumentsBuilder
{
    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var PostTypeLabelGeneratorInterface|null
     */
    private $labelGenerator;

    /**
     * @param PostTypeLabelGeneratorInterface|null $labelGenerator
     */
    public function __construct(?PostTypeLabelGeneratorInterface $labelGenerator = null)
    {
        if ($labelGenerator === null) {
            $this->labelGenerator = new PostTypeLabelGenerator();
        } else {
            $this->labelGenerator = $labelGenerator;
        }
    }

    /**
     * @return array
     */
    public function build(): array
    {
        return array_filter($this->arguments, static function ($value) {
            return $value !== null;
        });
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setArgument(string $key, $value): void
    {
        if ($value === null) {
            unset($this->arguments[$key]);
        } else {
            $this->arguments[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getArgument(string $key)
    {
        return $this->arguments[$key] ?? null;
    }

    /**
     * A plural descriptive name for the post type marked for translation.
     *
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->setArgument('label', $label);
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->getArgument('label');
    }

    /**
     * An array of labels for this post type.
     *
     * Default: post labels are used for non-hierarchical post types and page labels for hierarchical ones.
     *
     * @param array $labels
     */
    public function setLabels(array $labels): void
    {
        $this->setArgument('labels', $labels);
    }

    /**
     * @return array|null
     */
    public function getLabels(): ?array
    {
        return $this->getArgument('labels');
    }

    /**
     * Generates labels based on the defaults using the specified names.
     *
     * @param string $singularName
     * @param string $pluralName
     * @param string $textDomain
     */
    public function generateLabels(string $singularName, string $pluralName, string $textDomain): void
    {
        $this->setLabels($this->labelGenerator->generate($singularName, $pluralName, $textDomain));
    }

    /**
     * A short descriptive summary of what the post type is.
     *
     * Default: blank
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->setArgument('description', $description);
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->getArgument('description');
    }

    /**
     * Controls how the type is visible to authors (setShowInNavMenus, setShowUi) and readers (setExcludeFromSearch,
     * setPubliclyQueryable).
     *
     * Default: false
     *
     * @param bool $public
     */
    public function setPublic(bool $public): void
    {
        $this->setArgument('public', $public);
    }

    /**
     * @return bool|null
     */
    public function getPublic(): ?bool
    {
        return $this->getArgument('public');
    }

    /**
     * Whether to exclude posts with this post type from front end search results.
     *
     * Default: the _opposite_ of getPublic
     *
     * @param bool $excludeFromSearch
     */
    public function setExcludeFromSearch(bool $excludeFromSearch): void
    {
        $this->setArgument('exclude_from_search', $excludeFromSearch);
    }

    /**
     * @return bool|null
     */
    public function getExcludeFromSearch(): ?bool
    {
        return $this->getArgument('exclude_from_search');
    }

    /**
     * Whether queries can be performed on the front end as part of parse_request().
     *
     * Default: value of getPublic
     *
     * @param bool $publiclyQueryable
     */
    public function setPubliclyQueryable(bool $publiclyQueryable): void
    {
        $this->setArgument('publicly_queryable', $publiclyQueryable);
    }

    /**
     * @return bool|null
     */
    public function getPubliclyQueryable(): ?bool
    {
        return $this->getArgument('publicly_queryable');
    }

    /**
     * Whether to generate a default UI for managing this post type in the admin.
     *
     * Default: value of getPublic
     *
     * @param bool $showUi
     */
    public function setShowUi(bool $showUi): void
    {
        $this->setArgument('show_ui', $showUi);
    }

    /**
     * @return bool|null
     */
    public function getShowUi(): ?bool
    {
        return $this->getArgument('show_ui');
    }

    /**
     * Whether post_type is available for selection in navigation menus.
     *
     * Default: value of getPublic
     *
     * @param bool $showInNavMenus
     */
    public function setShowInNavMenus(bool $showInNavMenus): void
    {
        $this->setArgument('show_in_nav_menus', $showInNavMenus);
    }

    /**
     * @return bool|null
     */
    public function getShowInNavMenus(): ?bool
    {
        return $this->getArgument('show_in_nav_menus');
    }

    /**
     * Where to show the post type in the admin menu. setShowUi must be true.
     *
     * Default: value of getShowUi
     *
     * @param bool|string $showInMenu
     *   false - do not display in the admin menu
     *   true - display as a top level menu
     *   'some string' - If an existing top level page such as 'tools.php' or 'edit.php?post_type=page', the post type
     *                   will be placed as a sub menu of that.
     */
    public function setShowInMenu($showInMenu): void
    {
        $this->setArgument('show_in_menu', $showInMenu);
    }

    /**
     * @return bool|string|null
     */
    public function getShowInMenu()
    {
        return $this->getArgument('show_in_menu');
    }

    /**
     * Whether to make this post type available in the WordPress admin bar.
     *
     * Default: value of getPublic
     *
     * @param bool $showInAdminBar
     */
    public function setShowInAdminBar(bool $showInAdminBar): void
    {
        $this->setArgument('show_in_admin_bar', $showInAdminBar);
    }

    /**
     * @return bool|null
     */
    public function getShowInAdminBar(): ?bool
    {
        return $this->getArgument('show_in_admin_bar');
    }

    /**
     * Whether to make this post type available in the WordPress admin bar.
     *
     * Default: value of getPublic
     *
     * @param int $menuPosition
     */
    public function setMenuPosition(int $menuPosition): void
    {
        $this->setArgument('menu_position', $menuPosition);
    }

    /**
     * @return int|null
     */
    public function getMenuPosition(): ?int
    {
        return $this->getArgument('menu_position');
    }

    /**
     * The url to the icon to be used for this menu or the name of the icon from the iconfont.
     *
     * Default: null - defaults to the posts icon
     *
     * @param string $menuIcon
     *   Icon examples
     *     'dashicons-video-alt' (Uses the video icon from Dashicons)
     *     'get_template_directory_uri() . "/images/post-type-icon.png"' (Use a image located in the current theme)
     *     'data:image/svg+xml;base64,' . base64_encode("<svg...")' (directly embedding a svg with 'fill="black"' will
     *                                                               allow correct colors)
     */
    public function setMenuIcon(string $menuIcon): void
    {
        $this->setArgument('menu_icon', $menuIcon);
    }

    /**
     * @return string|null
     */
    public function getMenuIcon(): ?string
    {
        return $this->getArgument('menu_icon');
    }

    /**
     * The string to use to build the read, edit, and delete capabilities. May be passed as an array to allow for
     * alternative plurals when using this argument as a base to construct the capabilities, e.g. ['story', 'stories']
     * the first array element will be used for the singular capabilities and the second array element for the plural
     * capabilities, this is instead of the auto generated version if no array is given which would be "storys". The
     * 'capability_type' parameter is used as a base to construct capabilities unless they are explicitly set with the
     * 'capabilities' parameter. It seems that `map_meta_cap` needs to be set to false or null, to make this work
     * (see note 2 at {@link https://codex.wordpress.org/Function_Reference/register_post_type register_post_type} docs.
     *
     * Default: 'post'
     *
     * Example: with "book" or ['book', 'books'] value, it will generate the 7 capabilities equal to set capabilities
     * parameter to this:
     *     'capabilities' => array(
     *          'edit_post'          => 'edit_book',
     *          'read_post'          => 'read_book',
     *          'delete_post'        => 'delete_book',
     *          'edit_posts'         => 'edit_books',
     *          'edit_others_posts'  => 'edit_others_books',
     *          'publish_posts'      => 'publish_books',
     *          'read_private_posts' => 'read_private_books',
     *          'create_posts'       => 'edit_books',
     *     ),
     *
     * @param string|array $capabilityType
     */
    public function setCapabilityType($capabilityType): void
    {
        $this->setArgument('capability_type', $capabilityType);
    }

    /**
     * @return string|array|null
     */
    public function getCapabilityType()
    {
        return $this->getArgument('capability_type');
    }

    /**
     * An array of the capabilities for this post type.
     *
     * By default, seven keys are accepted as part of the capabilities array:
     *
     * These three are meta capabilities, which are then generally mapped to corresponding primitive capabilities
     * depending on the context, for example the post being edited/read/deleted and the user or role being checked.
     * Thus these capabilities would generally not be granted directly to users or roles.
     *     PostTypeCapability::EDIT_POST (edit_post)
     *     PostTypeCapability::READ_POST (read_post)
     *     PostTypeCapability::DELETE_POST (delete_post)
     *
     * These four are primitive capabilities and are checked in the WP core in various locations.
     *     PostTypeCapability::EDIT_POSTS (edit_posts)
     *     PostTypeCapability::EDIT_OTHERS_POSTS (edit_others_posts)
     *     PostTypeCapability::PUBLISH_POSTS (publish_posts)
     *     PostTypeCapability::READ_PRIVATE_POSTS (read_private_posts)
     *
     * There are also eight other primitive capabilities which are not referenced directly in core, except in
     * map_meta_cap(), which takes the three aforementioned meta capabilities and translates them into one or more
     * primitive capabilities that must then be checked against the user or role, depending on the context. These
     * additional capabilities are only used in map_meta_cap(). Thus, they are only assigned by default if the post
     * type is registered with the setMapMetaCapabilities argument set to true (default is false).
     *     PostTypeCapability::READ (read)
     *     PostTypeCapability::DELETE_POSTS (delete_posts)
     *     PostTypeCapability::DELETE_PRIVATE_POSTS (delete_private_posts)
     *     PostTypeCapability::DELETE_PUBLISHED_POSTS (delete_published_posts)
     *     PostTypeCapability::DELETE_OTHERS_POSTS (delete_others_posts)
     *     PostTypeCapability::EDIT_PRIVATE_POSTS (edit_private_posts)
     *     PostTypeCapability::EDIT_PUBLISHED_POSTS (edit_published_posts)
     *     PostTypeCapability::CREATE_POSTS (create_posts)
     *
     * Default: null - getCapabilityType is used to construct
     *
     * @param array $capabilities
     */
    public function setCapabilities(array $capabilities): void
    {
        $this->setArgument('capabilities', $capabilities);
    }

    /**
     * @return array|null
     */
    public function getCapabilities(): ?array
    {
        return $this->getArgument('capabilities');
    }

    /**
     * Whether to use the internal default meta capability handling.
     *
     * Default: null
     *
     * @param bool $mapMetaCapabilities
     */
    public function setMapMetaCapabilities(bool $mapMetaCapabilities): void
    {
        $this->setArgument('map_meta_cap', $mapMetaCapabilities);
    }

    /**
     * @return bool|null
     */
    public function getMapMetaCapabilities(): ?bool
    {
        return $this->getArgument('map_meta_cap');
    }

    /**
     * Whether the post type is hierarchical (e.g. page). Allows Parent to be specified. The 'supports' parameter should
     * contain 'page-attributes' to show the parent select box on the editor page.
     *
     * Default: false
     *
     * Note: this parameter was intended for Pages. Be careful when choosing it for your custom post type - if you are
     * planning to have very many entries (say - over 2-3 thousand), you will run into load time issues. With this
     * parameter set to true WordPress will fetch all IDs of that particular post type on each administration page
     * load for your post type. Servers with limited memory resources may also be challenged by this parameter
     * being set to true.
     *
     * @param bool $hierarchical
     */
    public function setHierarchical(bool $hierarchical): void
    {
        $this->setArgument('hierarchical', $hierarchical);
    }

    /**
     * @return bool|null
     */
    public function getHierarchical(): ?bool
    {
        return $this->getArgument('hierarchical');
    }

    /**
     * Registers support of certain feature(s) for the post type. Each feature has a direct impact on the corresponding
     * field displayed in the post edit screen, such as the editor or a meta box. Additionally, the 'revisions' feature
     * dictates whether the post type will store revisions, and the 'comments' feature dictates whether the comments
     * count will show on the post edit screen.
     *
     * Default: title and editor
     *
     * @param array|false $supports
     */
    public function setSupports($supports): void
    {
        $this->setArgument('supports', $supports);
    }

    /**
     * @return array|false|null
     */
    public function getSupports()
    {
        return $this->getArgument('supports');
    }

    /**
     * Provide a callback function that will be called when setting up the meta boxes for the edit form.
     *
     * Callback params:
     *     \WP_Post $post Post object.
     *
     * Default: null
     *
     * @param callable $callback
     */
    public function setMetaBoxCallback(callable $callback): void
    {
        $this->setArgument('register_meta_box_cb', $callback);
    }

    /**
     * @return callable|null
     */
    public function getMetaBoxCallback(): ?callable
    {
        return $this->getArgument('register_meta_box_cb');
    }

    /**
     * An array of registered taxonomies like category or post_tag that will be used with this post type. This can be
     * used in lieu of calling register_taxonomy_for_object_type() directly. Custom taxonomies still need to be
     * registered with register_taxonomy().
     *
     * Default: none
     *
     * @param string[] $taxonomies
     */
    public function setTaxonomies(array $taxonomies): void
    {
        $this->setArgument('taxonomies', $taxonomies);
    }

    /**
     * @return array|null
     */
    public function getTaxonomies(): ?array
    {
        return $this->getArgument('taxonomies');
    }

    /**
     * Enables post type archives. Will use post type as archive slug by default.
     *
     * Default: false
     *
     * Note: Will generate the proper rewrite rules if setRewrite is enabled. Also use setRewrite to change the slug
     * used. If string, it should be translatable.
     *
     * @param bool|string $hasArchive
     */
    public function setHasArchive($hasArchive): void
    {
        $this->setArgument('has_archive', $hasArchive);
    }

    /**
     * @return bool|string|null
     */
    public function getHasArchive()
    {
        return $this->getArgument('has_archive');
    }

    /**
     * Triggers the handling of rewrites for this post type. To prevent rewrites, set to false.
     *
     * Default: true and use post type as slug
     *
     * Note: If registering a post type inside of a plugin, call flush_rewrite_rules() in your activation and
     * deactivation hook. If flush_rewrite_rules() is not used, then you will have to manually go to
     * Settings > Permalinks and refresh your permalink structure before your custom post type will show the correct
     * structure.
     *
     * $rewrite array options
     *     'slug' => string Customize the permalink structure slug. Defaults to post type. Should be translatable.
     *     'with_front' => bool Should the permalink structure be prepended with the front base. Defaults to true.
     *     'feeds' => bool Should a feed permalink structure be built for this post type. Defaults to has_archive value.
     *     'pages' => bool Should the permalink structure provide for pagination. Defaults to true
     *     'ep_mask' => const Assign an endpoint mask for this post type.
     *
     * @param bool|array $rewrite
     */
    public function setRewrite($rewrite): void
    {
        $this->setArgument('rewrite', $rewrite);
    }

    /**
     * @return bool|array|null
     */
    public function getRewrite()
    {
        return $this->getArgument('rewrite');
    }

    /**
     * Sets the query_var key for this post type.
     *
     * Default: true - set to post type
     *
     * Values:
     *     'false' - Disables query_var key use. A post type cannot be loaded at /?{query_var}={single_post_slug}
     *     'string' - /?{query_var_string}={single_post_slug} will work as intended.
     *
     * @param string|bool $queryVar
     */
    public function setQueryVar($queryVar): void
    {
        $this->setArgument('query_var', $queryVar);
    }

    /**
     * @return string|bool|null
     */
    public function getQueryVar()
    {
        return $this->getArgument('query_var');
    }

    /**
     * Can this post type be exported.
     *
     * Default: true
     *
     * @param bool $canExport
     */
    public function setCanExport(bool $canExport): void
    {
        $this->setArgument('can_export', $canExport);
    }

    /**
     * @return bool|null
     */
    public function getCanExport(): ?bool
    {
        return $this->getArgument('can_export');
    }

    /**
     * Whether to delete posts of this type when deleting a user. If true, posts of this type belonging to the user will
     * be moved to trash when then user is deleted. If false, posts of this type belonging to the user will not be
     * trashed or deleted. If not set (the default), posts are trashed if post_type_supports('author'). Otherwise posts
     * are not trashed or deleted.
     *
     * Default: not set
     *
     * @param bool $deleteWithUser
     */
    public function setDeleteWithUser(bool $deleteWithUser): void
    {
        $this->setArgument('delete_with_user', $deleteWithUser);
    }

    /**
     * @return bool|null
     */
    public function getDeleteWithUser(): ?bool
    {
        return $this->getArgument('delete_with_user');
    }

    /**
     * Whether to expose this post type in the REST API. Must be true to enable the Gutenberg editor.
     *
     * Default: false
     *
     * @param bool $showInRest
     */
    public function setShowInRest(bool $showInRest): void
    {
        $this->setArgument('show_in_rest', $showInRest);
    }

    /**
     * @return bool|null
     */
    public function getShowInRest(): ?bool
    {
        return $this->getArgument('show_in_rest');
    }

    /**
     * The base slug that this post type will use when accessed using the REST API.
     *
     * Default: post type
     *
     * @param string $restBase
     */
    public function setRestBase(string $restBase): void
    {
        $this->setArgument('rest_base', $restBase);
    }

    /**
     * @return string|null
     */
    public function getRestBase(): ?string
    {
        return $this->getArgument('rest_base');
    }

    /**
     * An optional custom controller to use instead of WP_REST_Posts_Controller. Must be a subclass of
     * WP_REST_Controller.
     *
     * Default: WP_REST_Posts_Controller
     *
     * @param string $restControllerClass
     */
    public function setRestControllerClass(string $restControllerClass): void
    {
        $this->setArgument('rest_controller_class', $restControllerClass);
    }

    /**
     * @return string|null
     */
    public function getRestControllerClass(): ?string
    {
        return $this->getArgument('rest_controller_class');
    }
}

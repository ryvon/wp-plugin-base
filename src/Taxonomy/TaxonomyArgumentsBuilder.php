<?php

namespace Ryvon\Plugin\Taxonomy;

/**
 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
class TaxonomyArgumentsBuilder
{
    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var TaxonomyLabelGenerator|null
     */
    private $labelGenerator;

    /**
     * @param TaxonomyLabelGeneratorInterface|null $labelGenerator
     */
    public function __construct(?TaxonomyLabelGeneratorInterface $labelGenerator = null)
    {
        if ($labelGenerator === null) {
            $this->labelGenerator = new TaxonomyLabelGenerator();
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
     * A plural descriptive name for the taxonomy marked for translation.
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
     * An array of labels for this taxonomy.
     *
     * Default: tag labels are used for non-hierarchical types and category labels for hierarchical ones.
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
     * Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users
     * (setPubliclyQueryable, setShowUi, setShowInNavMenus).
     *
     * Default: true
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
     * Whether the taxonomy is publicly queryable.
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
     * Whether to generate a default UI for managing this taxonomy.
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
     * Where to show the taxonomy in the admin menu. show_ui must be true
     *
     * Default: value of getShowUi
     *
     * @param bool $showInMenu
     */
    public function setShowInMenu(bool $showInMenu): void
    {
        $this->setArgument('show_in_menu', $showInMenu);
    }

    /**
     * @return bool|null
     */
    public function getShowInMenu(): ?bool
    {
        return $this->getArgument('show_in_menu');
    }

    /**
     * Whether to make this taxonomy available for selection in navigation menus.
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
     * Whether to include the taxonomy in the REST API. You will need to set this to true in order to use the taxonomy
     * in your gutenberg metablock.
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
     * To change the base url of REST API route.
     *
     * Default: taxonomy name
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
     * REST API Controller class name.
     *
     * Default: WP_REST_Terms_Controller
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

    /**
     * Whether to allow the Tag Cloud widget to use this taxonomy.
     *
     * Default: value of getShowUi
     *
     * @param bool $showTagCloud
     */
    public function setShowTagCloud(bool $showTagCloud): void
    {
        $this->setArgument('show_tagcloud', $showTagCloud);
    }

    /**
     * @return bool|null
     */
    public function getShowTagCloud(): ?bool
    {
        return $this->getArgument('show_tagcloud');
    }

    /**
     * Whether to show the taxonomy in the quick/bulk edit panel.
     *
     * Default: value of getShowUi
     *
     * @param bool $showInQuickEdit
     */
    public function setShowInQuickEdit(bool $showInQuickEdit): void
    {
        $this->setArgument('show_in_quick_edit', $showInQuickEdit);
    }

    /**
     * @return bool|null
     */
    public function getShowInQuickEdit(): ?bool
    {
        return $this->getArgument('show_in_quick_edit');
    }

    /**
     * Provide a callback function name for the meta box display.
     *
     * Callback params:
     *     \WP_Post $post Post object.
     *     array $box {
     *       string $id Meta box 'id' attribute.
     *       string $title Meta box title.
     *       callable $callback Meta box display callback.
     *       array $args {
     *         string $taxonomy Taxonomy. Default 'category'.
     *       }
     *     }
     *
     * Default: null
     *
     * @param callable $callback
     */
    public function setMetaBoxCallback(callable $callback): void
    {
        $this->setArgument('meta_box_cb', $callback);
    }

    /**
     * @return callable|null
     */
    public function getMetaBoxCallback(): ?callable
    {
        return $this->getArgument('meta_box_cb');
    }

    /**
     * Whether to allow automatic creation of taxonomy columns on associated post-types table.
     *
     * Default: false
     *
     * @param bool $showAdminColumn
     */
    public function setShowAdminColumn(bool $showAdminColumn): void
    {
        $this->setArgument('show_admin_column', $showAdminColumn);
    }

    /**
     * @return bool|null
     */
    public function getShowAdminColumn(): ?bool
    {
        return $this->getArgument('show_admin_column');
    }

    /**
     * A short description of the taxonomy.
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
     * Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.
     *
     * Default: false
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
     * A function name that will be called when the count of an associated $object_type, such as post, is updated.
     * Works much like a hook.
     *
     * Callback params:
     *     array $terms The term_taxonomy_id of terms to update.
     *     string $taxonomy The context of the term.
     *
     * Default: none
     *
     * @param callable $callback
     * @see https://codex.wordpress.org/Function_Reference/register_taxonomy Notes on update count callback
     */
    public function setUpdateCountCallback(callable $callback): void
    {
        $this->setArgument('update_count_callback', $callback);
    }

    /**
     * @return callable|null
     */
    public function getUpdateCountCallback(): ?callable
    {
        return $this->getArgument('update_count_callback');
    }

    /**
     * False to disable the query_var, set as string to use custom query_var instead of default which is the taxonomy
     * name.
     *
     * Default: taxonomy name
     *
     * @param string|false $queryVar
     */
    public function setQueryVar($queryVar): void
    {
        $this->setArgument('query_var', $queryVar);
    }

    /**
     * @return string|false|null
     */
    public function getQueryVar()
    {
        return $this->getArgument('query_var');
    }

    /**
     * Set to false to prevent automatic URL rewriting a.k.a. "pretty permalinks". Pass an $args array to override
     * default URL settings for permalinks as outlined below:
     *
     * Default: true
     *
     * $rewrite array options
     *     'slug' => string Used as pretty permalink text (i.e. /tag/) - defaults to taxonomy name
     *     'with_front' => bool Allowing permalinks to be prepended with front base - defaults to true
     *     'hierarchical' => bool Allow hierarchical urls  - defaults to false
     *     'ep_mask' => const (Required for pretty permalinks) Assign an endpoint mask - defaults to EP_NONE.
     *                        If you do not specify the EP_MASK, pretty permalinks will not work.
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
     * An array of the capabilities for this taxonomy.
     *
     * By default, four keys are accepted as part of the capabilities array:
     *     TaxonomyCapability::MANAGE_TERMS (manage_terms)
     *     TaxonomyCapability::EDIT_TERMS (edit_terms)
     *     TaxonomyCapability::DELETE_TERMS (delete_terms)
     *     TaxonomyCapability::ASSIGN_TERMS (assign_terms)
     *
     * Default: none
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
     * Whether this taxonomy should remember the order in which terms are added to objects.
     *
     * Default: none
     *
     * @param bool $sort
     */
    public function setSort(bool $sort): void
    {
        $this->setArgument('sort', $sort);
    }

    /**
     * @return bool|null
     */
    public function getSort(): ?bool
    {
        return $this->getArgument('sort');
    }
}

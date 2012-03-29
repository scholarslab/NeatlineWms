<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Plugin runner.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */


class NeatlineWmsPlugin
{

    // Hooks.
    private static $_hooks = array(
        'install',
        'uninstall',
        'define_routes',
        'after_save_form_item',
        'admin_append_to_items_show_primary',
        'public_append_to_items_show'
    );

    private static $_filters = array(
        'admin_items_form_tabs'
    );

    /**
     * Get database, add hooks and filters.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_db = get_db();
        $this->wmsTable = $this->_db->getTable('NeatlineWms');
        self::addHooksAndFilters();
    }

    /**
     * Iterate over hooks and filters, define callbacks.
     *
     * @return void
     */
    public function addHooksAndFilters()
    {

        foreach (self::$_hooks as $hookName) {
            $functionName = Inflector::variablize($hookName);
            add_plugin_hook($hookName, array($this, $functionName));
        }

        foreach (self::$_filters as $filterName) {
            $functionName = Inflector::variablize($filterName);
            add_filter($filterName, array($this, $functionName));
        }

    }


    /**
     * Hook callbacks:
     */


    /**
     * Install.
     *
     * @return void.
     */
    public function install()
    {

        // Web map services table.
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->_db->prefix}neatline_wms` (
                `id`              int(10) unsigned not null auto_increment,
                `item_id`         int(10) unsigned unique,
                `address`         text collate utf8_unicode_ci,
                `layers`          text collate utf8_unicode_ci,
                 PRIMARY KEY (`id`)
               ) ENGINE=innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $this->_db->query($sql);

    }

    /**
     * Uninstall.
     *
     * @return void.
     */
    public function uninstall()
    {

        // Drop the editions table.
        $sql = "DROP TABLE IF EXISTS `{$this->_db->prefix}neatline_wms`";
        $this->_db->query($sql);

    }

    /**
     * Register routes.
     *
     * @param object $router The router.
     *
     * @return void.
     */
    public function defineRoutes($router)
    {

        // Public edition view.
        $router->addRoute(
            'neatlineWms',
            new Zend_Controller_Router_Route(
                'neatline-wms/:action',
                array(
                    'module'        => 'neatline-wms',
                    'controller'    => 'index',
                    'action'        => 'browse'
                )
            )
        );

    }

    /**
     * Process WMS data on item add/edit.
     *
     * @param Item $record The item.
     * @param array $post The complete $_POST.
     *
     * @return void.
     */
    public function afterSaveFormItem($record, $post)
    {

        // Get WMS address and layers.
        $address = $post['address'];
        $layers = $post['layers'];

        // Create/update/delete.
        $this->wmsTable->createOrUpdate($record, $address, $layers);

    }

    /**
     * Show WMS in admin items show.
     *
     * @return void.
     */
    public function adminAppendToItemsShowPrimary()
    {

        // Get the item and service.
        $item = get_current_item();
        $service = $this->wmsTable->findByItem($item);

        if ($service) {

            // Create the renderer.
            $map = new GeoserverMap_WMS($service);

            echo __v()->partial('show.php', array(
                'mapTitle' => $map->mapTitle,
                'wmsAddress' => $map->wmsAddress,
                'layers' => $map->layers,
                'boundingBox' => $map->boundingBox,
                'epsg' => $map->epsg
            ));

        }

    }

    /**
     * Show WMS in public items show.
     *
     * @return void.
     */
    public function publicAppendToItemsShow()
    {

        // Get the item and service.
        $item = get_current_item();
        $service = $this->wmsTable->findByItem($item);

        if ($service) {

            // Create the renderer.
            $map = new GeoserverMap_WMS($service);

            echo __v()->partial('show.php', array(
                'mapTitle' => $map->mapTitle,
                'wmsAddress' => $map->wmsAddress,
                'layers' => $map->layers,
                'boundingBox' => $map->boundingBox,
                'epsg' => $map->epsg
            ));

        }

    }


    /**
     * Filter callbacks:
     */


    /**
     * Add tab to items add/edit.
     *
     * @param array $tabs Associative array with tab name => markup.
     *
     * @return array The tabs array with the Web Map Service tab.
     */
    public function adminItemsFormTabs($tabs)
    {

        // Set service false by default.
        $service = false;

        // Get item.
        $item = get_current_item();

        // If there is an item, try to get a service.
        if (!is_null($item->id)) {
            $service = $this->wmsTable->findByItem($item);
        }

        // Insert tab.
        $tabs['Web Map Service'] = __v()->partial(
          'items/_serviceForm.php', array(
            'service' => $service
          )
        );

        return $tabs;

    }

}

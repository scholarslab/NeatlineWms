<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Testing helper class.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2011 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

require_once '../NeatlineWmsPlugin.php';

class NLWMS_Test_AppTestCase extends Omeka_Test_AppTestCase
{

    private $_dbHelper;

    /**
     * Spin up the plugins and prepare the database.
     *
     * @return void.
     */
    public function setUpPlugin()
    {

        parent::setUp();

        $this->user = $this->db->getTable('User')->find(1);
        $this->_authenticateUser($this->user);
        $this->wmsTable = $this->db->getTable('NeatlineWms');

        // Set up Neatline WMS.
        $plugin_broker = get_plugin_broker();
        $this->_addHooksAndFilters($plugin_broker, 'NeatlineWms');
        $plugin_helper = new Omeka_Test_Helper_Plugin;
        $plugin_helper->setUp('NeatlineWms');

        $this->_dbHelper = Omeka_Test_Helper_Db::factory($this->core);

    }

    /**
     * Install Neatline WMS.
     *
     * @return void.
     */
    public function _addHooksAndFilters($plugin_broker, $plugin_name)
    {
        $plugin_broker->setCurrentPluginDirName($plugin_name);
        new NeatlineWmsPlugin;
    }


    /**
     * Test helpers.
     */


    /**
     * Create an item.
     *
     * @return Omeka_record $item The item.
     */
    public function __item()
    {
        $item = new Item;
        $item->save();
        return $item;
    }

}

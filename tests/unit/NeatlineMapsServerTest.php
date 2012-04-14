<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Edition row tests.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NLMAPS_NeatlineMapsServerTest extends NLMAPS_Test_AppTestCase
{

    /**
     * Install the plugin.
     *
     * @return void.
     */
    public function setUp()
    {
        $this->setUpPlugin();
    }

    /**
     * Test get and set on columns.
     *
     * @return void.
     */
    public function testAttributeAccess()
    {

        // Create a record.
        $server = new NeatlineMapsServer();

        // Set.
        $server->name = 'Test Server';
        $server->url = 'http://localhost:8080/geoserver';
        $server->username = 'admin';
        $server->password = 'geoserver';
        $server->namespace = 'namespace';
        $server->active = 1;
        $server->save();

        // Re-get the edition object.
        $wms = $this->serversTable->find($server->id);

        // Get.
        $this->assertEquals($server->name, 'Test Server');
        $this->assertEquals($server->url, 'http://localhost:8080/geoserver');
        $this->assertEquals($server->username, 'admin');
        $this->assertEquals($server->password, 'geoserver');
        $this->assertEquals($server->namespace, 'namespace');
        $this->assertEquals($server->active, 1);

    }

}

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

class NLWMS_NeatlineWmsTest extends NLWMS_Test_AppTestCase
{

    /**
     * Install the plugin.
     *
     * @return void.
     */
    public function setUp()
    {
        $this->setUpPlugin();
        $this->wmsTable = $this->db->getTable('NeatlineWms');
    }

    /**
     * Test get and set on columns.
     *
     * @return void.
     */
    public function testAttributeAccess()
    {

        // Create a record.
        $wms = new NeatlineWms();

        // Set.
        $wms->title = 'Test Title';
        $wms->address = 'http://test.edu:8080/geoserver/ws/wms';
        $wms->layers = 'ws:test1,ws:test2';
        $wms->save();

        // Re-get the edition object.
        $wms = $this->wmsTable->find($wms->id);

        // Get.
        $this->assertEquals($wms->title, 'Test Title');
        $this->assertEquals($wms->address, 'http://test.edu:8080/geoserver/ws/wms');
        $this->assertEquals($wms->layers, 'ws:test1,ws:test2');

    }

}

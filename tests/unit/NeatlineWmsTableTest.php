<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Edition table tests.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NLWMS_NeatlineWmsTableTest extends NLWMS_Test_AppTestCase
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
     * findByItem() should return the record when one exists.
     *
     * @return void.
     */
    public function testFindByItemWhenRecordExists()
    {

        // Create a service.
        $item = $this->__item();
        $service = $this->__service($item);

        // Get out the service.
        $retrievedService = $this->wmsTable->findByItem($item);
        $this->assertEquals($retrievedService->id, $service->id);

    }

    /**
     * findByItem() should return boolean false when no record exists.
     *
     * @return void.
     */
    public function testFindByItemWhenNoRecordExists()
    {

        // Create item.
        $item = $this->__item();

        // Try to get out a service.
        $this->assertFalse($this->wmsTable->findByItem($item));

    }

    /**
     * createOrUpdate() should create a new record when one does not exist.
     *
     * @return void.
     */
    public function testCreateOrUpdateWithNoRecord()
    {

        // Create item.
        $item = $this->__item();

        // Capture starting count.
        $count = $this->wmsTable->count();

        // Create new record.
        $service = $this->wmsTable->createOrUpdate($item, 'address', 'layers');

        // Check for count++.
        $this->assertEquals($this->wmsTable->count(), $count+1);

        // Check attributes.
        $this->assertEquals($service->address, 'address');
        $this->assertEquals($service->layers, 'layers');

    }

    /**
     * createOrUpdate() should update an existing record when one exists.
     *
     * @return void.
     */
    public function testCreateOrUpdateWithExistingRecord()
    {

        // Create item and service.
        $item = $this->__item();
        $service = $this->__service($item, 'address1', 'layers1');

        // Capture starting count.
        $count = $this->wmsTable->count();

        // Create new record.
        $service = $this->wmsTable->createOrUpdate($item, 'address2', 'layers2');

        // Check for count.
        $this->assertEquals($this->wmsTable->count(), $count);

        // Check attributes.
        $this->assertEquals($service->address, 'address2');
        $this->assertEquals($service->layers, 'layers2');

    }

    /**
     * createOrUpdate() should delete an existing record when one exists and
     * empty data is passed to the method.
     *
     * @return void.
     */
    public function testCreateOrUpdateWithExistingRecordAndEmptyData()
    {

        // Create item and service.
        $item = $this->__item();
        $service = $this->__service($item, 'address1', 'layers1');

        // Capture starting count.
        $count = $this->wmsTable->count();

        // Create new record.
        $service = $this->wmsTable->createOrUpdate($item, '', '');

        // Check for count.
        $this->assertEquals($this->wmsTable->count(), $count-1);

        // Check for no record for the item.
        $this->assertFalse($this->wmsTable->findByItem($item));

    }

}

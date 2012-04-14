<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Servers controller integration tests.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NLMAPS_ServersControllerTest extends NLMAPS_Test_AppTestCase
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
     * Test for add form markup.
     *
     * @return void.
     */
    public function testAddServerFormMarkup()
    {

        $this->dispatch('neatline-maps/servers/add');
        $this->assertXpath('//input[@name="name"]');
        $this->assertXpath('//input[@name="url"]');
        $this->assertXpath('//input[@name="workspace"]');
        $this->assertXpath('//input[@name="username"]');
        $this->assertXpath('//input[@name="password"]');
        $this->assertXpath('//input[@name="active"]');

    }

    /**
     * By default, active should be checked on add form.
     *
     * @return void.
     */
    public function testAddServerDefaultActive()
    {

        $this->dispatch('neatline-maps/servers/add');
        $this->assertXpath('//input[@name="active"][@checked="checked"]');

    }

    /**
     * Test for form errors for empty fields.
     *
     * @return void.
     */
    public function testAddServerEmptyFieldErrors()
    {

        // Form post.
        $this->request->setMethod('POST')
            ->setPost(array(
                'name' => '',
                'url' => '',
                'workspace' => '',
                'username' => '',
                'password' => ''
            )
        );

        $this->dispatch('neatline-maps/servers/add');
        $this->assertQueryCount('ul.errors', 5);
        $this->assertQueryContentContains('ul.errors li', 'Enter a name.');
        $this->assertQueryContentContains('ul.errors li', 'Enter a URL.');
        $this->assertQueryContentContains('ul.errors li', 'Enter a workspace.');
        $this->assertQueryContentContains('ul.errors li', 'Enter a username.');
        $this->assertQueryContentContains('ul.errors li', 'Enter a password.');

    }

    /**
     * Test for form error for invalid URL.
     *
     * @return void.
     */
    public function testAddServerInvalidUrlError()
    {

        // Form post.
        $this->request->setMethod('POST')
            ->setPost(array(
                'name' => 'Test Server',
                'url' => 'invalid',
                'workspace' => 'workspace',
                'username' => 'admin',
                'password' => 'geoserver'
            )
        );

        $this->dispatch('neatline-maps/servers/add');
        $this->assertQueryCount('ul.errors', 1);
        $this->assertQueryContentContains('ul.errors li', 'Enter a valid URL.');

    }

    /**
     * Test for no form error for localhost URL.
     *
     * @return void.
     */
    public function testAddServerLocalUrl()
    {

        // Form post.
        $this->request->setMethod('POST')
            ->setPost(array(
                'name' => '',
                'url' => 'http://localhost:8080/geoserver',
                'workspace' => '',
                'username' => '',
                'password' => ''
            )
        );

        $this->dispatch('neatline-maps/servers/add');
        $this->assertNotQueryContentContains('ul.errors li', 'Enter a valid URL.');

    }

    /**
     * Valid form should create server.
     *
     * @return void.
     */
    public function testAddServerSuccess()
    {

        // Form post.
        $this->request->setMethod('POST')
            ->setPost(array(
                'name' => 'Test Title',
                'url' => 'http://localhost:8080/geoserver',
                'workspace' => 'workspace',
                'username' => 'admin',
                'password' => 'geoserver',
                'active' => 1
            )
        );

        // Capture starting count.
        $count = $this->serversTable->count();

        // Add.
        $this->dispatch('neatline-maps/servers/add');

        // Check count+1.
        $this->assertEquals($this->serversTable->count(), $count+1);

        // Get new server, check params.
        $server = $this->serversTable->find(1);
        $this->assertEquals($server->name, 'Test Title');
        $this->assertEquals($server->url, 'http://localhost:8080/geoserver');
        $this->assertEquals($server->namespace, 'workspace');
        $this->assertEquals($server->username, 'admin');
        $this->assertEquals($server->password, 'geoserver');
        $this->assertEquals($server->active, 1);

    }

    /**
     * If active is checked, existing active server should be toggled off.
     *
     * @return void.
     */
    public function testAddServerActiveUpdating()
    {

    }

}

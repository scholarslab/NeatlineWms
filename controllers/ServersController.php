<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Servers controller.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NeatlineMaps_ServersController extends Omeka_Controller_Action
{

    /**
     * Initialize.
     *
     * @return void
     */
    public function init()
    {
        $this->serversTable = $this->getTable('NeatlineMapsServer');
    }

    /**
     * Show servers.
     *
     * @return void
     */
    public function browseAction()
    {
        $this->view->servers = $this->serversTable->findAll();
    }

    /**
     * Add server.
     *
     * @return void
     */
    public function addAction()
    {

        // Create form.
        $form = new ServerForm;

        // If a form as been posted.
        if ($this->_request->isPost()) {

            // Get post.
            $post = $this->_request->getPost();

            // If form is valid.
            if ($form->isValid($post)) {

                // Create server.
                $this->serversTable->createServer($post);

                // Redirect to browse.
                $this->redirect->goto('browse');

            }

            // If form is invalid.
            else {
                $form->populate($post);
            }

        }

        // Push form to view.
        $this->view->form = $form;

    }

    /**
     * Edit server.
     *
     * @return void
     */
    public function editAction()
    {

    }

    /**
     * Delete server.
     *
     * @return void
     */
    public function deleteAction()
    {

    }

    /**
     * Set server active.
     *
     * @return void
     */
    public function activeAction()
    {

        // Get server.
        $server = $this->serversTable->find(
            $this->_request->getParam('id')
        );

        // Set active and save.
        $server->active = 1;
        $server->save();

        // Redirect to browse.
        $this->redirect->goto('browse');

    }

}

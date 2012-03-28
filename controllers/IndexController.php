<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Index controller.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NeatlineWms_IndexController extends Omeka_Controller_Action
{

    /**
     * Get table objects.
     *
     * @return void
     */
    public function init()
    {
        $this->_wmsTable = $this->getTable('NeatlineWms');
    }

    /**
     * Show list of existing Neatlines.
     *
     * @return void
     */
    public function browseAction()
    {

        $sortField =    $this->_request->getParam('sort_field');
        $sortDir =      $this->_request->getParam('sort_dir');
        $page =         $this->_request->page;

        // Push pagination variables.
        $this->view->pagination = $this->_neatlinesTable
            ->getPaginationSettings($page);

        // Push Neatlines.
        $this->view->neatlines = $this->_neatlinesTable
            ->getNeatlinesForBrowse($sortField, $sortDir, $page);

    }

    /**
     * Create a new exhibit.
     *
     * @return void
     */
    public function addAction()
    {

        // Construct the form.
        $form = new AddExhibitForm;

        // Try to create the Neatline if the form has been submitted.
        if ($this->_request->isPost()) {

            // If no errors, save form and redirect.
            if ($form->isValid($this->_request->getPost())) {

                // Get values and create new exhibit.
                $values = $form->getValues();

                // Create exhibit and apply values.
                $exhibit = new NeatlineExhibit;
                $exhibit->saveForm(
                    $values['title'],
                    $values['slug'],
                    $values['public'],
                    $values['baselayer'],
                    $values['map'],
                    $values['image']
                );

                // Commit.
                $exhibit->save();

                return $this->_redirect('neatline-exhibits');

            }

        }

        // Push Neatline object into view.
        $this->view->form = $form;

    }

    /**
     * Edit an exhibit.
     *
     * @return void
     */
    public function editAction()
    {

        // Get the exhibit.
        $exhibit = $this->_neatlinesTable->findBySlug($this->_request->slug);

        // Construct the form.
        $form = new EditExhibitForm();
        $form->setExhibit($exhibit);

        // Populate the form.
        $form->populate(array(
            'title' => $exhibit->name,
            'slug' => $exhibit->slug,
            'public' => $exhibit->public
        ));

        // Try to edit if the form has been submitted.
        if ($this->_request->isPost()) {

            // If no errors, save form and redirect.
            if ($form->isValid($this->_request->getPost())) {

                // Capture values.
                $values = $form->getValues();

                // Apply values.
                $exhibit->name = $values['title'];
                $exhibit->slug = $values['slug'];
                $exhibit->public = (int) $values['public'];

                // Commit.
                $exhibit->save();

                return $this->_redirect('neatline-exhibits');

            }

        }

        // Push exhibit and form into view.
        $this->view->exhibit = $exhibit;
        $this->view->form = $form;

    }

    /**
     * Edit items query.
     *
     * @return void
     */
    public function queryAction()
    {

        // Get the exhibit.
        $exhibit = $this->_neatlinesTable->findBySlug($this->_request->slug);

        if(isset($_GET['search'])) {
            $exhibit->query = serialize($_GET);
            $exhibit->save();
            $this->redirect->goto('browse');
        } else {
            $queryArray = unserialize($exhibit->query);
            $_GET = $queryArray;
            $_REQUEST = $queryArray;
        }

    }

    /**
     * Delete exhibits.
     *
     * @return void
     */
    public function deleteAction()
    {

        $_post = $this->_request->getPost();
        $id = $this->_request->getParam('id');
        $neatline = $this->_neatlinesTable->find($id);
        $this->view->neatline = $neatline;

        // If the delete is confirmed.
        if (isset($_post['confirmed'])) {

            // Delete and redirect.
            $neatline->delete();
            $this->flashSuccess(neatline_deleteSucceed($neatline->name));
            $this->_redirect('neatline-exhibits');

        }

    }

}

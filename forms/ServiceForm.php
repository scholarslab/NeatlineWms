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

class ServiceForm extends Omeka_Form
{

    /**
     * Construct the form.
     *
     * @return void.
     */
    public function init()
    {

        parent::init();

        $this->setMethod('post');
        $this->setAttrib('id', 'server-form');
        $this->addElementPrefixPath('Neatline', dirname(__FILE__));

        // Title.
        $this->addElement('text', 'title', array(
            'label'         => 'Title',
            'description'   => 'The title of the layer collection.',
            'size'          => 50,
            'required'      => true,
            'validators'    => array(
                array('validator' => 'NotEmpty', 'breakChainOnFailure' => true, 'options' =>
                    array(
                        'messages' => array(
                            Zend_Validate_NotEmpty::IS_EMPTY => 'Enter a title.'
                        )
                    )
                )
            )
        ));

        // URL.
        $this->addElement('text', 'address', array(
            'label'         => 'URL',
            'description'   => 'The WMS address.',
            'size'          => 50,
            'required'      => true,
            'validators'    => array(
                array('validator' => 'NotEmpty', 'breakChainOnFailure' => true, 'options' =>
                    array(
                        'messages' => array(
                            Zend_Validate_NotEmpty::IS_EMPTY => 'Enter a URL.'
                        )
                    )
                ),
                array('validator' => 'IsUrl', 'breakChainOnFailure' => true, 'options' =>
                    array(
                        'messages' => array(
                            Neatline_Validate_IsUrl::INVALID_URL => 'Enter a valid URL.'
                        )
                    )
                )
            )
        ));

        // Username.
        $this->addElement('text', 'username', array(
            'label'         => 'Username',
            'description'   => 'Enter the Geoserver username.',
            'size'          => 40,
            'required'      => true,
            'validators'    => array(
                array('validator' => 'NotEmpty', 'breakChainOnFailure' => true, 'options' =>
                    array(
                        'messages' => array(
                            Zend_Validate_NotEmpty::IS_EMPTY => 'Enter a username.'
                        )
                    )
                )
            )
        ));

        // Password.
        $this->addElement('password', 'password', array(
            'label'         => 'Password',
            'description'   => 'Enter the Geoserver password.',
            'size'          => 40,
            'required'      => true,
            'validators'    => array(
                array('validator' => 'NotEmpty', 'breakChainOnFailure' => true, 'options' =>
                    array(
                        'messages' => array(
                            Zend_Validate_NotEmpty::IS_EMPTY => 'Enter a password.'
                        )
                    )
                )
            )
        ));

        // Submit.
        $this->addElement('submit', 'submit', array(
            'label' => 'Save'
        ));

        // Group the data fields.
        $this->addDisplayGroup(array('name', 'url', 'username', 'password'), 'server_information');

        // Group the submit button sparately.
        $this->addDisplayGroup(array('submit'), 'submit_button');

    }

}

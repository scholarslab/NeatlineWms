<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Server row class.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NeatlineMapsServer extends Omeka_record
{

    /**
     * The name of the server [string].
     */
    public $name;

    /**
     * The Geoserver URL [string].
     */
    public $url;

    /**
     * The Geoserver username [string].
     */
    public $username;

    /**
     * The Geoserver password [string].
     */
    public $password;

    /**
     * The Geoserver namespace [string].
     */
    public $namespace;

    /**
     * Whether the server is active [0/1].
     */
    public $active;

}

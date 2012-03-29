<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Define constants and instantiate the mamanger class.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */


// defines {{{

if (!defined('NLWMS_PLUGIN_VERSION')) {
    define(
        'NLWMS_PLUGIN_VERSION',
        get_plugin_ini('NeatlineWMS', 'version')
    );
}

if (!defined('NLWMS_PLUGIN_DIR')) {
    define(
        'NLWMS_PLUGIN_DIR',
        dirname(__FILE__)
    );
}

// }}}


// requires {{{
require_once NLWMS_PLUGIN_DIR . '/NeatlineWmsPlugin.php';
require_once NLWMS_PLUGIN_DIR . '/helpers/NeatlineWmsFunctions.php';
require_once NLWMS_PLUGIN_DIR . '/lib/GeoserverMap_Abstract.php';
require_once NLWMS_PLUGIN_DIR . '/lib/GeoserverMap_WMS.php';
// }}}


/*
 * Run.
 */
new NeatlineWmsPlugin;

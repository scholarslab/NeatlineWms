<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Browser servers action buttons.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<a href="<?php echo uri($uriSlug . '/edit/' . $server->id); ?>" class="edit">Edit</a>
<a href="<?php echo uri($uriSlug . '/delete/' . $server->id); ?>" class="delete">Delete</a>

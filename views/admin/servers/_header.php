<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Header template.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<div id="neatline-header">

    <h1>Neatline Maps | <?php echo $subtitle; ?></h1>

    <p class="add-button">
        <a class="add" href="<?php echo html_escape(uri($add_button_uri)); ?>">
            <?php echo $add_button_text; ?>
        </a>
    </p>

</div>

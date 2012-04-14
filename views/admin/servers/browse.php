<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Browser servers.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<?php
head(array('content_class' => 'neatline'));
?>

<?php echo $this->partial('servers/_header.php', array(
    'subtitle' => 'Browse Servers',
    'add_button_uri' => 'neatline-maps/add',
    'add_button_text' => 'Create a Server'
)); ?>

<div id="primary">

<?php echo flash(); ?>

<?php if(count($servers) > 0): ?>

<table>

    <thead>
        <tr>
        <!-- Column headings. -->
        <?php browse_headings(array(
            'Server' => null,
            'URL' => null,
            'Namespace' => null,
            'Status' => null
        )); ?>
        </tr>
    </thead>

    <tbody>
        <!-- Servers listings. -->
        <?php foreach ($servers as $server): ?>
        <tr serverid="<?php echo $server->id; ?>">
            <td class="title"><?php echo $server->name; ?>
                <?php echo $this->partial('index/_action_buttons.php', array(
                  'uriSlug' => 'neatline-maps',
                  'server' => $server)); ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<?php else: ?>

    <p class="neatline-alert">There are no servers yet.
    <a href="<?php echo uri('neatline-maps/add'); ?>">Create one!</a></p>

<?php endif; ?>

</div>

<?php
foot();
?>

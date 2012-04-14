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
queue_css('neatline-maps-admin');
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
            'Workspace' => null,
            'Status' => null,
            'Active' => null,
            'Actions' => null
        )); ?>
        </tr>
    </thead>

    <tbody>
        <!-- Servers listings. -->
        <?php foreach ($servers as $server): ?>
        <tr serverid="<?php echo $server->id; ?>">
            <td class="title">
                <div><?php echo $server->name; ?></div>
            </td>
            <td><a href="<?php echo $server->url; ?>" target="_blank"><?php echo $server->url; ?></a></td>
            <td><?php echo $server->namespace; ?></td>
            <td>
                <?php if ($server->isOnline()): ?>
                    <span class="online">Online</span>
                <?php else: ?>
                    <span class="offline">Offline</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($server->active): ?>
                    <img src="<?php echo img('silk-icons/tick.png'); ?>" />
                <?php else: ?>
                    <a href="<?php echo uri('neatline-maps/active/' . $server->id); ?>" class="">Set Active</a>
                <?php endif; ?>
            </td>
            <td>
                <?php echo $this->partial('servers/_action_buttons.php', array(
                  'uriSlug' => 'neatline-maps',
                  'server' => $server)); ?>
            </td>
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

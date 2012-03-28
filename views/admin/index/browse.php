<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Browse web map services.
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

<?php echo $this->partial('index/_header.php', array(
    'subtitle' => 'Browse Services',
    'add_button_uri' => 'neatline-wms/add',
    'add_button_text' => 'Create a Service'
)); ?>

<div id="primary">

<?php echo flash(); ?>

<?php if(count($neatlines) > 0): ?>

<table class="neatline">

    <thead>
        <tr>
        <!-- Column headings. -->
        <?php browse_headings(array(
            'Exhibit' => 'name',
            'View' => null,
            'Items Query' => null,
            'Modified' => 'modified',
            '# Items' => 'added',
            'Public' => 'public'
        )); ?>
        </tr>
    </thead>

    <tbody>
        <!-- Exhibit listings. -->
        <?php foreach ($neatlines as $neatline): ?>
        <tr exhibitid="<?php echo $neatline->id; ?>">
            <td class="title"><?php echo neatline_linkToNeatline($neatline); ?>
                <div class="slug-preview">/<?php echo $neatline->slug; ?></div>
                <?php echo $this->partial('index/_action_buttons.php', array(
                  'uriSlug' => 'neatline-exhibits',
                  'neatline' => $neatline)); ?>
            </td>
            <td>
                <div class="public-exhibit-links">
                    <a href="<?php echo public_uri('neatline-exhibits/show/fullscreen/' . $neatline->slug); ?>" target="_blank">Fullscreen</a> |
                    <a href="<?php echo public_uri('neatline-exhibits/show/embed/' . $neatline->slug); ?>" target="_blank">Embed</a>
                </div>
            </td>
            <td><a href="<?php echo uri('neatline-exhibits/query/' . $neatline->slug); ?>">Edit Query</a></td>
            <td><?php echo neatline_formatDate($neatline->modified); ?></td>
            <td><?php echo $neatline->getNumberOfRecords(); ?></td>
            <td><?php echo $neatline->public == 1 ? 'yes' : 'no'; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<!-- Pagination. -->
<?php if ($pagination['total_results'] > $pagination['per_page']): ?>
    <div class="pagination">
        <?php echo pagination_links(array('scrolling_style' => 'All',
        'page_range' => '5',
        'partial_file' => 'common/pagination_control.php',
        'page' => $pagination['current_page'],
        'per_page' => $pagination['per_page'],
        'total_results' => $pagination['total_results'])); ?>
    </div>
<?php endif; ?>

<?php else: ?>

    <p class="neatline-alert">There are no web map services yet.
    <a href="<?php echo uri('neatline-wms/add'); ?>">Create one!</a></p>

<?php endif; ?>

</div>

<?php
foot();
?>

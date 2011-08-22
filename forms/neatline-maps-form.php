<?php if ( count($maps) > 0 ): ?>
    <div id="map-list">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Server</th>
                <th>Namespace</th>
                <th>Item</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach( $maps as $map ): ?>
        <?php $numberOfFiles = $filesTable->numberOfFilesInMap($map->map_id); ?>
        <tr>
            <td>
                <a href="<?php echo uri('neatline-maps/maps/' . $map->map_id . '/files'); ?>"><strong><?php echo $map->name; ?></strong></a> (<?php echo $numberOfFiles; ?> file<?php if ($numberOfFiles > 1) { echo 's'; } ?>)
            </td>
            <td><a href="<?php echo uri('neatline-maps/servers/edit/' . $map->getServer()->id); ?>"><?php echo $map->getServer()->name; ?></a></td>
            <td><a href="<?php echo $map->getNamespaceUrl(); ?>" target="_blank"><?php echo $map->namespace; ?></a></td>
            <td><a href="<?php echo uri('items/show/' . $map->item_id); ?>"><?php echo $map->parent_item; ?></a></td>
            <td><a href="<?php echo uri('/neatline-maps/maps/' . $map->map_id . '/files'); ?>">View and Edit Files</a> | <a href="<?php echo uri('/neatline-maps/maps/delete/' . $map->map_id); ?>">Delete</a>

<!--                <form action="<?php echo uri('/neatline-maps/maps/' . $map->map_id . '/files'); ?>" method="post" class="button-form neatline-inline-form-servers">
                </form>

                <form action="<?php echo uri('/neatline-maps/maps/' . $map->map_id . '/files'); ?>" method="post" class="button-form neatline-inline-form-servers">
                  <input type="submit" value="View and Edit Files" class="fedora-inline-button bagit-create-bag">
                </form>

                <form action="<?php echo uri('/neatline-maps/maps/delete/' . $map->map_id); ?>" method="post" class="button-form neatline-inline-form-servers">
                  <input type="hidden" name="confirm" value="false" />
                  <input type="submit" value="Delete" class="fedora-inline-button fedora-delete">
                </form>
-->
            </td>

        </tr>

    <?php endforeach; ?>

    </tbody>
    </table>
    </div>

<!--
    <form action="<?php echo uri('/neatline-maps/maps/create/selectserver'); ?>" method="post" class="button-form fedora-inline-form">
      <input type="submit" value="Add a Map" class="bagit-create-bag">
      <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
    </form>
-->

<?php else: ?>

<p>There are no maps for the item.</p>

<form action="<?php echo uri(''); ?>" method="post" class="button-form neatline-inline-form-servers">
</form>

<form action="<?php echo uri('/neatline-maps/maps/create/selectserver'); ?>" method="post" class="button-form fedora-inline-form">
  <input type="submit" value="Add a Map" class="bagit-create-bag">
  <input type="hidden" name="item_id" value="<?php echo $item->id; ?>">
</form>

<?php endif; ?>

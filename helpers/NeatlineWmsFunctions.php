<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Helpers.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */


/**
 * Since item() is broken.
 *
 * @param Omeka_record $item The item to work on.
 * @param string $elementSet The element set.
 * @param string $elementName The element name.
 *
 * @return string $text The element text content.
 */
function nlwms_getItemMetadata($item, $elementSet, $elementName)
{

    // Get the database and set the default value.
    $_db = get_db();
    $text = '';

    // Get tables.
    $elementTable = $_db->getTable('Element');
    $elementTextTable = $_db->getTable('ElementText');
    $recordTypeTable = $_db->getTable('RecordType');

    // Fetch the element record for the field.
    $element = $elementTable->findByElementSetNameAndElementName(
        $elementSet,
        $elementName
    );

    // Get the record type for Item.
    $itemTypeId = $recordTypeTable->findIdFromName('Item');

    // Try to find a text.
    $existingTexts = $elementTextTable->fetchObjects(

        $elementTextTable->getSelect()->where(
                'record_id = ' . $item->id
                . ' AND record_type_id = ' . $itemTypeId
                . ' AND element_id = ' . $element->id
            )

    );

    if ($existingTexts != null) {
        $text = $existingTexts[0]->text;
    }

    return $text;

}

/**
 * Render the map partial.
 *
 * @param Omeka_record $item The parent item.
 *
 * @return string $text The element text content.
 */
function nlwms_renderMap($item)
{

    // Get table.
    $_db = get_db();
    $_wmsTable = $_db->getTable('NeatlineWms');

    // Try to get the service.
    $service = $_wmsTable->findByItem($item);

    // If a service exists, render it.
    if ($service) {

        // Create the renderer.
        $map = new GeoserverMap_WMS($service);

        if ($map->_isValid()) {

          return __v()->partial('show.php', array(
              'mapTitle' => $map->mapTitle,
              'wmsAddress' => $map->wmsAddress,
              'layers' => $map->layers,
              'boundingBox' => $map->boundingBox,
              'epsg' => $map->epsg
          ));

        }

    }

}

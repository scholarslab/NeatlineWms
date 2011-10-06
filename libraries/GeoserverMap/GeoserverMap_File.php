<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Concrete class for maps of Item type.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at http://www.apache.org/licenses/LICENSE-2.0 Unless required by
 * applicable law or agreed to in writing, software distributed under the
 * License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS
 * OF ANY KIND, either express or implied. See the License for the specific
 * language governing permissions and limitations under the License.
 *
 * @package     omeka
 * @subpackage  neatlinemaps
 * @author      Scholars' Lab <>
 * @author      Bethany Nowviskie <bethany@virginia.edu>
 * @author      Adam Soroka <ajs6f@virginia.edu>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2010 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 * @version     $Id$
 */
?>

<?php

class GeoserverMap_File extends GeoserverMap_Abstract
{

    /**
     * Get the service address the map.
     *
     * @return string $title The address.
     */
    public function _getWmsAddress() {

        $map = $this->map->getMap();
        $server = $map->getServer();

        return $server->url . '/' . $map->namespace . '/wms';

    }

    /**
     * Fetch the XML for the datastream capabilities.
     *
     * @return string $title The address.
     */
    public function _getCapabilitiesXml()
    {

        // Get the capabilities XML, scrub out namespace for xpath query.
        $capabilitiesURL = $this->wmsAddress . '?request=GetCapabilities';
        $client = new Zend_Http_Client($capabilitiesURL, array('timeout' => 30));
        return $client->request()->getBody();

    }

    /**
     * Fetch fields for the map.
     *
     * @return string $title The title.
     */
    public function _getMapTitle()
    {

        $fileName = explode('.', $this->map->getFile()->original_filename);
        return $fileName[0];

    }

    /**
     * Build the layers string for the OpenLayers JavaScript invocation.
     *
     * @return string $layers The constructed string.
     */
    public function _getLayers()
    {

        $map = $this->map->getMap();

        $fileName = explode('.', $this->map->getFile()->original_filename);
        return $map->namespace . ':' . $fileName[0];

    }

    /**
     * Calculate a bounding box based on the individual bounding boxes for each of the layers
     * that will show all layers at once. This is more difficult than just choosing the box for
     * the first layer, but it makes it possible to puts dozens of layers on a map without having
     * to worry about viewport chaos.
     *
     * @return array $boundngBox The constructed string, formatted according to the requirements
     * of the OpenLayers.Bounds constructor.
     */
    public function _getBoundingBox()
    {

        // Query for the layers.
        $capabilities = new SimpleXMLElement($this->capabilitiesXml);
        $capabilities->registerXPathNamespace('gis', 'http://www.opengis.net/wms');
        $layers = $capabilities->xpath('//gis:Layer[@queryable="1"]');

        $activeLayers = array();
        $fileName = explode('.', $this->map->getFile()->original_filename);

        // Query for names, filter out layers without an Omeka map file.
        foreach ($layers as $layer) {
            if ($layer->Title == $fileName[0]) {
                $activeLayers[] = $layer;
            }
        }

        $minxes = (float) $activeLayers[0]->BoundingBox->attributes()->minx;
        $minys = (float) $activeLayers[0]->BoundingBox->attributes()->miny;
        $maxxes = (float) $activeLayers[0]->BoundingBox->attributes()->maxx;
        $maxys = (float) $activeLayers[0]->BoundingBox->attributes()->maxy;

        // Check for reverse axis order.
        $espgNumber = explode(':', $this->epsg);
        if ($espgNumber[1] >= 4000 && $espgNumber[1] <= 5000) {
            $string = implode(',', array(
                $minys,
                $minxes,
                $maxys,
                $maxxes));
        }

        // If not between 4000 and 5000, do normal order.
        else {
            $string = implode(',', array(
                $minxes,
                $minys,
                $maxxes,
                $maxys));
        }

        return $string;

    }

    /**
     * Get the projection format.
     *
     * @return string The EPSG.
     */
    public function _getEPSG()
    {

        // Query for the layers.
        $capabilities = new SimpleXMLElement($this->capabilitiesXml);
        $layers = $capabilities->xpath('//*[local-name()="Layer"][@queryable=1]');

        $map = $this->map->getMap();
        $fileName = explode('.', $this->map->getFile()->original_filename);

        // Query for names, filter out layers without an Omeka map file.
        foreach ($layers as $layer) {
            if ($layer->Title == $fileName[0]) {
                $activeLayer = $layer;
            }
        }

        return $activeLayer->BoundingBox->attributes()->CRS;

    }

}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */

?>

# Neatline Maps

Neatline Maps allows users to connect items in an Omeka collection to web map services delivered by [Geoserver][geoserver], a powerful open-source geospatial server. Web map services can be linked with items in two ways:

  1. If the service already exists, the the WMS address and list of layers can be added directly to the item record in the standard Omeka administrative interface. Neatline Maps will then display the map in an Openlayers slippy map on all item views.

  2. If you have login access to a Geoserver instance and want to upload a _new_ georeferenced .tiff file, you can point the plugin to the Geoserver and upload the .tiff on an item as you would a regular file. Neatline Maps will detect the geoencoded file, create a new coverage store and layer on Geoserver, and link the item to the newly-created WMS by automatically populating the WMS address and layer fields.

Web map services created by way of Neatine Maps have plug-and-play
interoperability with exhibits created in the Neatline editor - if you
add a WMS to an Omeka item, and then activate the item on the map in a
Neatline exhibit, the WMS map will automatically render in the exhibit.

## Installation and Configuration

  1. Go to the [Neatline Maps download page][neatline-maps-download] and download the plugin.
  2. Once the file is finished downloading, uncompress the .zip file and place the "NeatlineMaps" directory in the plugins/ folder in your Omeka installation.
  3. Open a web browser, go to the Omeka administrative interface, and click on the "Settings" button at the top right of the screen.
  4. Click on the "Plugins" tab in the vertical column on the left and find the listing for the Neatline Maps plugin.
  5. Click the "Install" button.

Once the installation is finished, you'll see a new tab along the top of the administrative interface labeled "Neatline Maps."

[geoserver]: http://geoserver.org
[neatline-maps-download]: http://neatline.org/download

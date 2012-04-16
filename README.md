# Neatline Maps

Neatline Maps allows users to connect items in an Omeka collection to web map services delivered by [Geoserver][geoserver], a powerful open-source geospatial server. Web map services can be linked with items in two ways:

  1. If the service already exists, the the WMS address and list of layers can be added directly to the item record in the standard Omeka administrative interface. Neatline Maps will then display the map in an Openlayers slippy map on all item show views.

  2. If you have login access to a Geoserver instance and want to upload a _new_ georeferenced .tiff file, you can point the plugin to the Geoserver and upload the .tiff on an item as you would a regular file. Neatline Maps will detect the geoencoded file, create a new coverage store and layer on Geoserver, and link the item to the newly-created WMS by automatically populating the WMS address and layer fields.

[geoserver]: http://geoserver.org

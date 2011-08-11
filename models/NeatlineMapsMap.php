<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Table class for NeatlineMaps.
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

class NeatlineMapsMap extends Omeka_record
{

    public $server_id;
    public $item_id;
    public $name;
    public $namespace;

    /**
     * Get the map's parent server.
     *
     * @return Omeka_record The server object.
     */
    public function getServer()
    {

        return $this->getTable('NeatlineMapsServer')->find($this->server_id);

    }

    /**
     * Get the number of files associated with the map.
     *
     * @return integer The number of files.
     */
    public function getNumberOfFiles()
    {

        $files = count(
            $this->getTable('NeatlineMapsMapFile')->fetchObjects(
                $this->getTable('NeatlineMapsMapFile')->getSelect()->where('map_id = 1')
            )
        );

        return $files;

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

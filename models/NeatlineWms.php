<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * WMS row class.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NeatlineWms extends Omeka_record
{

    /**
     * Record attributes.
     */

    public $item_id;
    public $title;
    public $address;
    public $layers;


    /**
     * Set keys.
     *
     * @param Omeka_record $item The item record.
     *
     * @return void.
     */
    public function __construct($item = null)
    {

        parent::__construct();

        // If defined, set the item key.
        if (!is_null($item)) {
            $this->item_id = $item->id;
        }

    }

    /**
     * Get the parent item.
     *
     * @return Item The item.
     */
    public function getItem()
    {
        $_itemsTable = $this->getTable('Item');
        return $_itemsTable->find($this->item_id);
    }

}

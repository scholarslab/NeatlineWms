<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Table class for Neatline WMS.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NeatlineWmsTable extends Omeka_Db_Table
{

    /**
     * Fetch Neatlines for the main browse view.
     *
     * @param string $sortField The column to sort by.
     * @param string $sortDir 'a' or 'd' for ASC and DESC.
     * @param integer $page The page number.
     *
     * @return array of Omeka_record $neatlines The Neatlines.
     */
    public function getServicesForAdmin($field='added', $dir='d', $page=1)
    {

        $orderClause = nlwms_buildOrderClause($sortField, $sortDir);
        $select = $this->getSelect();

        if (isset($page)) {
            $select->limitPage($page, get_option('per_page_admin'));
        }

        if (isset($orderClause)) {
            $select->order($orderClause);
        }

        return $this->fetchObjects($select);

    }

    /**
     * Build array with current_page, per_page, and total_results.
     *
     * @param integer $page The page number.
     *
     * @return array $pagination The settings.
     */
    public function getPaginationSettings($page)
    {

        return array(
            'current_page' => $page,
            'per_page' => get_option('per_page_admin'),
            'total_results' => $this->count()
        );

    }

}

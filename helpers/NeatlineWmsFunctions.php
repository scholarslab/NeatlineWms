<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Helper functions.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

/**
 * Build order clause for SQL queries.
 *
 * @param string $sort_field The column to sort on.
 * @param string $sort_dir The direction to sort.
 *
 * @return string $order The sort parameter for the query.
 */
function nlwms_buildOrderClause($sort_field, $sort_dir)
{

    if (isset($sort_dir)) {
        $sort_dir = ($sort_dir == 'a') ? 'ASC' : 'DESC';
    }

    return ($sort_field != '') ?
        trim(implode(' ', array($sort_field, $sort_dir))) : '';

}

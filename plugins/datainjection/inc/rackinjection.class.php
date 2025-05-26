<?php

/**
 * -------------------------------------------------------------------------
 * DataInjection plugin for GLPI
 * -------------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of DataInjection.
 *
 * DataInjection is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * DataInjection is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DataInjection. If not, see <http://www.gnu.org/licenses/>.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2007-2022 by DataInjection plugin team.
 * @license   GPLv2 https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/pluginsGLPI/datainjection
 * -------------------------------------------------------------------------
 */

// Rack class
class PluginDatainjectionRackInjection extends Rack
                                      implements PluginDatainjectionInjectionInterface
{
    /**
     * Return the table used to store this object
     *
     * @return string table name
     */
    static function getTable($classname = null)
    {
        return "glpi_racks";
    }

	/**   
	* Indicates if this class represents a primary item type
	*
	* @return bool true if primary type, false otherwise
	*/   
	function isPrimaryType() {

		return true;
    }

	/**
     * Returns a list of item types this object is connected to (related objects)
     *
     * @return array array of connected item types (empty in this case)
     */
    function connectedTo() {

      return [];
    }

    /**
     * Define primary key field in the DB table
     *
     * @return string primary key field
     */
    static function getPrimaryKey()
    {
        return "id";
    }

    /**
     * Build the request parameters array to be used by the search engine
     *
     * @param $primary_type The object's itemtype to be injected
     *
     * @return array parameters request array
     */
    function getOptions($primary_type = '')
    {
        // Dynamically get the parent class name and fetch options for that class
		$parent_class = get_parent_class($this);
		$tab = Search::getOptions($parent_class);
        
        // Remove some options we don't want in injection
        $blacklist = PluginDatainjectionCommonInjectionLib::getBlacklistedOptions($parent_class);
        $notimportable = [];        
        // Add specific options for this itemtype
        // For example:
        //$tab[200]['name']        = __('Example field', 'datainjection');
        //$tab[200]['field']       = 'example_field';
        //$tab[200]['table']       = $this->getTable();
        //$tab[200]['datatype']    = 'text';
        //$tab[200]['displaytype'] = 'text';


		$options['ignore_fields'] = array_merge($blacklist, $notimportable);
		
        return PluginDatainjectionCommonInjectionLib::addToSearchOptions($tab, $options, $this);
    }

    /**
     * Standard method to add an object into GLPI
     *
     * @param $values array fields to update
     * @param $options array options used during creation
     *
     * @return array an array of IDs of newly created objects : for example array(Computer=>1, Networkport=>10)
     */
    function addOrUpdateObject($values = [], $options = [])
    {
        $lib = new PluginDatainjectionCommonInjectionLib($this, $values, $options);
        
        // Store the injection results
        $this->results = $lib->processAddOrUpdate();
        
        return $this->results;
    }
}
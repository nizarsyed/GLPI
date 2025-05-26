<?php

/**
 * ---------------------------------------------------------------------
 *
 * GLPI - Gestionnaire Libre de Parc Informatique
 *
 * http://glpi-project.org
 *
 * @copyright 2015-2023 Teclib' and contributors.
 * @copyright 2003-2014 by the INDEPNET Development Team.
 * @licence   https://www.gnu.org/licenses/gpl-3.0.html
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * ---------------------------------------------------------------------
 */// Define the OtherTable class
 
 
class plugin_fields_plugingenericobjectconfigitemlifourimports extends CommonDBTM {
    
    // Define the table name
    static $table = 'glpi_plugin_fields_plugingenericobjectconfigitemlifourimports';
    
    // Define the primary key column name
    static $primary = 'id';
    
    // Define the fields of the table
    public $fields = [
        'id' => 'integer',
		'items_id' => 'integer',
		'itemtype' => 'string',
		'plugin_fields_containers_id' => 'integer',
		'uinfield' => 'N/A',
		'lcnfield' => 'string',
		'alfield' => 'string',
		'descriptionfield' => 'string',
		'dilitemfield' => 'string',
		'quantityfield' => 'string',
		'modelfield' => 'string',
		'partnumberfield' => 'string',
		'serialnumberfield' => 'string',
		'softwarelicencefield' => 'string',
		'licencecategoryfield' => 'string',
		'endofvalidityfield' => 'string',
		'subsystemfield' => 'string',
		'propertyownerfield' => 'string',
		'manufacturerfield' => 'string',
		'classificationfield' => 'string',
		'acquisitionvaluefield' => 'string',
		'replacementvaluefield' => 'string',
		'productiondatefield' => 'string',
		'contractorcodefield' => 'string',
		'contractnumberfield' => 'string',
		'physicallocationfield' => 'string',
		'disposalstatusfield' => 'string',
		'disposalmethodfield' => 'string',
		'clearancefield' => 'string',
		'contractphasefield' => 'string',
		
		
		
		
        // Add more fields as needed
    ];

    // Constructor
    function __construct() {
        parent::__construct(self::$table);
    }

    // Define additional methods as needed to interact with the other table

    // For example, a method to retrieve data from the other table based on ID
    function getDataById($id) {
        $this->getFromDB($id);
        return $this->fields;
    }
	
	
    // Override the getTable method to return the desired table name
    public static function getTable($classname = null) {
        return self::$table;
    }

    // Add more methods as needed...
}

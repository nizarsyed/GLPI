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
 
 
class plugi_fields_plugingenericobjectconfigitemlifourimports extends CommonDBTM {
    
    // Define the table name
    static $table = 'glpi_plugin_fields_plugingenericobjectconfigitemlifourimports';
    
    // Define the primary key column name
    static $primary = 'id';
    
    // Define the fields of the table
    public $fields = [
        'id' => 'integer',
        'name' => 'string',
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

    // Add more methods as needed...
}

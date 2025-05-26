<?php

function fillArrayFromDatabase($idKeys) {
    $databaseName = 'glpidb';
    $tableName = 'glpi_plugin_fields_plugingenericobjectconfigitemlifourimports';
    $fieldName = 'uinfield';

    require_once 'CommonDBTM.php';

    $table = CommonDBTM::getTable();
    $tableField = CommonDBTM::getTableField($fieldName);

    $dbObject = new CommonDBTM();
    $dbObject->getFromDB($idKeys);

    $array = [];
    $array[$fieldName] = $dbObject->getField($fieldName);

    return $array;
}

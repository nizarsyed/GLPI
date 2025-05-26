<?php
error_log("✅ GLPI loaded custom_asset_report.php");

<?php
/**
 * Custom Asset Overview Report
 * File: plugins/reports/report/custom_asset_report.php
 */

$USEDBREPLICATE = 1;

$report = new PluginReportsAutoReport(
    __('Custom Asset Overview', 'reports'),
    [
        'title'           => __('Overview of multiple asset types', 'reports'),
        'default_filter'  => true,
        'allow_entities'  => true,
        'use_date_range'  => false
    ]
);

$report->displayHeader();

global $DB;
$entities_restrict = getEntitiesRestrictRequest("c", '', '', true);

// Retrieve Computers
$sql_computers = "
    SELECT 
        c.id,
        c.name,
        'Computer' AS asset_type,
        c.serial,
        l.name AS location,
        e.completename AS entity
    FROM glpi_computers c
    LEFT JOIN glpi_locations l ON c.locations_id = l.id
    LEFT JOIN glpi_entities e ON c.entities_id = e.id
    WHERE $entities_restrict
";

// Retrieve Network Equipment
$sql_network = "
    SELECT 
        n.id,
        n.name,
        'Network Equipment' AS asset_type,
        n.serial,
        l.name AS location,
        e.completename AS entity
    FROM glpi_networkequipments n
    LEFT JOIN glpi_locations l ON n.locations_id = l.id
    LEFT JOIN glpi_entities e ON n.entities_id = e.id
    WHERE " . getEntitiesRestrictRequest("n", '', '', true) . "
";

// Retrieve Printers
$sql_printers = "
    SELECT 
        p.id,
        p.name,
        'Printer' AS asset_type,
        p.serial,
        l.name AS location,
        e.completename AS entity
    FROM glpi_printers p
    LEFT JOIN glpi_locations l ON p.locations_id = l.id
    LEFT JOIN glpi_entities e ON p.entities_id = e.id
    WHERE " . getEntitiesRestrictRequest("p", '', '', true) . "
";

// Combine results
$combined_sql = "$sql_computers UNION $sql_network UNION $sql_printers ORDER BY asset_type, name";

$result = $DB->query($combined_sql);

// Output table
echo "<table class='tab_cadre_fixehov'>";
echo "<tr class='tab_bg_1'>";
echo "<th>" . __('Asset Type') . "</th>";
echo "<th>" . __('Name') . "</th>";
echo "<th>" . __('Serial') . "</th>";
echo "<th>" . __('Location') . "</th>";
echo "<th>" . __('Entity') . "</th>";
echo "</tr>";

if ($result && $DB->numrows($result) > 0) {
    while ($row = $DB->fetch_assoc($result)) {
        echo "<tr class='tab_bg_1'>";
        echo "<td>" . $row['asset_type'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['serial'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['entity'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr class='tab_bg_1'><td colspan='5'>" . __('No data found') . "</td></tr>";
}

echo "</table>";

$report->displayFooter();

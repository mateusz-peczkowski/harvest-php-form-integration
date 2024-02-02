<?php

require __DIR__ . '/../helpers.php';

use Carbon\Carbon;

//Check if POST date is set
if (!isset($_POST['date']) || !$_POST['date'])
    dd('Error: No \'date\' date');

//Check if POST date is valid
try {
    $date = Carbon::parse($_POST['date']);
} catch (Exception $e) {
    dd('Error: Invalid \'date\' format: ' . $_ENV['HARVEST_TIME_FORMAT']);
}

//Get entries from Harvest
$getEntriesFromResponse = callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '?from=' . $date->isoFormat($_ENV['HARVEST_TIME_FORMAT']) . '&to=' . $date->isoFormat($_ENV['HARVEST_TIME_FORMAT']));

//Delete entries from Harvest
if (count($getEntriesFromResponse->time_entries) > 0)
    foreach($getEntriesFromResponse->time_entries as $timeEntry) {
        callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '/' . $timeEntry->id, 'DELETE');
    }

//Return success message
echo 'Done';
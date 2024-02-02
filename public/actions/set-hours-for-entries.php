<?php

require __DIR__ . '/../helpers.php';

use Carbon\Carbon;

//Check if POST from date is set
if (!isset($_POST['from']) || !$_POST['from'])
    dd('Error: No \'from\' date');

//Check if POST to dates are set
if (!isset($_POST['to']) || !$_POST['to'])
    dd('Error: No \'to\' date');

//Check if POST from date is valid
try {
    $from = Carbon::parse($_POST['from']);
} catch (Exception $e) {
    dd('Error: Invalid \'from\' format: ' . $_ENV['HARVEST_TIME_FORMAT']);
}

//Check if POST to date is valid
try {
    $to = Carbon::parse($_POST['to']);
} catch (Exception $e) {
    dd('Error: Invalid \'to\' format: ' . $_ENV['HARVEST_TIME_FORMAT']);
}

//Get entries from Harvest
$getEntriesFromResponse = callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '?from=' . $from->isoFormat($_ENV['HARVEST_TIME_FORMAT']) . '&to=' . $from->isoFormat($_ENV['HARVEST_TIME_FORMAT']));
$getEntriesToResponse = callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '?from=' . $to->isoFormat($_ENV['HARVEST_TIME_FORMAT']) . '&to=' . $to->isoFormat($_ENV['HARVEST_TIME_FORMAT']));

if (!count($getEntriesFromResponse->time_entries) || !count($getEntriesToResponse->time_entries))
    dd('Error: No time entries found for specified dates');

foreach($getEntriesToResponse->time_entries as $timeEntryTo) {
    $hours = $timeEntryTo->hours;
    
    foreach($getEntriesFromResponse->time_entries as $timeEntryFrom) {
        if ($timeEntryTo->project->id == $timeEntryFrom->project->id && $timeEntryTo->task->id == $timeEntryFrom->task->id && $timeEntryTo->notes == $timeEntryFrom->notes)
            $hours = $timeEntryFrom->hours;
    }
    
    if ($hours != $timeEntryTo->hours)
        callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '/' . $timeEntryTo->id, 'PATCH', ['hours' => $hours]);
}

//Return success message
echo 'Done';
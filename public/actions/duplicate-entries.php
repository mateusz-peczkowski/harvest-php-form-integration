<?php

require __DIR__ . '/../helpers.php';

use Carbon\Carbon;

//Check if POST from date is set
if (!isset($_POST['from']) || !$_POST['from'])
    dd('Error: No \'from\' date');

//Check if POST to dates are set
if (!isset($_POST['to']) || !$_POST['to'])
    dd('Error: No \'to\' dates');

//Check if POST from date is valid
try {
    $from = Carbon::parse($_POST['from']);
} catch (Exception $e) {
    dd('Error: Invalid \'from\' format: ' . $_ENV['HARVEST_TIME_FORMAT']);
}

//Check if POST to dates are valid
$toDates = [];

foreach(explode(', ', $_POST['to']) as $date) {
    try {
        $toDates[] = Carbon::createFromFormat('d/m/Y', $date);
    } catch (Exception $e) {
        dd('Error: Invalid \'to\' format: ' . $_ENV['HARVEST_TIME_FORMAT']);
    }
}

$includeHours = isset($_POST['include_hours']) && $_POST['include_hours'] ? true : false;

//Get entries from Harvest
$getEntriesFromResponse = callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '?from=' . $from->isoFormat($_ENV['HARVEST_TIME_FORMAT']) . '&to=' . $from->isoFormat($_ENV['HARVEST_TIME_FORMAT']));

//Duplicate entries in Harvest for specified dates
foreach($toDates as $to) {
    foreach (array_reverse($getEntriesFromResponse->time_entries) as $timeEntry) {
        $data = [
            'project_id' => $timeEntry->project->id,
            'task_id'    => $timeEntry->task->id,
            'spent_date' => $to->isoFormat($_ENV['HARVEST_TIME_FORMAT']),
            'notes'      => $timeEntry->notes,
        ];
        
        if ($includeHours)
            $data['hours'] = $timeEntry->hours;
        
        $response = callApi($_ENV['HARVEST_TIME_ENTRIES_URL'], 'POST', $data);
        
        if ($response->is_running)
            callApi($_ENV['HARVEST_TIME_ENTRIES_URL'] . '/' . $response->id . '/stop', 'PATCH');
    }
}

//Return success message
echo 'Done';
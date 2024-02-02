<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

if (!function_exists('callApi')) {
    function callApi($endpoint, $method = 'GET', $data = NULL)
    {
        //Make curl call
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $_ENV['HARVEST_ACCESS_TOKEN'],
            'Harvest-Account-Id: ' . $_ENV['HARVEST_ACCOUNT_ID'],
            'User-Agent: PHP',
            'Content-Type: application/json',
        ]);
        
        if ($data)
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $output = json_decode($output);
        
        if (($httpcode !== 200 && $httpcode !== 201) || !$output || (isset($output->time_entries) && !is_array($output->time_entries))) {
            dd('Error: ' . $httpcode, $output);
            return;
        }
        
        return $output;
    }
}
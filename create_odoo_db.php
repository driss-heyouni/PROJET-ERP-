<?php
$url = "http://localhost:8069/jsonrpc";
$master_password = "admin"; // Standard default
$new_db = "ertp_mobilier";
$admin_password = "admin";

$data = json_encode([
    'jsonrpc' => '2.0',
    'method' => 'call',
    'params' => [
        'service' => 'db',
        'method' => 'create_db',
        'args' => [$master_password, $new_db, true, 'fr_FR', $admin_password],
    ]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

echo "Create database response: " . $response;

<?php
include "methods.php";

// Authentication data
$site = "";
$user = "";
$password = "";
$client_id = "";
$client_secret = "";
$callback_uri = "";

// Create new auth client
$client = new Auth2Eloqua($site, $user, $password, $client_id, $client_secret, $callback_uri);

// Get access token
echo "Acess Token<br>";
echo "access_token: " . $client->getAccessToken() . '<br>';
echo "expires_in: " . $client->getExpiration() . '<br>';
echo "Token type: " . $client->getTokenType() . '<br><br>';

// Get client info
$client->getClientInfo();
echo 'Display Name: ' . $client->getDisplayName() . '<br><br>';

// Refrescar el access token
$client->refreshAccessToken();
echo "access_token: " . $client->getAccessToken() . '<br>';
echo "expires_in: " . $client->getExpiration() . '<br>';
echo "Token type: " . $client->getTokenType() . '<br><br>';

echo "Bulk url: " . $client->getBulkUrl() . '<br><br>';

// Llamada para obtener los campos de contactos
echo $client->getBulk("contacts/fields") . '<br><br>';

// Llamada para obtener los grupos de correos
echo $client->getBulk("emailGroups");
<?php
include "ClientInfo.php";

class Auth2Eloqua
{
    private $site;
    private $user;
    private $password;
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $access_token;
    private $token_type;
    private $expires_in;
    private $refresh_token;
    private $url_access_token = "https://login.eloqua.com/auth/oauth2/token";
    private $url_client_info = "https://login.eloqua.com/id";
    private $url_contacts_fields = "https://secure.p03.eloqua.com/api/bulk/2.0/contacts/fields";
    private $client_info;

    public function __construct($site, $user, $password, $client_id, $client_secret, $redirect_uri)
    {
        $this->site = $site;
        $this->user = $user;
        $this->password = $password;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;

        $authorization_header = 'Basic ' . base64_encode($this->client_id . ':' . $this->client_secret);

        // Set request body
        $postdata = Array('grant_type' => 'password', 'scope' => 'full',
            'username' => $this->site . '\\' . $this->user, 'password' => $this->password);

        // Setup cURL
        $ch = curl_init($this->url_access_token);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authorization_header,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postdata)
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $response_array = (array)json_decode($response);
        $this->access_token = $response_array['access_token'];
        $this->token_type = $response_array['token_type'];
        $this->expires_in = $response_array['expires_in'];
        $this->refresh_token = $response_array['refresh_token'];
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    public function getExpiration()
    {
        return $this->expires_in;
    }

    public function getTokenType()
    {
        return $this->token_type;
    }

    // Not working yet
    public function refreshAccessToken()
    {
        $authorization_header = 'Basic ' . base64_encode($this->site . '\\' . $this->user) . ':' . $this->password;

        // Set request body
        $postdata = Array('grant_type' => 'refresh_token', 'scope' => 'full',
            'refresh_token' => $this->refresh_token, 'redirect_uri' => $this->redirect_uri);

        // Setup cURL
        $ch = curl_init($this->url_access_token);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authorization_header,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($postdata)
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        return $response;
    }

    // client info
    public function getClientInfo()
    {
        $authorization_header = $this->token_type . ' ' . $this->access_token;

        // Setup cURL
        $ch = curl_init($this->url_client_info);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authorization_header,
                'Content-Type: application/json'
            )
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        $this->client_info = new ClientInfo($response);
    }

    public function getDisplayName()
    {
        if (!isset($this->client_info)) {
            $this->getClientInfo();
        }
        return $this->client_info->getDisplayName();
    }
    
    public function getBaseUrl(){
        if (!isset($this->client_info)){
            $this->getClientInfo();
        }
        return $this->client_info->getBaseUrl();
    }

    public function getContactFields(){
        $authorization_header = $this->token_type . ' ' . $this->access_token;
        // Setup cURL
        $ch = curl_init($this->url_contacts_fields);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $authorization_header,
                'Accept: application/json'
            )
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        return $response;
    }
}

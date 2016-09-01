<?php

class ClientInfo
{
    private $site_id;
    private $site_name;
    private $user_id;
    private $username;
    private $display_name;
    private $first_name;
    private $last_name;
    private $email_address;
    private $url_base;
    private $soap_standard;
    private $soap_dataTransfer;
    private $soap_email;
    private $soap_externalAction;
    private $rest_standard;
    private $rest_bulk;

    function __construct($json)
    {
        // Main array from json
        $json_manage = (array)json_decode($json);

        // Site properties
        $site = (array)$json_manage['site'];
        $this->site_id = $site['id'];
        $this->site_name = $site['name'];

        // User properties
        $user = (array)$json_manage['user'];
        $this->user_id = $user['id'];
        $this->username = $user['username'];
        $this->display_name = $user['displayName'];
        $this->first_name = $user['firstName'];
        $this->last_name = $user['lastName'];
        $this->email_address = $user['emailAddress'];

        // URLs properties
        $urls = (array)$json_manage['urls'];
        $this->url_base = $urls['base'];
        $apis = (array)$urls['apis'];
        $soap = (array)$apis['soap'];
        $this->soap_standard = $soap['standard'];
        $this->soap_dataTransfer = $soap['dataTransfer'];
        $this->soap_email = $soap['email'];
        $this->soap_externalAction = $soap['externalAction'];
        $rest = (array)$apis['rest'];
        $this->rest_standard = $rest['standard'];
        $this->rest_bulk = $rest['bulk'];
    }

    function getSiteId()
    {
        return $this->site_id;
    }

    function getSiteName()
    {
        return $this->site_name;
    }

    function getUserId()
    {
        return $this->user_id;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getDisplayName()
    {
        return $this->display_name;
    }

    function getFirstName()
    {
        return $this->first_name;
    }

    function getLastName()
    {
        return $this->last_name;
    }

    function getEmail()
    {
        return $this->email_address;
    }

    function getUrlBase()
    {
        return $this->url_base;
    }

    function getSoapStandard()
    {
        return $this->soap_standard;
    }

    function getSoapDataTranster()
    {
        return $this->soap_dataTransfer;
    }

    function getSoapEmail()
    {
        return $this->soap_email;
    }

    function getSoapExternalAction()
    {
        return $this->soap_externalAction;
    }

    function getRestStandard()
    {
        return $this->rest_standard;
    }

    function getRestBulk()
    {
        return $this->rest_bulk;
    }
}
<?php

require_once "core/library/RestClient.php";
 
class LegalClient extends RestClient
{
    public function __construct()
    {
        parent::__construct("localhost", 80, "path_to_server.php");
    }
    public function getAllLegalClients()
    {
        return $this->doRequest(RestClient::GET);
    }
    public function getLegalClientsById($id)
    {
        return $this->doRequest(RestClient::GET, array("id" => $id));
    }
}
    
$clients = new LegalClient;

echo "<pre>";
print_r($clients->getAllLegalClients());
echo "</pre>";

echo "<pre>";
print_r($clients->getLegalClientsById(10));
echo "</pre>";



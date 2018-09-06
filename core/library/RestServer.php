<?php

abstract class RestServer
{
    
    public function get($params)
    {
    }
    public function post($params)
    {
    }
    public function put($params)
    {
    }
    public function del($params)
    {
    }
    
    public function streamToParams()
    {

        $ulaz = file_get_contents("php://input");
        $params = ($ulaz=="") ? array() : json_decode($ulaz, true);
        return $params;
    }
    
    public function handle()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        
        switch ($method) {
            case "get":
                $this->get($_GET);
                break;
            case "post":
                $this->post($this->streamToParams);
                break;
            case "put":
                $this->put($this->streamToParams);
                break;
            case "delete":
                $this->del($_GET);
                break;
        }
    }
}

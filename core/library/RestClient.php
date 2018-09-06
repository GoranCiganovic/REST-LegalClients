<?php
    
class RestClient
{
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DEL = "DEL";
        
    private $host;
    private $port;
    private $path;
            
    public function __construct($host, $port, $path)
    {
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
    }
        
    public function doRequest($method, $params = [])
    {
            
        $socket = fsockopen($this->host, $this->port);
        $getParams = "";
        $postParams = "";
        if (!empty($params)&&($method == RestClient::GET || $method == RestClient::DEL)) {
            foreach ($params as $k => $v) {
                $getParams.=$k."=".$v."&";
            }
            $getParams = "?".rtrim($getParams."&");
        } else {
            $postParams = !empty($params) ? json_encode($params) : "";
        }
            
        //Headers
        fputs($socket, "{$method} /{$this->path}{$getParams} HTTP/1.1\r\n");//Header Description
        fputs($socket, "Host: {$this->host}\r\n");
        //fputs($socket,"Content-type:application/x-www-form-urlencoded\r\n");
        if ($method==RestClient::POST || $method==RestClient::PUT) {
            fputs($socket, "Content-type:application/json\r\n");
            fputs($socket, "Content-length: ".strlen(postParams)."\r\n");
        }
            
        fputs($socket, "Connection: close\r\n");
        fputs($socket, "\r\n");
        if ($method==RestClient::POST || $method==RestClient::PUT) {
            fputs($socket, $postParams);
        }
        
        $output = "";
        $capture = false;
        while (!feof($socket)) {
            $line = fgets($socket);
            if ($line=="\r\n") {
                $capture = true;
            }
            if ($capture) {
                $output.=$line;
            }
        }
            
		$output = trim($output);
        if ($getParams == "") {
            //Remove Characters Before And After Square Brackets (Only More Than One Result)
            $output = $this->removeCharactersBeforeAndAfterSquareBrackets($output);
        }
        return json_decode($output);
    }

    public function removeCharactersBeforeAndAfterSquareBrackets($string)
    {
        $string = strstr($string, "[");
        $pos = strpos($string, ']');
        $string = substr($string, 0, $pos+1);
        return $string;
    }
}

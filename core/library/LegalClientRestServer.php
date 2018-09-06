<?php

class LegalClientRestServer extends RestServer
{

    public function get($params)
    {
        $db = Database::connectDB();
        if (isset($params['id'])) {
            $res = $db->conn->query("SELECT * FROM legal_clients WHERE id=".$params['id']);
            $output = $res->fetch(PDO::FETCH_OBJ);
        } else {
            $res = $db->conn->query("SELECT * FROM legal_clients");
            $res = $res->fetchAll(PDO::FETCH_OBJ);
            $output =array();
            foreach ($res as $actor) {
                $output[] = $actor;
            }
        }
        echo json_encode($output);
    }

    public function post($params)
    {
        if (isset($params['name'])) {
            $db = Database::connectDB();
            $brr = $db->conn->exec("INSERT INTO legal_clients values(null,'{$params['name']}')");
            echo '{"rc":'.$brr.'}';
        }
    }
}

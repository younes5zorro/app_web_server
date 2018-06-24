<?php
/**
 * Created by Younes Jaouiri .
 * Date: 25/04/2016
 * Time: 10:47
 */
getevents();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if($_GET["act"] =="get"){
            if (!empty($_GET["id"])) {
                $event_id = intval($_GET["id"]);
                get_events($event_id);
            } else {
                get_events();
            }

        }elseif($_GET["act"] =="add"){
            $vib = $_GET["vib"];
            $lat = $_GET["lat"];
            $long = $_GET["long"];
            $date = date('Y-m-d H:i:s', $_GET["date"]);
            add_event($vib,$lat,$long,$date);
        }
        break;
}


function getevents()
{
    global $dbh;
    $user = 'sql7243965';
    $pass = '94Ycxm7eGY';
    $dsn = 'mysql:host=sql7.freemysqlhosting.net;dbname=sql7243965';
    try {
        $dbh = new PDO($dsn, $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur ! : " . $e->getMessage());
    }
}

function get_events($event_id = 0)
{
    global $dbh;
    $sql = "SELECT * FROM data ";
    if ($event_id != 0) {
        $sql .= " WHERE id  =" . $event_id . " LIMIT 1";
    }
    $response = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($response);
}

function add_event($vib,$lat,$long,$date)
{
    global $dbh;

    $query = "INSERT INTO data SET vib={$vib} ,latitude={$lat},longitude ={$long},date ='{$date}'";
//        $sql = "insert into participation  values (".$mail.",".$pass.")";
    if ($dbh->exec($query)) {
        $response = array('status' => 1);
    } else {
        $response = array('status' => 0);
    }
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin:*');

    echo json_encode($response);
}

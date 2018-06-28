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
        }elseif($_GET["act"] =="map"){
            if (!empty($_GET["max"])) {
                $event_max = $_GET["max"];
                get_eventsMax($event_max);
            } else {
                get_eventsMax();
            }
        }elseif($_GET["act"] =="basta"){
            if (!empty($_GET["max"])) {
                $event_min = $_GET["max"];
                get_event_min($event_min);
            } else {
                get_event_min();
            }
        }
        break;
}


function getevents()
{
    global $dbh;
    $user = 'sql2245022';
    $pass = 'zA3*bC3%';
    $dsn = 'mysql:host=sql2.freemysqlhosting.net;dbname=sql2245022';
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

function get_eventsMax($event_id = 0)
{
    global $dbh;
    $sql = "SELECT * FROM data ";
    if ($event_id != 0) {
        $sql .= " WHERE vib > " . $event_id ;
    }else{
        $sql .= " order by  vib desc LIMIT 20" ;
    }
    $response = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($response);
}

function get_event_min($event_id = 0)
{
    global $dbh;
    $sql = "SELECT * FROM data ";
    if ($event_id != 0) {
        $sql .= " WHERE vib > " . $event_id ." and date > '2018-06-24'  LIMIT 2000";
    }else{
        $sql .= " order by  vib desc LIMIT 20" ;
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

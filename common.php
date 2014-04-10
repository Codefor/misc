<?php
#$mysqli = new mysqli('qdm-019.hichina.com', 'qdm0190315', '6444501990wang', 'qdm0190315_db');
$mysqli = new mysqli('localhost', 'stcuser', 'stcpass', 'stc');
$mysqli->query("set names utf8");

function new_account($username,$password){
    global $$mysqli;
    $username = trim($username);
    $password = trim($password);

    $sql = sprintf("INSERT INTO share_users VALUES(NULL,'%s','%s','%s',NULL)",
         $mysqli->real_escape_string($username),
         $mysqli->real_escape_string($password),
         date('Y-m-d H:i:s'));
    $mysqli->query($sql);
}

function delete_account($id){
    global $$mysqli;
    $id = (int)$id;
    $sql = "DELETE FROM share_users WHERE id = $id";
    $mysqli->query($sql);
}

function list_account(){
    global $mysqli;

    $info = array();
    $result = $mysqli->query("SELECT * FROM share_users");
    if($result){
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $info[] = $row;
        }
        $result->close();
    }

    return $info;
}

function check_user($username,$password){
    global $mysqli;
    $sql = sprintf("SELECT * FROM share_users WHERE username='%s' AND password = '%s'",
         $mysqli->real_escape_string($username),
         $mysqli->real_escape_string($password));
    $result = $mysqli->query($sql);
    return $result->num_rows > 0;
}



<?php
require_once '../includes/db.php';
function get_banks ($link, $country="NG"){
    $sql = "SELECT * FROM `banks` WHERE `country` = '$country'";
    $result = @mysqli_query($link, $sql);

    while ($rows = @mysqli_fetch_assoc($result)){
        $array[] = array(
        'id'       => $rows['id'],
        'bank' => $rows['name'],
        'type' => $rows['type'],
        'dateAdded'  => $rows['created_at'],
        'dateModified' => $rows['modified_at']
      );

    }
    //print_r($array);
    //exit();

    return $array;
}
header('Content-Type: application/json');
echo json_encode(get_banks($link));
?>
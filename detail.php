<?php 
require('function.php');

session_start();

$userId = null;

if(isset($_SESSION['idUser'])) {
    $user_name = $_SESSION['userName'];
    $userId = $_SESSION['idUser'];
}

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $iditem = $_GET['id'];

    $sql = "SELECT * FROM product WHERE id=$iditem";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row['sessionId'] = $userId;
        echo json_encode($row);
    }
}
?>
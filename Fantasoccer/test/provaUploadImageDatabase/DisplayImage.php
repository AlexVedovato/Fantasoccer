<?php
require_once ('database.php');
$conn = Database::getConnection();
$query = "Select image from prodotto where id=?";  
$stmt = $conn->prepare($query);
$id=$_GET['id'];
$stmt->execute(array($id));
$result=$stmt->fetch();
echo '<img src="data:image/jpeg;base64,'.$result['image'].'"/>';
?>
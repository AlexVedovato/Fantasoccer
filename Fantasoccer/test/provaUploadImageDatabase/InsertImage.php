<?php
require_once ('database.php');
$conn = Database::getConnection();
$arr_file_types = ['image/png', 'image/jpg', 'image/jpeg'];
if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
    header("Location: ./upload.html?error=Formato del file non accettabile");die;
}
$image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));

$query = "INSERT INTO prodotto (id,image) VALUES(NULL,?)";  
$stmt = $conn->prepare($query);
$stmt->execute(array($image));

$query = "Select id from prodotto where image=?";  
$stmt = $conn->prepare($query);
$stmt->execute(array($image));
$result=$stmt->fetch();
header("Location: ./DisplayImage.php?id=".$result['id']);
?>
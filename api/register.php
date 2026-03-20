<?php
include "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$passHash = password_hash($data["pass"], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (user, pass) VALUES (?, ?)");
$stmt->bind_param("ss", $data["user"], $passHash);
$stmt->execute();

echo json_encode(["status" => "ok"]);
?>
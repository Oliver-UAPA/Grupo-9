<?php
include "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE user = ?");
$stmt->bind_param("s", $data["user"]);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($data["pass"], $user["pass"])) {
    echo json_encode(["status" => "ok", "user" => $user["user"]]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
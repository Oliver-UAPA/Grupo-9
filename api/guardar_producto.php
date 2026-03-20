<?php
include "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("INSERT INTO productos (nombre, tipo, cantidad, costo, stock, usuario) VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssisss",
    $data["nombre"],
    $data["tipo"],
    $data["cantidad"],
    $data["costo"],
    $data["stock"],
    $data["usuario"]
);

$stmt->execute();

echo json_encode(["status" => "ok"]);
?>
<?php
// index.php
header("Content-Type: application/json");

echo json_encode([
    "success" => true,
    "message" => "Finance Tracker API is running!",
    "version" => "1.0.0",
    "endpoints" => [
        "GET /api/transactions/read.php?filter=all",
        "POST /api/transactions/create.php",
        "POST /api/transactions/update.php",
        "POST /api/transactions/delete.php",
        "GET /api/transactions/stats.php"
    ],
    "documentation" => "https://github.com/USERNAME/finance-tracker-backend"
]);
?>

<?php
// api/transactions/delete.php
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Validate data
if (!empty($data->id)) {
    try {
        $query = "DELETE FROM transactions WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $data->id);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Transaction deleted successfully."
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Transaction not found."
                ]);
            }
        } else {
            http_response_code(503);
            echo json_encode([
                "success" => false,
                "message" => "Unable to delete transaction."
            ]);
        }
    } catch (PDOException $e) {
        http_response_code(503);
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Transaction ID is required."
    ]);
}
?>
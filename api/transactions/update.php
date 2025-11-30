<?php
// api/transactions/update.php
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Validate data
if (
    !empty($data->id) &&
    !empty($data->type) &&
    !empty($data->amount) &&
    !empty($data->category) &&
    !empty($data->description) &&
    !empty($data->date)
) {
    try {
        $query = "UPDATE transactions 
                  SET type = :type,
                      amount = :amount,
                      category = :category,
                      description = :description,
                      date = :date
                  WHERE id = :id";

        $stmt = $db->prepare($query);

        // Bind values
        $stmt->bindParam(":id", $data->id);
        $stmt->bindParam(":type", $data->type);
        $stmt->bindParam(":amount", $data->amount);
        $stmt->bindParam(":category", $data->category);
        $stmt->bindParam(":description", $data->description);
        $stmt->bindParam(":date", $data->date);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "Transaction updated successfully."
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "success" => false,
                    "message" => "Transaction not found or no changes made."
                ]);
            }
        } else {
            http_response_code(503);
            echo json_encode([
                "success" => false,
                "message" => "Unable to update transaction."
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
        "message" => "Incomplete data. Please fill all fields."
    ]);
}
?>
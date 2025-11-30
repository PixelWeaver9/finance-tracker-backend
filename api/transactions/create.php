<?php
// api/transactions/create.php
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Validate data
if (
    !empty($data->type) &&
    !empty($data->amount) &&
    !empty($data->category) &&
    !empty($data->description) &&
    !empty($data->date)
) {
    try {
        $query = "INSERT INTO transactions 
                  SET type = :type,
                      amount = :amount,
                      category = :category,
                      description = :description,
                      date = :date";

        $stmt = $db->prepare($query);

        // Bind values
        $stmt->bindParam(":type", $data->type);
        $stmt->bindParam(":amount", $data->amount);
        $stmt->bindParam(":category", $data->category);
        $stmt->bindParam(":description", $data->description);
        $stmt->bindParam(":date", $data->date);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                "success" => true,
                "message" => "Transaction created successfully.",
                "id" => $db->lastInsertId()
            ]);
        } else {
            http_response_code(503);
            echo json_encode([
                "success" => false,
                "message" => "Unable to create transaction."
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
<?php
// api/transactions/read.php
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get filter parameter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

try {
    $query = "SELECT id, type, amount, category, description, date, created_at 
              FROM transactions ";
    
    if ($filter !== 'all') {
        $query .= "WHERE type = :type ";
    }
    
    $query .= "ORDER BY date DESC, created_at DESC";

    $stmt = $db->prepare($query);
    
    if ($filter !== 'all') {
        $stmt->bindParam(":type", $filter);
    }
    
    $stmt->execute();

    $transactions = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $transactions[] = [
            "id" => $row['id'],
            "type" => $row['type'],
            "amount" => floatval($row['amount']),
            "category" => $row['category'],
            "description" => $row['description'],
            "date" => $row['date'],
            "created_at" => $row['created_at']
        ];
    }

    http_response_code(200);
    echo json_encode([
        "success" => true,
        "data" => $transactions,
        "count" => count($transactions)
    ]);

} catch (PDOException $e) {
    http_response_code(503);
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>
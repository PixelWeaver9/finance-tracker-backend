<?php
// api/transactions/stats.php
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

try {
    // Get income total
    $query_income = "SELECT COALESCE(SUM(amount), 0) as total 
                     FROM transactions 
                     WHERE type = 'income'";
    $stmt_income = $db->prepare($query_income);
    $stmt_income->execute();
    $income_row = $stmt_income->fetch(PDO::FETCH_ASSOC);
    $income = floatval($income_row['total']);

    // Get expense total
    $query_expense = "SELECT COALESCE(SUM(amount), 0) as total 
                      FROM transactions 
                      WHERE type = 'expense'";
    $stmt_expense = $db->prepare($query_expense);
    $stmt_expense->execute();
    $expense_row = $stmt_expense->fetch(PDO::FETCH_ASSOC);
    $expense = floatval($expense_row['total']);

    // Calculate balance
    $balance = $income - $expense;

    // Get transaction count
    $query_count = "SELECT COUNT(*) as total FROM transactions";
    $stmt_count = $db->prepare($query_count);
    $stmt_count->execute();
    $count_row = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $transaction_count = intval($count_row['total']);

    http_response_code(200);
    echo json_encode([
        "success" => true,
        "data" => [
            "income" => $income,
            "expense" => $expense,
            "balance" => $balance,
            "transaction_count" => $transaction_count
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(503);
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>
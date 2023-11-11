<?php
include('connection.php');

if (isset($_POST['batch_id'])) {
    $batch_id = $_POST['batch_id'];

    // Check if any item in the batch has a status of "completed"
    $sql_check = "SELECT COUNT(*) AS completed_count FROM order_product WHERE batch = :batch_id AND status = 'completed'";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindParam(':batch_id', $batch_id);
    $stmt_check->execute();
    $completed_count = $stmt_check->fetchColumn();

    if ($completed_count > 0) {
        // Notify that the batch cannot be canceled because it is already completed
        $response = [
            'success' => false,
            'message' => "Cannot cancel, Order is already completed.",
        ];
    } else {
        // Update the status for all items in the batch to "cancelled"
        $sql_cancel = "UPDATE order_product SET status = 'cancelled' WHERE batch = :batch_id";
        $stmt_cancel = $conn->prepare($sql_cancel);
        $stmt_cancel->bindParam(':batch_id', $batch_id);
        $stmt_cancel->execute();

        $response = [
            'success' => true,
            'message' => "Batch successfully cancelled!",
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => "Batch ID not provided.",
    ];
}

echo json_encode($response);
?>


<?php
try {
    $data = include('connection.php');

    $table_name = $show_table;

    $stmt = $conn->prepare("SELECT * FROM $table_name ORDER BY created_at DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return $stmt->fetchAll();
} catch (PDOException $e) {
    // Handle the exception, e.g., log the error or return an empty array
    echo "Error: " . $e->getMessage();
    return array(); // Return an empty array to indicate an error occurred.
}


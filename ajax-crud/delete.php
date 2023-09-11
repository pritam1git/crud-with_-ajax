<?php 

include_once 'db.php';
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    $idToDelete = $_POST['id'];

    // Perform the delete operation (you should add proper SQL injection prevention here)
    $sql = "DELETE FROM jaxcr WHERE id = $idToDelete";

    if ($conn->query($sql) === TRUE) {
        $response = ['success' => true, 'message' => 'Record deleted successfully'];
    } else {
        $response = ['success' => false, 'message' => 'Error deleting record: ' . $conn->error];
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$conn->close();

?>
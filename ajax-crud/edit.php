<?php
include_once 'db.php';
$action = isset($_POST['action']) ? $_POST['action'] : '';
if ($action === 'edit') {
    $edit_id = isset($_POST['editId']) ? $_POST['editId'] : null; 
    if ($edit_id) {
        $sql = "SELECT * FROM jaxcr WHERE id = '$edit_id' ";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $data = mysqli_fetch_assoc($res); // Fetch user data as an associative array
            header('Content-Type: application/json');
            echo json_encode($data); // Send the user data as a JSON response
            exit(); // Terminate the script
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "No 'edit_id' parameter provided for editing.";
    }
}

$conn->close();
?>

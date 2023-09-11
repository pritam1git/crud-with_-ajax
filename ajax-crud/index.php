<?php
include_once 'db.php';
$id = '';
$hobbies_ar = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //echo "<pre>";print_r($_POST);die;
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Check if hobbies are set and convert them to a comma-separated string
    $hobbies = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';

    $image = 'image';

    if ($_SERVER['REQUEST_METHOD']==='POST') {
        $editId = isset($_POST['update_id']) ? $_POST['update_id'] : null;
        // Rest of your code for processing the form data...

        if (!empty($editId)) {

            // You're editing an existing record, update the record with $editId
            $sql = "UPDATE jaxcr SET name='" . $firstname . "', lastname='" . $lastname . "', email='" . $email . "', phone='" . $phone . "', gender='" . $gender . "', hobbies='" . $hobbies . "', image='" . $image . "' WHERE id=" . $editId;
        } else {
            // You're adding a new record
            $sql = "INSERT INTO jaxcr (name, lastname, email, phone, gender, hobbies, image) 
                    VALUES ('$firstname', '$lastname', '$email', '$phone', '$gender', '$hobbies', '$image')";
        }
        if ($conn->query($sql) === TRUE) {
            $sql = "SELECT * FROM jaxcr";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $data = array();

                // Loop through the result set and fetch data into an array
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }

                // Set the appropriate content type and output the JSON data
                header('Content-Type: application/json');
                echo json_encode($data);
                exit; // Stop further execution
            } else {
                echo "No records found";
            }
        }
        die;
    }
}


// Include your database connection script

if (isset($_GET['action'])) {
    // Assuming you want to retrieve all data from the 'jaxcr' table
    $sql = "SELECT * FROM jaxcr";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();

        // Loop through the result set and fetch data into an array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Set the appropriate content type and output the JSON data
        header('Content-Type: application/json');
        echo json_encode($data);

        exit; // Stop further execution
    } else {

        echo "No records found";
    }
} else {
    // echo "Invalid request"; // Handle the case where 'save' is not set
}

$conn->close(); // Close the database connection

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            margin: 4rem;
        }

        #formContainer {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input,
        textarea {
            width: 200px;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-transform: uppercase;
        }

        button {
            margin: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 70%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        a.blue {
            background-color: #008CBA;
            border-radius: 10px;
            border: none;
            color: white;
            padding: 8px 21px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        a.red {
            background-color: #f44336;
            border-radius: 10px;
            border: none;
            color: white;
            padding: 8px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        a.green {
            background-color: #fff;
            border-radius: 10px;
            color: #000 !important;
            border: none;
            border: 2px solid #4CAF50;
            color: white;
            padding: 8px 21px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        img {
            width: 150px;
            height: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-5 mt-3 border mb-5 bg-light rounded opacity-100 ">
                <form action="" method="POST" enctype="multipart/form-data" id="insert-form">
                    <input type="hidden" id="update_id" name="update_id" value="">

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">FirstName:</label>
                        <input type="text" class="form-control" id="firstname" placeholder="Enter FirstName" name="firstname" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">LastName:</label>
                        <input type="text" class="form-control" id="lastname" placeholder="Enter LastName" name="lastname" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Phone:</label>
                        <input type="number" class="form-control" id="phone" placeholder="Enter password" name="phone" required>
                    </div>
                    <div class="col-6 form-check  mt-3">
                        <label for="email" class="form-label">RadioButton:</label><br>
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="male" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            male
                        </label>
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                        <label class="form-check-label" for="exampleRadios2">
                            female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="others">
                        <label class="form-check-label" for="exampleRadios3">
                            others
                        </label>
                    </div>
                    <div class="form-check mb-3 mt-3">
                        <label for="email" class="form-label">CheckBox:</label><br>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="hobbies" name="hobbies[]" value="cricket" checked>
                            <label class="form-check-label" for="check1">cricket</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="hobbies" name="hobbies[]" value="football">
                            <label class="form-check-label" for="check2">football</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="hobbies" name="hobbies[]" value="Taken 3">
                            <label class="form-check-label">Taken 3</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-4">Submit</button>
                </form>
            </div>
            <div class="col-5">

                <h2>Table Data</h2>
                <a class="green" href="index.php">Add New Item</a>
                <table id="myTable" class="display">
                    <tr id="dataTable">
                </table>
            </div>
        </div>
    </div>

    <script href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="./index.js"></script>


</body>

</html>
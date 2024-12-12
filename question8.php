<?php
// Connect to the database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "webdev_lab 5b"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $matric = isset($_POST['matric']) ? $_POST['matric'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $access_level = isset($_POST['access_level']) ? $_POST['access_level'] : null;

    if ($matric && $name && $access_level) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (matric, name, access_level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $matric, $name, $access_level);

        if ($stmt->execute()) {
            $message = "New record created successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Please fill all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }
        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-container label {
            font-weight: bold;
            text-align: left;
            color: #555;
        }
        .form-container input,
        .form-container select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button[type="submit"] {
            background-color: #6ab60b;
            color: white;
        }
        .form-container button[type="reset"] {
            background-color: #6c757d;
            color: white;
        }
        .message {
            margin-top: 15px;
            color: green;
            font-weight: bold;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update User</h2>
        <?php if (!empty($message)) { 
            $messageClass = strpos($message, 'Error') === false ? "message" : "message error";
            echo "<p class='$messageClass'>$message</p>"; 
        } ?>
        <form method="post" action="">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="access_level">Access Level:</label>
            <select id="access_level" name="access_level" required>
                <option value="Lecturer">Lecturer</option>
                <option value="Student">Student</option>
            </select>

            <button type="submit">Update</button>
            <button type="reset">Cancel</button>
        </form>
    </div>
</body>
</html>

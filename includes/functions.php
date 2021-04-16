<?php
require_once("includes/connection.php");

$_SESSION["button"] = "add";

$errors = [];
$success = [];

//Adding a student
if (isset($_POST['add'])) {
    if (($_POST["name"] && $_POST["email"] && $_POST["address"] && $_POST["phone"]) != "") {
        $name = $conn->real_escape_string($_POST["name"]);
        $email = $conn->real_escape_string($_POST["email"]);
        $address = $conn->real_escape_string($_POST["address"]);
        $phone = $conn->real_escape_string($_POST["phone"]);

        if (!preg_match("/^[A-Za-z0-9._%+-]+@vit.edu$/ix", $email)) {
            $error = "Enter a valid VIT.EDU email!";
            array_push($errors, $error);
        }
        if (!preg_match("/^[6-9]\d{9}$/", $phone)) {
            $error = "Enter a valid mobile number!";
            array_push($errors, $error);
        }

        if (empty($errors)) {
            $result = $conn->query("SELECT * FROM pc_students WHERE student_email = '$email'");

            if ($result->num_rows > 0) {
                $error = "You have already submitted feedback using $email!";
                array_push($errors, $error);
            } else {
                $sql = "INSERT INTO pc_students (student_name, student_email, student_address, student_phone) VALUES ('$name', '$email', '$address', '$phone')";

                if ($conn->query($sql)) {
                    $msg = "Student record <strong>added</strong> successfully!";
                    array_push($success, $msg);
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } else {
        $error = "Fields cannot be empty!";
        array_push($errors, $error);
    }
}

//Updating a student

if (isset($_GET['update_id'])) {
    $_SESSION["update_id"] = $_GET['update_id'];
    $result = $conn->query("SELECT * FROM pc_students WHERE student_id = '" . $_SESSION["update_id"] . "'");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION["name"] =  $row["student_name"];
            $_SESSION["email"] =  $row["student_email"];
            $_SESSION["address"] =  $row["student_address"];
            $_SESSION["phone"] =  $row["student_phone"];

            $_SESSION["button"] = "update";
        }
    } else {
        $_SESSION["button"] = "add";
    }
} else {
    $_SESSION["button"] = "add";
}

if (isset($_POST['update'])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $address = $conn->real_escape_string($_POST["address"]);
    $phone = $conn->real_escape_string($_POST["phone"]);

    $sql = "UPDATE pc_students SET student_name='$name', student_email='$email', student_address='$address', student_phone='$phone' WHERE student_id='" . $_SESSION["update_id"] . "'";

    if ($conn->query($sql)) {
        $msg = "Student record <strong>updated</strong> successfully!";
        array_push($success, $msg);
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


//Delete a student
if (isset($_GET['delete_id'])) {
    $_SESSION["delete_id"] = $_GET['delete_id'];

    $sql = "DELETE FROM pc_students WHERE student_id='" . $_SESSION["delete_id"] . "'";

    if ($conn->query($sql)) {
        $msg = "Student record <strong>deleted</strong> successfully!";
        array_push($success, $msg);
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

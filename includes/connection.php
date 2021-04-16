<?php

$conn = new mysqli("localhost", "root", "", "php_crud");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

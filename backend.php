<?php
require 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// 1. READ: Data fetch karna
if ($action == 'read') {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

// 2. CREATE: Naya student add karna (Enrollment Date ke sath)
if ($action == 'create') {
    $roll = $_POST['roll_number'];
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $enroll_date = $_POST['enrollment_date'];

    $stmt = $conn->prepare("INSERT INTO students (roll_number, full_name, email, course, enrollment_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $roll, $name, $email, $course, $enroll_date);
    if($stmt->execute()) echo "Success";
}

// 3. DELETE: Student remove karna
if ($action == 'delete') {
    $id = $_POST['id'];
    $conn->query("DELETE FROM students WHERE id = $id");
    echo "Deleted";
}

// 4. UPDATE: Student edit karna (Enrollment Date ke sath)
if ($action == 'update') {
    $id = $_POST['id'];
    $roll = $_POST['roll_number'];
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $enroll_date = $_POST['enrollment_date'];

    $stmt = $conn->prepare("UPDATE students SET roll_number=?, full_name=?, email=?, course=?, enrollment_date=? WHERE id=?");
    $stmt->bind_param("sssssi", $roll, $name, $email, $course, $enroll_date, $id);
    if($stmt->execute()) echo "Updated";
}
?>
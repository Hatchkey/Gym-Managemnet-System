<?php
// include('includes/config.php');

// if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
//     $workoutId = $_GET['id'];

//     $checkQuery = "SELECT * FROM members WHERE id = $workoutId";
//     $checkResult = $conn->query($checkQuery);

//     if ($checkResult->num_rows > 0) {
//         $deleteQuery = "DELETE FROM members WHERE id = $workoutId";

//         if ($conn->query($deleteQuery) === TRUE) {
//             header("Location: manage_members.php");
//             exit();
//         } else {
//             echo "Error deleting record: " . $conn->error;
//         }
//     } else {
//         header("Location: manage_members.php");
//         exit();
//     }
// } else {
//     header("Location: manage_members.php");
//     exit();
// }

// $conn->close();

include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $workoutId = $_GET['id'];
    $deleteMemberQuery = "DELETE FROM workout_program WHERE id = $workoutId";
    if ($conn->query($deleteMemberQuery) === TRUE) {
        header("Location: manage_workout.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: manage_workout.php");

    exit();
}

$conn->close();

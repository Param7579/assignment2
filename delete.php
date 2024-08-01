<?php
// delete.php
require_once "config.php";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

    $sql = "DELETE FROM bookings WHERE id = ?";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = $id;

        if($stmt->execute()){
            header("location: booking.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    $stmt->close();
} else {
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id = trim($_GET["id"]);
    } else {
        header("location: error.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h2>Delete Booking</h2>
    <p>Are you sure you want to delete this booking record?</p>
    <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <button type="submit">Yes</button>
            <a href="booking.php">No</a>
        </p>
    </form>
</body>
</html>

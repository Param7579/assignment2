<?php
// read.php
require_once "config.php";

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = trim($_GET["id"]);

    $sql = "SELECT * FROM bookings WHERE id = ?";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = $id;

        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $pickup_location = $row["pickup_location"];
                $delivery_location = $row["delivery_location"];
                $cargo_type = $row["cargo_type"];
                $pickup_date = $row["pickup_date"];
                $delivery_date = $row["delivery_date"];
                $cargo_weight = $row["cargo_weight"];
                $cargo_dimensions = $row["cargo_dimensions"];
                $special_instructions = $row["special_instructions"];
                $customer_name = $row["customer_name"];
                $customer_email = $row["customer_email"];
                $customer_phone = $row["customer_phone"];
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    $stmt->close();
    $conn->close();
} else {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1>View Booking</h1>
    <p>
        <label>Pickup Location: </label><?php echo $pickup_location; ?>
    </p>
    <p>
        <label>Delivery Location: </label><?php echo $delivery_location; ?>
    </p>
    <p>
        <label>Cargo Type: </label><?php echo $cargo_type; ?>
    </p>
    <p>
        <label>Pickup Date: </label><?php echo $pickup_date; ?>
    </p>
    <p>
        <label>Delivery Date: </label><?php echo $delivery_date; ?>
    </p>
    <p>
        <label>Weight: </label><?php echo $cargo_weight; ?>
    </p>
    <p>
        <label>Dimensions: </label><?php echo $cargo_dimensions; ?>
    </p>
    <p>
        <label>Special Instructions: </label><?php echo $special_instructions; ?>
    </p>
    <p>
        <label>Customer Name: </label><?php echo $customer_name; ?>
    </p>
    <p>
        <label>Customer Email: </label><?php echo $customer_email; ?>
    </p>
    <p>
        <label>Customer Phone: </label><?php echo $customer_phone; ?>
    </p>
    <p>
        <a href="booking.php">Back to list</a>
    </p>
</body>
</html>

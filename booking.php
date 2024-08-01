<?php
// booking.php
require_once "config.php";

$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Records</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1>Booking Records</h1>
    <a href="create.php">Create New Booking</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pickup Location</th>
            <th>Delivery Location</th>
            <th>Cargo Type</th>
            <th>Pickup Date</th>
            <th>Delivery Date</th>
            <th>Weight</th>
            <th>Dimensions</th>
            <th>Special Instructions</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['pickup_location']; ?></td>
            <td><?php echo $row['delivery_location']; ?></td>
            <td><?php echo $row['cargo_type']; ?></td>
            <td><?php echo $row['pickup_date']; ?></td>
            <td><?php echo $row['delivery_date']; ?></td>
            <td><?php echo $row['cargo_weight']; ?></td>
            <td><?php echo $row['cargo_dimensions']; ?></td>
            <td><?php echo $row['special_instructions']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['customer_email']; ?></td>
            <td><?php echo $row['customer_phone']; ?></td>
            <td>
                <a href="read.php?id=<?php echo $row['id']; ?>">Read</a>
                <a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// create.php
require_once "config.php";

$pickup_location = $delivery_location = $cargo_type = $pickup_date = $delivery_date = $cargo_weight = $cargo_dimensions = $special_instructions = $customer_name = $customer_email = $customer_phone = "";
$pickup_location_err = $delivery_location_err = $cargo_type_err = $pickup_date_err = $delivery_date_err = $cargo_weight_err = $cargo_dimensions_err = $customer_name_err = $customer_email_err = $customer_phone_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate and assign input values to variables
    $pickup_location = trim($_POST["pickup-location"]);
    $delivery_location = trim($_POST["delivery-location"]);
    $cargo_type = trim($_POST["cargo-type"]);
    $pickup_date = trim($_POST["pickup-date"]);
    $delivery_date = trim($_POST["delivery-date"]);
    $cargo_weight = trim($_POST["cargo-weight"]);
    $cargo_dimensions = trim($_POST["cargo-dimensions"]);
    $special_instructions = trim($_POST["special-instructions"]);
    $customer_name = trim($_POST["customer-name"]);
    $customer_email = trim($_POST["customer-email"]);
    $customer_phone = trim($_POST["customer-phone"]);

    // Check for errors
    if(empty($pickup_location)) { $pickup_location_err = "Please enter a pickup location."; }
    if(empty($delivery_location)) { $delivery_location_err = "Please enter a delivery location."; }
    if(empty($cargo_type)) { $cargo_type_err = "Please select a cargo type."; }
    if(empty($pickup_date)) { $pickup_date_err = "Please enter a pickup date."; }
    if(empty($delivery_date)) { $delivery_date_err = "Please enter a delivery date."; }
    if(empty($cargo_weight) || $cargo_weight <= 0) { $cargo_weight_err = "Please enter a valid cargo weight."; }
    if(empty($cargo_dimensions)) { $cargo_dimensions_err = "Please enter cargo dimensions."; }
    if(empty($customer_name)) { $customer_name_err = "Please enter a customer name."; }
    if(empty($customer_email) || !filter_var($customer_email, FILTER_VALIDATE_EMAIL)) { $customer_email_err = "Please enter a valid email."; }
    if(empty($customer_phone) || !preg_match('/^\d{10}$/', $customer_phone)) { $customer_phone_err = "Please enter a valid 10-digit phone number."; }

    // Check input errors before inserting in database
    if(empty($pickup_location_err) && empty($delivery_location_err) && empty($cargo_type_err) && empty($pickup_date_err) && empty($delivery_date_err) && empty($cargo_weight_err) && empty($cargo_dimensions_err) && empty($customer_name_err) && empty($customer_email_err) && empty($customer_phone_err)){
        $sql = "INSERT INTO bookings (pickup_location, delivery_location, cargo_type, pickup_date, delivery_date, cargo_weight, cargo_dimensions, special_instructions, customer_name, customer_email, customer_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("sssssiissss", $pickup_location, $delivery_location, $cargo_type, $pickup_date, $delivery_date, $cargo_weight, $cargo_dimensions, $special_instructions, $customer_name, $customer_email, $customer_phone);

            if($stmt->execute()){
                header("location: booking.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h2>Create Booking</h2>
    <p>Please fill this form to create a booking record.</p>
    <form action="create.php" method="post">
        <label for="pickup-location">Pickup Location:</label>
        <input type="text" id="pickup-location" name="pickup-location" value="<?php echo $pickup_location; ?>" required>
        <span><?php echo $pickup_location_err; ?></span>

        <label for="delivery-location">Delivery Location:</label>
        <input type="text" id="delivery-location" name="delivery-location" value="<?php echo $delivery_location; ?>" required>
        <span><?php echo $delivery_location_err; ?></span>

        <label for="cargo-type">Cargo Type:</label>
        <select id="cargo-type" name="cargo-type" required>
            <option value="general-freight">General Freight</option>
            <option value="hazardous-materials">Hazardous Materials</option>
            <option value="perishable-goods">Perishable Goods</option>
            <option value="oversized-items">Oversized Items</option>
        </select>
        <span><?php echo $cargo_type_err; ?></span>

        <label for="pickup-date">Pickup Date:</label>
        <input type="date" id="pickup-date" name="pickup-date" value="<?php echo $pickup_date; ?>" required>
        <span><?php echo $pickup_date_err; ?></span>

        <label for="delivery-date">Delivery Date:</label>
        <input type="date" id="delivery-date" name="delivery-date" value="<?php echo $delivery_date; ?>" required>
        <span><?php echo $delivery_date_err; ?></span>

        <label for="cargo-weight">Cargo Weight (in kg):</label>
        <input type="number" id="cargo-weight" name="cargo-weight" min="0" value="<?php echo $cargo_weight; ?>" required>
        <span><?php echo $cargo_weight_err; ?></span>

        <label for="cargo-dimensions">Cargo Dimensions (L x W x H in cm):</label>
        <input type="text" id="cargo-dimensions" name="cargo-dimensions" pattern="\d+x\d+x\d+" placeholder="e.g. 100x50x30" value="<?php echo $cargo_dimensions; ?>" required>
        <span><?php echo $cargo_dimensions_err; ?></span>

        <label for="special-instructions">Special Handling Instructions:</label>
        <textarea id="special-instructions" name="special-instructions" rows="4" cols="50"><?php echo $special_instructions; ?></textarea>

        <label for="customer-name">Customer Name:</label>
        <input type="text" id="customer-name" name="customer-name" value="<?php echo $customer_name; ?>" required>
        <span><?php echo $customer_name_err; ?></span>

        <label for="customer-email">Customer Email:</label>
        <input type="email" id="customer-email" name="customer-email" value="<?php echo $customer_email; ?>" required>
        <span><?php echo $customer_email_err; ?></span>

        <label for="customer-phone">Customer Phone:</label>
        <input type="tel" id="customer-phone" name="customer-phone" pattern="[0-9]{10}" placeholder="e.g. 1234567890" value="<?php echo $customer_phone; ?>" required>
        <span><?php echo $customer_phone_err; ?></span>

        <button type="submit">Book Now</button>
        <button type="reset">Reset</button>
    </form>
</body>
</html>

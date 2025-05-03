<?php

include '../include/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {

    $order_update_id = $_POST['order_id'];
    $update_payment = null; // Initialize with a default value

    // Check if `update_payment` is provided in the form
    if (!empty($_POST['update_payment'])) {
        $update_payment = $_POST['update_payment'];
    }

    if (!empty($_POST['shipment_date'])) {
        $shipment_date = $_POST['shipment_date'];
        if (!empty($update_payment)) {
            mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment', shipment_date = '$shipment_date' WHERE id = '$order_update_id'") or die('Query failed');
        } else {
            mysqli_query($conn, "UPDATE `orders` SET shipment_date = '$shipment_date' WHERE id = '$order_update_id'") or die('Query failed');
        }
    } elseif (!empty($_POST['received_date'])) {
        $received_date = $_POST['received_date'];
        if (!empty($update_payment)) {
            mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment', received_date = '$received_date' WHERE id = '$order_update_id'") or die('Query failed');
        } else {
            mysqli_query($conn, "UPDATE `orders` SET received_date = '$received_date' WHERE id = '$order_update_id'") or die('Query failed');
        }
    } elseif (!empty($_POST['payment_date'])) {
        $payment_date = $_POST['payment_date'];
        if (!empty($update_payment)) {
            mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment', payment_date = '$payment_date' WHERE id = '$order_update_id'") or die('Query failed');
        } else {
            mysqli_query($conn, "UPDATE `orders` SET payment_date = '$payment_date' WHERE id = '$order_update_id'") or die('Query failed');
        }
    } elseif (!empty($update_payment)) {
        mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('Query failed');
    }

    echo 'Order Status Updated Successfully!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('Query failed');
    header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="orders">

        <h1 class="title">Orders</h1>
        <div class="box-container">
            <?php

            if (isset($_GET["st"])) {
                $status = $_GET["st"];
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status='$status'") or die('Query failed');
            } else {
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('Query failed');
            }

            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>

                    <div class="box">
                        <p> User ID: <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                        <p> Placed On: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                        <p> Name: <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <p> Number: <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> Email: <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> Address: <span><?php echo $fetch_orders['address']; ?></span> </p>
                        <p> Product Name: <span><?php echo $fetch_orders['product_name']; ?></span> </p>
                        <p> Total Quantity: <span><?php echo $fetch_orders['total_quantity']; ?> Item</span> </p>
                        <p> Total Price: <span><?php echo number_format($fetch_orders['total_price']); ?> THB</span> </p>
                        <p> Payment: <span><?php echo $fetch_orders['payment']; ?></span> </p>
                        <p> Payment Date: <span><?php echo $fetch_orders['payment_date']; ?></span> </p>
                        <p> Shipment Date: <span><?php echo $fetch_orders['shipment_date']; ?></span> </p>
                        <p> Received Date: <span><?php echo $fetch_orders['received_date']; ?></span> </p>
                        <p> Payment Status:
                            <span style="color:<?php echo $fetch_orders['payment_status'] == 'wadmin' ? 'red' : 'green'; ?>;">
                                <?php
                                switch ($fetch_orders['payment_status']) {
                                    case 'wadmin':
                                        echo 'Waiting For Admin To Check';
                                        break;
                                    case 'wdelivery':
                                        echo 'The Product Is Being Delivered.';
                                        break;
                                    case 'finish':
                                        echo 'The Product Has Been Shipped.';
                                        break;
                                    case 'rproduct':
                                        echo 'Return';
                                        break;
                                    case 'rpd':
                                        echo 'Product Returned Successfully';
                                        break;
                                }
                                ?>
                            </span>
                        </p>

                        <form action="" method="post">
                            <div class="form-group mb-3">
                                <label for="">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Shipment Date</label>
                                <input type="date" name="shipment_date" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Received Date</label>
                                <input type="date" name="received_date" class="form-control" />
                            </div>
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">

                            <select name="update_payment">
                                <option value="" selected disabled>
                                    <?php
                                    switch ($fetch_orders['payment_status']) {
                                        case 'wadmin':
                                            echo 'Waiting For Admin To Check';
                                            break;
                                        case 'wdelivery':
                                            echo 'The Product Is Being Delivered.';
                                            break;
                                        case 'finish':
                                            echo 'The Product Has Been Shipped.';
                                            break;
                                        case 'rproduct':
                                            echo 'Return';
                                            break;
                                        case 'rpd':
                                            echo 'Product Returned Successfully';
                                            break;
                                    }
                                    ?>
                                </option>
                                <option value="wadmin">Waiting For Admin To Check</option>
                                <option value="wdelivery">The Product Is Being Delivered</option>
                                <option value="finish">The Product Has Been Shipped</option>
                                <option value="rproduct">Return</option>
                                <option value="rpd">Product Returned Successfully</option>
                            </select>

                            <input type="submit" value="Update" name="update_order" class="option-btn">
                            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo 'No Orders Yet';
            }
            ?>
        </div>

    </section>

    <!-- JS -->
    <script src="../js/admin_script.js"></script>

</body>

</html>

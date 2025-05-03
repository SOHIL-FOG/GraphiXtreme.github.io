<?php

include 'include/connect.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'include/header.php'; ?>

   <div class="heading">
      <h3>about us</h3>
      <p> <a href="home.php">home</a> / about </p>
   </div>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/w3.jpg" alt="">
         </div>

         <div class="content">
            <h3>why choose us?</h3>
            <p>Store name Store details GraphiXtreme, a one-stop shop for computer graphics cards, 
               guaranteed on every piece according to customer needs. Guaranteed on every piece. 
               One-stop center for cheap graphics cards, really deliver. The center of good quality,
               budget-friendly computer graphics cards must be GraphiXtreme only. When buying a computer, 
               the buyer should study and find information about the product to have some basic knowledge. 
               And before deciding to buy a computer from any store, you should find good information about 
               the store first. Choose a trustworthy store. And if it's even better, you should choose a store 
               with good after-sales service. You may choose to look at information from various reviews or other
               websites to help you decide. When it comes to computers, people who have no product information, 
               no store information, and no knowledge at all will be difficult to buy products if there is no 
               trustworthy store to take care of them. If you have these problems, come consult us at GraphiXtreme. 
               We are happy to provide advice. Our company has been open for more than 8 years!! For anyone looking 
               for a new, high-quality computer graphics card, drop by to visit or consult with the shop first. 
               It doesn't matter if you don't buy. Come and talk first. The shop is happy to provide full advice.
                The shop also offers a computer spec arrangement service to please fans of assembled computers.</p>
         </div>
      </div>

   </section>







   <?php include 'include/footer.php'; ?>

   <!-- js -->
   <script src="js/script.js"></script>

</body>

</html>
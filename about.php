<?php
$title = "About Game World";
include("functions.php");

HTMLhead($title);
displayNavbar($dbConnection);
?>
<body>
<div class="container">
        <div class="logo-bg"></div>
        <h1>About This Website</h1>
        <div class="blue-line"></div>
        <p>Welcome to Game World! </p>
        <p>Game World is a website made by an ICT student to improve her web design, created by a one-person team as a web design assignment.</p>
        <p>📍 Keizerin Marialaan 2 Helmond </p>
        
        <p>📞 0492 507 900</p>
        <br>
        <br>
        <br>
        
        <h2 class="creator">TER AA</h2>
        <div class="aboutcontainer">
     
            <div class="aboutphoto">
                <img src="img/teraahelmond.jpg" alt="photo 1">
              
            </div>
            <div class="aboutphoto">
                <img src="teraahelmondtwo.jpg" alt="photo 2">
               
            </div>
            <div class="aboutphoto">
                <img src="teraahelmondthree.jpg" alt="photo 3">
               
            </div>
        </div>
    </div>

    <?php

HTMLfooter();
?>


</body>
</html>

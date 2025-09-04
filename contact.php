<?php
$title = "Contact";

include("functions.php");

HTMLhead($title);
displayNavbar($dbConnection);

?>

<body class="contactbg">

    <div>
        <div id="contact-page">

            <h1>Contact Us</h1>
            <?php
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $firstname = htmlspecialchars($_POST['firstname']);
                $lastname = htmlspecialchars($_POST['lastname']);
                $email_phone = htmlspecialchars($_POST['email_phone']);
                $message = htmlspecialchars($_POST['message']);
            
                
                $stmt = $dbConnection->prepare("INSERT INTO contact_messages (firstname, lastname, email_phone, message) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $firstname, $lastname, $email_phone, $message);
                
                if ($stmt->execute()) {
                    echo "<p>Thank you <span class='name'>$firstname $lastname</span> for your contact.</p>";
                } else {
                    echo "<p>Sorry, there was a problem saving your message.</p>";
                }
            
                $stmt->close();
            }
            
            ?>

            <form method="POST">
                <label for="firstname">First Name <span style="color: red;">*</span></label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>

                <label for="lastname">Last Name <span style="color: red;">*</span></label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>

                <label for="email_phone">Email or Phone</label>
                <input type="text" id="email_phone" name="email_phone" placeholder="Enter your email or phone">

                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Write your message" required></textarea>

                <div class="button-group">
                    <button class="buttoncontact" type="submit">Send Message</button>
                   
                </div>
            </form>
        </div>
    </div>

    
    <?php

HTMLfooter();
?>

</body>
</html>

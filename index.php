<!DOCTYPE html>
<html>
<head>
    <title>PHP Job Application Form</title>
</head>
<body>

<?php

    $firstname = ""; // Sender Name
    $lastname = ""; // Lastname
    $email = ""; 
    $phone_number = '';
    $message = '';

    $firstnameError = "";
    $lastnameError = "";
    $emailError = "";
    $phone_numberError="";
    $fileError ="";
    $errors = 0;

    $successMessage = "";  // On submitting form below function will execute.

    //validation

    //we first confirm whether the form has been submitted by checking if submit has been set. 
    //isset function in php checks if a variable is set and is not null.

    if(isset($_POST['submit'])) {

        if(!$_FILES['uploaded_file']['name']) {
            $fileError = "File is required";
            $errors = 1;
        }

        if(!isset($_POST['firstname']) || $_POST['firstname'] === '') {
            $errors = 1;
            $firstnameError = "First Name is required";

        } elseif (!preg_match("/^[a-zA-Z]*$/",$_POST['firstname'])) {
            $errors = 1;
            $firstnameError = "Only letters and white space not allowed";
        
        } else {
            $firstname = $_POST['firstname'];
        }

        if(!isset($_POST['lastname']) || $_POST['lastname'] === '') {
            $errors = 1;
            $lastnameError="Last name is required";

        } elseif (!preg_match("/^[a-zA-Z]*$/",$_POST['lastname'])) {
            $errors = 1;
            $lastnameError = "Only letters and white space not allowed";

        } else {
            $lastname = $_POST['lastname'];
        }

        if(!isset($_POST['email']) || $_POST['email'] === '') {
            $errors = 1;
            $emailError = "Email is required";

        }   elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors = 1;
            $emailError = "Email is not valid";

        }   else {
            $email = $_POST['email'];
        }


        if(!isset($_POST['phone_number']) || $_POST['phone_number'] === '') {
            $errors = 1;
            $phone_numberError = "Phone number is required";

        }   else {
            $phone_number = $_POST['phone_number'];
        }


        // Make sure the file was sent without errors
        if($_FILES['uploaded_file']['error'] == 0) {
            // Connect to the database
            $dbLink = new mysqli('localhost', 'root', '', 'forms1'); 
            // if connection fails it will throw up an error
            if(mysqli_connect_errno()) {
                die("MySQL connection failed: ". mysqli_connect_error());
            }
     
            // Gather all required data
            $firstname = $_POST['firstname']; // Sender firstname
            $lastname = $_POST['lastname']; // Sender Lastname
    		$email = $_POST['email']; //Sender email address
    		$phone_number = $_POST['phone_number'];
    		$message = $_POST['message'];
            $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
            $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
            $data = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
            $size = intval($_FILES['uploaded_file']['size']);
     
            // Create the SQL query
            $query = "
                INSERT INTO `file` (
                    `firstname`, `lastname`, `email`, `phone_number`, `message`, `name`, `mime`, `size`, `data`, `created`
                )
                VALUES (
                    '{$firstname}', '{$lastname}', '{$email}', '{$phone_number}','{$message}', '{$name}', '{$mime}', {$size}, '{$data}',  NOW()

                )";
     
            // Execute the query
            $result = $dbLink->query($query);
     
            // Check if it was successfull
            if($result) {
                echo 'Success! Your details was successfully added! Thank you for sending your details.';
                echo '<p>Click <a href="index.php">here</a> to go enter more details</p>';
            }

            else {
        echo 'Error! A file was not sent!';
    }
      

            // else {
            //     echo 'Error! Failed to insert the file'. "<pre>{$dbLink->error}</pre>";
            // }
        }

        // else {
        //     echo 'An error accured while the file was being uploaded. '
        //        . 'Error code: '. intval($_FILES['uploaded_file']['error']);
        // }
     
        // Close the mysql connection
        // $dbLink->close();
    }

    // Echo a link back to the main page

    ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>MySQL file upload example</title>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <h1>Job Application Form</h1><br><br>
        <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='css/main.css' rel='stylesheet'>
</head>
<body>

    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputFirstname" class="col-sm-2 control-label">First Name:</label>
            <div class="col-sm-10">
                <input type="text" name="firstname" class="form-control" id="inputFirstname" placeholder="First Name" value="<?php
            echo htmlspecialchars($firstname); // prefilled the form fields
            ?>">
            
            <div class="error"><?php echo $firstnameError;?></div><br>
            </div>
        </div>

        <div class="form-group">
            <label for="inputLastname" class="col-sm-2 control-label">Last Name:</label>
            <div class="col-sm-10">
                <input type="text" name="lastname" class="form-control" id="inputLastname" placeholder="Last Name" value="<?php
            echo htmlspecialchars($lastname); // prefilled the form fields
            ?>">
            
            <div class="error"><?php echo $lastnameError;?></div><br>
            </div>
        </div>

         <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-10">
                <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Email" value="<?php
                    echo htmlspecialchars($email); // prefilled the form fields
                ?>">
            <div class="error"><?php echo $emailError;?></div><br>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPhonenumber" class="col-sm-2 control-label">Phone Number:</label>
            <div class="col-sm-10">
                <input type="text" name="phone_number" class="form-control" id="inputPhonenumber" placeholder="Phone Number" value="<?php
                    echo htmlspecialchars($phone_number); // prefilled the form fields
                ?>">
            <div class="error"><?php echo $phone_numberError;?></div><br>
            </div>
        </div>

        <div class="form-group">
            <label for="inputMessage" class="col-sm-2 control-label">Message:</label>
            <div class="col-sm-10">
                <textarea rows="5" cols="40" val="" input type="text" name="message" class="form-control" id="inputMessage" placeholder="Message" "<?php
                    echo htmlspecialchars($message); // prefilled the form fields
                ?>"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="inputfile" class="col-sm-2 control-label">Resume:</label>
            <div class="col-sm-10">
                <input type="file" id="inputfile" name="uploaded_file">
            <div class="error"><?php echo $fileError;?></div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="submit" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <br><input class="submit" type="submit" name="submit" value="Submit">  
            </div>
        </div>
    </form>
    




    <p>

       <!--  <a href="list_files.php">See all files</a> -->
    </p>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
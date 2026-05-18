<?php
session_start();
include __DIR__ . "/../Data/dbConnection.php";

if(isset($_POST["firstname"])){
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $city = $_POST["city"];
    $mobilenumber = $_POST["mobilenumber"];
    $secondmoblienumber = $_POST["secondmoblienumber"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordconfirmation = $_POST["passwordconfirmation"];
    $name = "/^[a-zA-Z ]+$/";
	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	$number = "/^[0-9]+$/";
    if(empty($firstname) || empty($lastname) || empty($city) || empty($mobilenumber) || empty($secondmoblienumber) || empty($email) || empty($password) || empty($passwordconfirmation)){
        echo "<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
			</div>";

        exit();
    }else{
        if(!preg_match($name,$firstname)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $firstname is not valid..!</b>
			</div>
		";
		exit();
        }
        if(!preg_match($name,$lastname)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $lastname is not valid..!</b>
			</div>
		";
		exit();
        }
        if(!preg_match($emailValidation,$email)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $email is not valid..!</b>
			</div>
		";
		exit();
        }
        if(!preg_match($number,$mobilenumber)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $mobilenumber is not valid..!</b>
			</div>
		";
		exit();
        }
        if(!preg_match($number,$secondmoblienumber)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $secondmoblienumber is not valid..!</b>
			</div>
		";
		exit();
        }
        if(strlen($password) < 9){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this password must be 9 at least!</b>
			</div>
		";
		exit();
        }
        if($password != $passwordconfirmation){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>the password confirmation must be same to pass</b>
			</div>
		";
		exit();
        }
        $sql = "SELECT userId from users where email = '$email' LIMIT 1";
        $check_query = mysqli_query($conn,$sql);
        $emai_count = mysqli_num_rows($check_query);
        if($emai_count > 0){
            echo "
                <div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Email already exsits</b>
			</div>
            ";
            exit();
        }else{
            $sqlregisterquery = "INSERT INTO `users` (`FirstName`,`ROLE`,`lastName`,`Pass`,`mobile`,`city`,`Email`,`secondMobile`) VALUES
            ('$firstname','customer','$lastname','$password','$mobilenumber','$city','$email','$secondmoblienumber')
             ";
             $check_query = mysqli_query($conn,$sqlregisterquery);
             if($check_query){
                $lastInsertedId = mysqli_insert_id($conn);
                $insertedrow = "SELECT * FROM users where userId = '$lastInsertedId'";
                $result = mysqli_query($conn,$insertedrow);
                $row = mysqli_fetch_assoc($result);
                $createCustomer = "INSERT INTO customers(`USERID`) VALUES ('$lastInsertedId')";
                $customerCreation = mysqli_query($conn,$createCustomer);
                if($customerCreation){
                    $customerId = mysqli_insert_id($conn);
                    $_SESSION["customerid"] = $customerId;
                    $_SESSION["uid"] = $lastInsertedId;
                    $_SESSION["FirstName"] = $row["FirstName"];
                    echo "registerd_successfully";
                    exit();
                }
             }
                

        }
    }
    
}

?>
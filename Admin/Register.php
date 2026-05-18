<?php
session_start();
include __DIR__ . "../../Data/dbConnection.php";
if(isset($_POST["firstname"])){
    $firstname = $_POST["firstname"];
    $email = $_POST["email"];
    $password = $_POST["Password"];
    $passConfirmation = $_POST["repeatedPass"];
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $name = "/^[a-zA-Z ]+$/";
	$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
	$number = "/^[0-9]+$/";
    if(empty($firstname) || empty($email) || empty($password) || empty($passConfirmation)){
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
        if(!preg_match($emailValidation,$email)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>this $email is not valid..!</b>
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
        if($password != $passConfirmation){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>the password confirmation must be same to pass</b>
			</div>
		";
		exit();
        }
        $sql = "SELECT userId from users where email = '$email' LIMIT 1 ";
        $query_Check = mysqli_query($conn,$sql);
        $num_rows = mysqli_num_rows($query_Check);
        if($num_rows > 0){
            echo "<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>Email already exsits</b>
			</div>";
        }else{
            $sqlInsertion = "INSERT INTO users (`FirstName`,`Email`,`Pass`,`ROLE`) VALUE ('$firstname','$email','$hashedPass','admin')";
            $Query_run = mysqli_query($conn,$sqlInsertion);
            if($Query_run){
                $userId = mysqli_insert_id($conn);
                $lastRowquery = "SELECT * FROM users where USERID = '$userId'";
                $lastRowqueryRun = mysqli_query($conn,$lastRowquery);
                $rowGetter = mysqli_fetch_assoc($lastRowqueryRun);
                $adminCreation = "INSERT INTO admins (`USERID`) VALUES ('$userId')";
                $queryRun = mysqli_query($conn,$adminCreation);
                if($queryRun){
                    $adminId = mysqli_insert_id($conn);
                    $_SESSION["adminid"] = $adminId;
                    $_SESSION["uid"] = $userId;
                    $_SESSION["email"] = $rowGetter["Email"];
                    echo "Registered_successfully";
                    exit();
                }
            }
        }
    }
}

?>
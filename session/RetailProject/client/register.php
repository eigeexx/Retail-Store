<?php
    include_once '../env/connection.php';
    $item = $branch = $categ = "";

    if (isset($_GET['itemID'])) {
        $item = $_GET['itemID'];
    }

    if (isset($_GET['branch']) && isset($_GET['categ'])) {
        $branch = $_GET['branch'];
        $categ = $_GET['categ'];
    }

?>

<!DOCTYPE html>
<html>
<head>
<title> Register </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
</head>

<body>
    <!-- Registration form -->
    <div class="container-sm p-5 my-5 bg-dark text-white" style="max-width:50%;">
        <h2> Register </h2>
        <form id="form" action="register.php" method="post" class="form-inline"> 
            <div class="form-group">
                <div class="mb-1 mt-1">
                    <label for="username" >Username: </label>
                    <input type="text" class="form-control" id="username" name="username"  required>
                </div>
                <div class="mb-1 mt-1">
                    <label for="password" >Password: </label>
                    <input type="password" class="form-control" id="password" name="password"  required>
                     
                </div> 
                <div class="mb-1 mt-1">
                    <label for="password" >Confirm Password: </label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"  required>
                     
                </div> 
                <div class="mb-1 mt-1">
                    <label for="firstName" >First Name: </label>
                    <input type="text" class="form-control" id="firstName" name="firstName"  required>    
                </div>
                <div class="mb-1 mt-1">  
                    <label for="lastName" >Last Name: </label>
                    <input type="text" class="form-control" id="lastName" name="lastName"  required>
                </div>
                <div class="mb-1 mt-1">
                    <label for="email" >Contact Number: </label>
                    <input type="text" class="form-control" id="contact" name="contact"  required>
                </div>
                <div class="mb-1 mt-1">
                    <label for="email" >Email: </label>
                    <input type="text" class="form-control" id="email" name="email"  required>
                </div>
                <div class="col-xs-3">
                    <div class="mb-1 mt-1">
                        <label for="brgy" >Barangay: </label>
                        <input type="text" class="form-control" id="brgy" name="brgy"  required>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="mb-1 mt-1">
                        <label for="city" >City: </label>
                        <input type="text" class="form-control" id="city" name="city"  required>
                    </div>
                </div>
                <div class="mb-1 mt-1">
                    <label for="province" >Province: </label>
                    <input type="text" class="form-control" id="province" name="province"  required>
                </div>
                <div class="mb-1 mt-1">
                    <label for="postal" >Postal Code: </label>
                    <input type="text" class="form-control" id="postal" name="postal"  required>
                </div>
                <div class="mb-3 mt-3">
                    <input type="submit" value="Submit" name="register" class="btn btn-primary" style="width:150px"  >   
                        
                </div>
            </div>
        </form>  
        <form action="register.php" method="post" class="form-inline">   
            <input type="submit" value="Cancel" name="back" class="form-control" style="width:150px" > 
        </form>
    </div>
    
    <script>
  $(document).ready(function () {
   /** jQuery.validator.addMethod("passcheck", function(value, element) {
            pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
            if (pattern.test(value)) {
                return true;
            } else {
                return false;
            }
        };
    };**/

    $('#form').validate({
      rules: {
        username: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        contact: {
          required: true,
          rangelength: [10, 12],
          number: true
        },
        password: {
          required: true,
          minlength: 8,
        },
        confirmPassword: {
          required: true,
          equalTo: "#password"
        }
      },
      messages: {
        username: 'Please enter Name.',
        email: {
          required: 'Please enter Email Address.',
          email: 'Please enter a valid Email Address.',
        },
        contact: {
          required: 'Please enter Contact.',
          rangelength: 'Contact should be 10 digit number.'
        },
        password: {
          required: 'Please enter Password.',
          minlength: 'Password must be at least 8 characters long.',          
        },
        confirmPassword: {
          required: 'Please enter Confirm Password.',
          equalTo: 'Confirm Password do not match with Password.',
        }
      },
      submitHandler: function (form) {
        form.submit();
      }
    });
  });
</script>

    <?php 

        if (isset($_POST['register'])) {           #if register button pressed
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $password1 = mysqli_real_escape_string($conn,$_POST['password']);
            $firstName = mysqli_real_escape_string($conn,$_POST['firstName']);
            $lastName = mysqli_real_escape_string($conn,$_POST['lastName']);
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $brgy = mysqli_real_escape_string($conn,$_POST['brgy']);
            $city = mysqli_real_escape_string($conn,$_POST['city']);
            $province = mysqli_real_escape_string($conn,$_POST['province']);
            $postal = mysqli_real_escape_string($conn,$_POST['postal']);


            #check if username or email exists
            $check_query = "SELECT * FROM customer where cust_Username = '$username' OR cust_Email = '$email' LIMIT 1;";
            $result = mysqli_query($conn, $check_query);
            $resultCheck = mysqli_num_rows($result);

            
            if ($resultCheck==0){               #if username or email does not exist, insert new record
                $password = md5($password1);    #hash

                $insert = "INSERT INTO customer (cust_Username, cust_Password, cust_FName, cust_LName, cust_Email, cust_ABrgy, cust_ACity, cust_AProvince, cust_APostal)
                VALUES ('$username', '$password', '$firstName', '$lastName', '$email', '$brgy', '$city', '$province', '$postal');";
                mysqli_query($conn, $insert);
                $id = mysqli_insert_id($conn);
                //$_SESSION['cust_ID'] = $id;
                //$_SESSION['cust_Username']=$username;
                //echo $_SESSION['CustomerFName'];
                //header("location:../main.php");
                echo "<script> location.replace('../main.php'); </script>";
            } else {                            #else, notify user
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['cust_Username']==$username && $row['cust_Email']==$email) {
                        echo "username and email already exist";
                        break;
                    } elseif ($row['cust_Username']==$username) {
                        echo "username already exist";
                        break;
                    } elseif ($row['cust_Email']==$email) {
                        echo "email already exist";
                        break;
                    }
                }
            }    
        }
        mysqli_close($conn);
        if (isset($_POST['back'])) {            #if cancel is pressed
           # header("location:cart.php");
           echo "<script> location.replace('../main.php'); </script>";
        }
    ?>

</body>
</html>
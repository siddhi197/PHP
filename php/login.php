<?php
try{
$pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 'sid', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(exception $e){
    echo "Connection Error";
    error_log("error4.php, Database error=".$e->getMessage());
    exit;
}

$status= "Please Login";
$emailErr ="";
$passErr ="";
$e="";
$p="";
 
 


if($_SERVER["REQUEST_METHOD"]==='POST'){
    $e = $_POST['email'];
    $p = $_POST['password'];


        if (empty($e)) {
            $emailErr = "Email is required";
        }elseif (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email";
            }
        
        if(empty($p)) {
            $passErr = "Incorrect Password";
        }
                // check if e-mail address is well-formed
            
            
            if(empty($emailErr) && empty($passErr)){
           
            try{
            $statement = $pdo->prepare("Select * from users where email=:e and password=:p");
            $statement->bindValue(':e', $e);
            $statement->bindValue(':p', $p);
            $statement->execute();
            }catch(Exception $ex){
                echo "<b>Internal Error. Contact Support</b>";
                error_log("error4.php, SQL error=".$ex->getMessage());
                exit;
            }


            $result = $statement->fetch(PDO::FETCH_ASSOC);
                


            if(!empty($result)){
                header('Location: autos.php?who='.$result['email']);
            }else{
                error_log("Login Unsuccessful by ".$_POST['email']);
                $status="Login Unsuccessful";
                $e="";
                $p="";
            }
        
        }
        
    }

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="apps.css">
    <title>Welcome to Autos Database</title>
</head>
<body>
    <h1><b>Welcome to Autos Database</h1></b>
    <h4><b><?php echo $status;?></b></h4>
    
    <form  action="" method="post">
    <p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" id="username" name="email" value="<?php echo $e;?>" > </p>
    <span class="error"> <?php echo $emailErr;?></span>
    <p>Password:
   <input type="password"  id="password" name="password"  value="<?php echo $p;?>"></p>
   <span class="error"><?php echo $passErr;?></span>
    <p>
    <input type="submit" value="Login" name="login">
    <a href="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>"> Refresh </a></p>
    
  </form>
  
</body>
</html>







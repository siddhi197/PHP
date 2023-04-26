<?php
     try{
            $pdo = new PDO('mysql:host=localhost; port=3306; dbname=UpDownload', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
        echo 'Connection error: ' . $error->getMessage();
       }
      
       if($_SERVER['REQUEST_METHOD']==='POST'){   
            if (!is_dir('uploads')) {
                mkdir('uploads');
            }

       $target_dir = "uploads/";
       $target_file = $target_dir . basename($_FILES["file"]["name"]);
       $uploadOk = 1;

       $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

       
    

       // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "pdf" ) {
            echo "Sorry, only JPG, JPEG, PNG & pdf files are allowed.";
            $uploadOk = 0;
            }


                // Check file size
                if ($_FILES["file"]["size"] > 500000) {
                   echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }else
              // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                 }
                
                

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $name = $_FILES["file"]["name"];
                    $fname = date("YmdHis").'_'.$name;

                    $statement = $pdo->prepare('Insert into upload (fname, name)
                            VALUES (:fname, :name)');
                    $statement->bindValue(':fname', $fname);
                    $statement->bindValue(':name', $name);
                    $statement->execute();

                   echo  "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                   
                    header('Location: uploadfile.php');
            } else {
                echo "Sorry, there was an error uploading your file.";
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Upload and Download Files</title>
</head>
<body>
    <div class="container">
        <h3>Upload File</h3>
        <br>
        <br>
        <form enctype="multipart/form-data" action="" name="form" method="post">
           Select File
            <input type="file" name="file" id="file" /></td>
            <input type="submit" name="submit" id="submit" value="Submit" />
        </form>
        </br>
    </div>
</body>
</html>

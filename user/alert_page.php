<?php 

$message = $redirect = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["message"])) $message = $_GET["message"];
    if (isset($_GET["redirect"])) $redirect = $_GET["redirect"];
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng nhập / Đăng kí</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
        
        
    </head>
    <body>
        
       <div class="container alert alert-success" role="alert">
       <h3 class="alert-heading"><?php  echo $message ?></h3>
       
       </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/dang_nhap_dang_ki/script.js"></script>
    </body>
</html>

        <?php 
        
        header("refresh:3;url=$redirect");
        ?>
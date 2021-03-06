<?php

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../vendor/phpmailer/phpmailer/src/SMTP.php';

    require "../vendor/autoload.php";

    
    $user_email = "";

    $valid_email = "";
    $error_email = "";
    $hashed_code = "";

    function clean_input($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //setup a connection
        $hostname = "mysql5037.site4now.net";
    $username = "a7cc8e_dapoet1";
    $password = "123456aA@";
    $database = "db_a7cc8e_dapoet1";

        $conn = mysqli_connect($hostname, $username, $password, $database);

        if (!$conn) {
            echo "Cannot connect to database " . mysqli_connect_error();
        }

            $array_user = array();
            $get_command = "SELECT * FROM users";
            $re = mysqli_query($conn, $get_command);
            while ($row = mysqli_fetch_assoc($re)) {
                array_push($array_user, $row);
            }

            function create_rand_reset_code() {
                $reset_code_array = array();
                $i = 0;
                for($i = 0; $i < count($reset_code_array); $i++) {
                    array_push($reset_code_array, $reset_code_array[$i]["reset_code"]);
                }
                $reset_code = rand(100000,999999);
                while (in_array($reset_code,$reset_code_array)) {
                    $reset_code = rand(100000,999999);
                }
                return $reset_code;
            }
            
            
            $user_email = clean_input($_POST["forgor_email"]);
            

            //validate email
            if (empty($user_email)) {
                $error_email = "Xin h??y nh???p email c???a b???n";
            }
            else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $error_email = "?????nh d???ng email kh??ng h???p l???";
            } else {
                $sql = "SELECT * FROM users WHERE email=?";
                $prepare_stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($prepare_stmt, 's', $user_email);

                if (!mysqli_stmt_execute($prepare_stmt)) {
                    echo "Something went wrong, I can feel it";
                    exit();
                } else {
                    $result = mysqli_stmt_get_result($prepare_stmt);
                    if (mysqli_num_rows($result) == 0) {
                        $error_email = "Email kh??ng t???n t???i!";
                    } else {
                         $result = mysqli_fetch_assoc($result);
                    }
                    
                }
                mysqli_stmt_close($prepare_stmt);
            }

            
            if ($error_email == "") {
                //neu khong co loi nao, thi:
                //tao 1 reset_code moi
                //tra lai ket qua cho nguoi dung
                //gui mail reset cho nguoi dung
                $reset_code = create_rand_reset_code();
                //----------------tao reset_code moi---------------------------
                //LUU Y: PHAI CO DAU ' ' XUNG QUANH DU LIEU DANG STRING KHI SU DUNG MYSQLI_QUERY 
                //BOI THE, MYSQLI_PREPARE AN TOAN HON, DO MINH CHI RO KIEU DU LIEU TRONG BIND()
                $update_cmd = "UPDATE users SET reset_code=$reset_code WHERE email='$user_email';";
                
                if (!mysqli_query($conn, $update_cmd)) {
                    echo $user_email . "Failed: ". mysqli_error($conn);
                    exit;
                }
                $hashed_code = password_hash($reset_code,PASSWORD_DEFAULT);
                

                //---------------------------------------------------------------
                //-----------------------GUI MAIL CHO NGOI DUNG------------------
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'satoukazuma.clone@gmail.com';                     //SMTP username
                    $mail->Password   = 'dhihcsupdexkpqhi';                               //SMTP app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->CharSet = 'UTF-8';
                    //Recipients
                    $mail->setFrom('satoukazuma.clone@gmail.com', 'iShin Shop');
                    $mail->addAddress("$user_email");     //Add a recipient
                    
                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = "T???o m???i m???t kh???u c???a b???n";
                    $mail->Body    = "Code reset c???a b???n l?? <b> $reset_code </b>";
                    $mail->AltBody = 'Code reset c???a b???n l?? $reset_code';
                
                    $mail->send();
                    // echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                $valid_email = "Ch??ng t??i ???? g???i mail t???i ?????a ch??? email $user_email, vui l??ng m??? th?? v?? s??? d???ng m?? code ????? kh??i ph???c t??i kho???n c???a b???n.";
            }

            mysqli_close($conn);
            $return_value = array("error_email" => $error_email, "valid_email" => $valid_email, "hashed_code" => $hashed_code);
            $return = json_encode($return_value);
            echo $return;
            exit;
    }
?>


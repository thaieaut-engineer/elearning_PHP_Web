<?php
if(!defined('_THAI')){
    die('Error: You do not have permission to access this page.');
}

// Layout function to include layout files
function layout($layoutName, $data = []) {
    // Check if the layout file exists
    if(file_exists(PATH_URL_TEMPLATES . '/layouts/'.$layoutName. '.php')){
        require_once(PATH_URL_TEMPLATES . '/layouts/'.$layoutName. '.php');// Include the layout file
    }
}

// // Hàm gửi email
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// function sendMail($emailTo, $subject, $content){

// //Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//     $mail->Username   = 'user@example.com';                     //SMTP username
//     $mail->Password   = 'secret';                               //SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     $mail->setFrom('from@example.com', 'Mailer');
//     $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
//     $mail->addAddress('ellen@example.com');               //Name is optional
//     $mail->addReplyTo('info@example.com', 'Information');
//     $mail->addCC('cc@example.com');
//     $mail->addBCC('bcc@example.com');

//     //Attachments
//     $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//     $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML
//     $mail->Subject = 'Here is the subject';
//     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
// }

// Kiểm tra POST request
function isPost() {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// Kiểm tra GET request
function isGet() {
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

// lọc dữ liệu đầu vào
function filterData($method = ''){
    $filterArr = [];
    if (empty($method)) {
        if (isGet()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if (isPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }else{
        if ($method == 'get'){
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }   else if ($method == 'post'){
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $key = strip_tags($key);
                    if (is_array($value)) {
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }
    return $filterArr;
}

// Validate email
function validateEmail($email) {
    if(!empty($email)) {
        $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);// Validate email format
    }
    return $checkEmail;
}

// Validate int
function validateInt($int) {
    if(!empty($int)) {
        $checkInt = filter_var($int, FILTER_VALIDATE_INT);
    }
    return $checkInt;
}

// Validate phone number
function validatePhone($phone) {
    if(!empty($phone)) {
        $pattern = '/^(0|\+84)(3[2-9]|5[6|8|9]|7[0|6-9]|8[1-5]|9[0-4|6-9])[0-9]{7}$/';
        if(preg_match($pattern, $phone)) {
            return $phone;
        } else {
            return false;
        }
    }
    return false;
}

// thông báo lỗi
function getMsg ($msg, $type='success'){
    echo '<div class="alert alert-'.$type.'" role="alert">'.$msg.'</div>';
}

// hiển thị lỗi
function formError($errors, $fieldName){
    return !empty($errors[$fieldName]) ? '<div class="error-message">'.reset($errors[$fieldName]).'</div>' : false;// Hiển thị lỗi cho trường cụ thể
}

// hien thi du lieu cu
function oldData($oldData, $fieldName){
    return !empty($oldData[$fieldName]) ? $oldData[$fieldName] : '';// Lấy dữ liệu cũ cho trường cụ thể
}

// hàm chuyển hướng
function redirect($path, $pathFull = false){
    if($pathFull){
        header('Location: '.$path);
        exit();
    }else{
        header('Location: '.HOST_URL.$path);
        exit();
    }
    
}

//
function removeSession($key) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}


// Hàm check login
function checkLogin(){
    $checkLogin = false;
    $tokenLogin = getSession('token_login');
    $checkToken = getOnce("SELECT * FROM token_login WHERE token = '$tokenLogin'");
    if(!empty($checkToken)){
        $checkLogin = true;
    }else{
        removeSession('token_login');
    }
    return $checkLogin;
}
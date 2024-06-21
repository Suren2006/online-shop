<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';




class Model {

    public $db;

    public function __construct()
    {
        session_start();
        $this->db = new mysqli('localhost', 'mysql', 'mysql', 'shop');
        if (isset($_POST['action'])) {
            call_user_func([$this, $_POST['action']]);
        }
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = [];
        $user = $this->db->query("SELECT * FROM users WHERE email = '$email'")->fetch_all(true);

        if(empty($email)) {
            $errors['email_login'] = "Email is empty";
        }

        if(empty($_POST['password'])) {
            $errors['password_login'] = "Password is empty";
        }

        if (empty($user)) {
            $errors['email_login'] = "Email not found";
        }
        elseif (!password_verify($password, $user[0]['password'])) {
            $errors['password_login'] = "Password is incorrect";
        }

        if (!empty($errors)) {
            print_r(json_encode(['errors' => $errors]));
        }else {
            $_SESSION['user'] = $user;
            if ($user[0]['role'] == 'user') {
                print_r(json_encode(['role' => 'user']));
            }
            if($user[0]['role'] == 'admin') {
                print_r(json_encode(['role' => 'admin']));
            }
        }
    }

    public function register() {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $errors = [];
        if(empty($first_name)) {
            $errors['first_name_register'] = "First Name is empty";
        }

        if(empty($last_name)) {
            $errors['last_name_register'] = "Last Name is empty";
        }

        if(empty($email)) {
            $errors['email_register'] = "Email is empty";
        }

        if(empty($_POST['password'])) {
            $errors['password_register'] = "Password is empty";
        }

        if(!empty($errors)){
            print_r(json_encode(['errors' => $errors]));
        }else {
            $success = $this->db->query("INSERT INTO users (first_name, last_name, email, password, role) VALUES ('$first_name', '$last_name', '$email', '$password', 'user')");
//            $_SESSION['user'] = $this->db->query("SELECT * FROM users WHERE email = $email")->fetch_all(true);
            print_r(json_encode(['success' => $success]));
        }

    }

    public function forgotFunction() {

        $passcode = "";
        for($i =0;$i<6;$i++) {
            $passcode .= rand(0,9);
        }

        $_SESSION['passcode'] = $passcode;

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'surensahakyan2006@gmail.com';
        $mail->Password = 'bhwonzggxgqaqlca';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('surensahakyan2006@gmail.com');

        $mail->addAddress($_POST['email']);

        $mail->isHTML(true);

        $mail->Subject = "Forgot your password?";
        $mail->Body  = $passcode;

        $mail->send();

        echo $passcode;
    }

    public function validatefunction() {
        $user_passcode = $_POST['passcode'];
        if ($user_passcode === $_SESSION['passcode']) {
            print_r(json_encode(['success' => true]));
        }else {
            print_r(json_encode(['error' => true]));
        }

        unset($_SESSION['passcode']);
    }

    public function updatePassword() {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $update = $this->db->query("UPDATE `users` SET `password` = '$password' WHERE `email` = '$email'");
        if ($update) {
            print_r(json_encode(['success' => true]));
        }
        else {
            print_r(json_encode(['error' => true]));
        }
    }

    public function addProduct() {

        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $statusMsg = '';
        $fileName = basename($_FILES["img"]["name"]);
        $targetFilePath = "products/" . $title . "/" . time() . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if (!file_exists("products/" . $title)) {
            mkdir("products/" . $title . "/");
        }

        if(!empty($_FILES["img"]["name"])){
            $allowTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($fileType, $allowTypes)){
                if(move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)){
                    $insert = $this->db->query("INSERT into products (title, description, price, image, category) VALUES ('$title', '$description', '$price', '$targetFilePath', '$category')");
                    if($insert){
                        $statusMsg = "The post has been uploaded successfully.";
                    }else{
                        $statusMsg = "File upload failed, please try again.";
                    }
                }else{
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            }else{
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
            }
        }else{
            $statusMsg = 'Please select a file to upload.';
        }
        print_r($statusMsg);
    }

    public function editProduct() {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        $update = $this->db->query("UPDATE `products` SET `title`='$title', `description`='$description', `price`='$price', `category`='$category' WHERE `id`=$id ");

        if($update) {
            print_r(json_encode(['error' => true]));
        }else {
            print_r(json_encode(['success' => true]));
        }

    }

    public function deletefunction() {
        $id = $_POST['id'];
        $this->db->query("DELETE FROM products WHERE id = $id");
        print_r(json_encode(['success' => true]));
    }

    public function logout() {
        unset($_SESSION);
        print_r(json_encode(['success' => true]));    
    }

}

$k = new Model();
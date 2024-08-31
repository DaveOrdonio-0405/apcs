<?php
namespace Controller\User;

use Hashids\Hashids;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class User
{
    private $hash;
    private $db;
    private $auth;
    private $mail;
    private $spreadsheet;
    private $writer;
    private $mkdb;

    function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->hash = new Hashids('', 10);
        $this->db = new \MeekroDB();
        $this->spreadsheet = new Spreadsheet();
        $this->writer = new Xlsx($this->spreadsheet);
        $this->mkdb = new \PDO('mysql:dbname=apcs;host=127.0.0.1;charset=utf8mb4', 'root', '');
        $this->auth = new \Delight\Auth\Auth($this->mkdb);
    }

    public function update_password()
    {
        extract($_POST);
        try {
            $this->auth->changePassword($oldpassword, $newpassword);
            echo json_encode(["status" => 1, "response" => "success"]);
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            echo json_encode(["status" => 0, "response" => "Not logged in"]);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            echo json_encode(["status" => 0, "response" => "Invalid password(s)"]);
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            echo json_encode(["status" => 0, "response" => "Too many requests"]);
        }
    }

    public function update_profile()
    {
        extract($_POST);
        $this->db->query("UPDATE users SET email=%s, username=%s WHERE id=%i", 
                        $email, $username, $userid);

        $_SESSION['auth_username'] = $username;
        $_SESSION['auth_email'] = $email;

        echo json_encode(["response" => 1]);
    }

    public function upload_profile_files()
    {
        $files = $_FILES['image233'];
        $file_path = $files['tmp_name'];
        $file_name = $files['name'];
        $directory = "./../profile-img";
        $path = $directory."/".$file_name;
        $newdir = "../profile-img/".$file_name;

        if (!is_dir($directory)) {
            mkdir($directory, 755, true);
        }
        
        move_uploaded_file($file_path, $path);

        $id = $this->get_user_id();
        $this->db->query("UPDATE users SET img=%s WHERE id=%i", $newdir, $id);
        $_SESSION['system'][0]['img'] = $newdir;

        echo json_encode(["dir" => $newdir]);
    }

    public function upload_images()
    {   
        $files = $_FILES['image233'];
        $file_path = $files['tmp_name'];
        $file_name = $files['name'];
        $directory = "./../files";
        $path = $directory."/".$file_name;
        $newdir = "../files/".$file_name;

        if (!is_dir($directory)) {
            mkdir($directory, 755, true);
        }
        
        move_uploaded_file($file_path, $path);

        echo json_encode(["dir" => $newdir, "file" => $file_name, "type" => $files['type']]);
    }

    public function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public function get_users()
    {
        $users = $this->db->query("SELECT * FROM users");
        echo json_encode(["users" => $users]);
    }

    public function delete_user($userid)
    {
        try {
            $this->db->query("DELETE FROM users WHERE id = %i", $userid);
            echo json_encode(["status" => 1, "message" => "User deleted successfully."]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to delete user. Error: " . $e->getMessage()]);
        }
    }

    public function login_user()
    {
        extract($_POST);
        try {
            $this->auth->login($email, $password);
            $id = $this->get_user_id();
            $info = $this->db->query("SELECT * FROM users WHERE id='%i'", $id);    
            $_SESSION["system"] = $info;
            echo json_encode(["response" => 'Successfully login', "status" => 1]);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            echo json_encode(["response" => 'Wrong email address', "status" => 0]);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            echo json_encode(["response" => 'Wrong password', "status" => 0]);
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            echo json_encode(["response" => 'Email not verified', "status" => 0]);
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            echo json_encode(["response" => 'Too many requests', "status" => 0]);
        }
    }

    public function register_user()
    {
        extract($_POST);
        try {
            $userId = $this->auth->register($email, $password, $username, function ($selector, $token) {});
            $this->verification($email, $this->hash->encode($userId));
            echo json_encode(["response" => 'Verification email has been sent!', "status" => 1]);
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            echo json_encode(["response" => 'Invalid email address', "status" => 0]);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            echo json_encode(["response" => 'Invalid password', "status" => 0]);
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            echo json_encode(["response" => 'User already exists', "status" => 0]);
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            echo json_encode(["response" => 'Too many requests', "status" => 0]);
        }
    }

    public function verify_user($userid)
    {
        $this->db->query("UPDATE users SET verified=%i WHERE id=%i", 1, $this->hash->decode($userid)[0]);
        header("location: https://learnitedu.info/index.php");
    }

    public function verification($email, $userid)
    {
        try {
            $this->mail->SMTPDebug = false; // Disable verbose debug output
            $this->mail->isSMTP(); // Send using SMTP
            $this->mail->Host = 'mail.negroscodeworks.com'; // Set the SMTP server to send through
            $this->mail->SMTPAuth = true; // Enable SMTP authentication
            $this->mail->Username = 'marben@negroscodeworks.com'; // SMTP username
            $this->mail->Password = 'DICt#ia$mzyH'; // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $this->mail->Port = 587; // TCP port to connect to
            
            // Recipients
            $this->mail->setFrom('marben@negroscodeworks.com', 'verification');
            $this->mail->addAddress($email); // Add a recipient

            // Content 
            $this->mail->isHTML(true); // Set email format to HTML
            $this->mail->Subject = 'Verification Email';
            $this->mail->Body = "<h2> Greetings User! <h2> <br> <h3>Click the link to verify account: <a href='https://learnitedu.info/teacherapi/user-verify/".$userid."' >Verify account</a></h3>";
            $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function logout()
    {
        $this->auth->logOut();   
        unset($_SESSION['system']);
        echo json_encode(["response" => "logout"]);
    }

    public function checking_auth()
    {
        return $this->auth->isLoggedIn();
    }

    public function get_user_id()
    {
        return $this->auth->getUserId();
    }

    public function get_user($userid)
    {
        try {
            // Fetch the user details by id
            $user = $this->db->queryFirstRow("SELECT * FROM users WHERE id = %i", $userid);
            
            if ($user) {
                echo json_encode($user);  // Return the user details as JSON
            } else {
                echo json_encode(["status" => 0, "message" => "User not found."]);
            }
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to retrieve user. Error: " . $e->getMessage()]);
        }
    }

    public function update_user($userid)
    {
        extract($_POST); // Extracts username and verified from the POST data

        try {
            // Update user details in the database
            $this->db->query("UPDATE users SET username = %s, verified = %i WHERE id = %i", 
                             $username, $verified, $userid);
                             
            echo json_encode(["status" => 1, "message" => "User updated successfully."]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to update user. Error: " . $e->getMessage()]);
        }
    }

    public function approve_user($userid)
    {

        try {
            // Update user details in the database
            $this->db->query("UPDATE users SET verified = %i WHERE id = %i", 1, $userid);
                             
            echo json_encode(["status" => 1, "message" => "User updated successfully."]);
            
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to update user. Error: " . $e->getMessage()]);
        }
    }


}



?>




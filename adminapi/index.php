<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

require_once('Controller/Users.php');
require_once('Controller/Patients.php');  // Include Patients controller

include __DIR__ . '/../vendor/autoload.php';

DB::$user = 'root';
DB::$password = '';
DB::$dbName = 'apcs';
DB::$encoding = 'utf8';

use Controller\User\User;
use Controller\Patients;  // Import Patients class
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();
$user = new User();
$patientController = new Patients();  // Initialize Patients controller

date_default_timezone_set('Asia/Manila');

// Define your routes with the correct prefix
$router->get('apcs/adminapi/get-users', fn() => $user->get_users());
$router->post('apcs/adminapi/user-register', fn() => $user->register_user());
$router->post('apcs/adminapi/users-login', fn() => $user->login_user());
$router->get('apcs/adminapi/user-verify/{userid}', fn($userid) => $user->verify_user($userid));
$router->post('apcs/adminapi/user-logout', fn() => $user->logout());
$router->post('apcs/adminapi/upload-profile-files', fn() => $user->upload_profile_files());
$router->post('apcs/adminapi/update-profile', fn() => $user->update_profile());
$router->post('apcs/adminapi/update-password', fn() => $user->update_password());
$router->delete('apcs/adminapi/delete-user/{userid}', fn($userid) => $user->delete_user($userid));
$router->get('apcs/adminapi/get-user/{userid}', fn($userid) => $user->get_user($userid));
$router->post('apcs/adminapi/update-user/{userid}', fn($userid) => $user->update_user($userid));
$router->post('apcs/adminapi/approve-user/{userid}', fn($userid) => $user->approve_user($userid));

// Patient routes
$router->get('apcs/adminapi/get-patients', fn() => $patientController->get_patients());
$router->get('apcs/adminapi/get-patient/{id}', fn($id) => $patientController->get_patient($id));
$router->post('apcs/adminapi/add-patient', fn() => $patientController->add_patient());
$router->post('apcs/adminapi/update-patient/{id}', fn($id) => $patientController->update_patient($id));
$router->delete('apcs/adminapi/delete-patient/{id}', fn($id) => $patientController->delete_patient($id));

$dispatcher = new Dispatcher($router->getData());
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
echo $dispatcher->dispatch($httpMethod, $uri), "\n";

?>

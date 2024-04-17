<?php 
session_start();

include_once('../layout/functions/functions.php');
$method = $_GET['method'];
if($method != "") {
    $User = new UserController();
    if($method == 'showLogin') {
        $User->showLogin();
    }

    if($method == 'showRegister') {
        $User->showRegister();
    } 

    if($method == 'register') {
        $User->Register();
    } 

    if($method == 'login') {
        $User->login();
    }

    if($method == 'showSettings') {
        $User->showSettings();
    }

    if($method == 'showChangePassword') {
        $User->showChangePassword();
    }

    if($method == 'editProfile') {
        $User->editProfile();
    }

    if($method == 'changePassword') {
        $User->changePassword();
    }

    if($method == 'showProfile') {
        $User->showProfile();
    }

    if($method == 'dashboard') {
        $User->showDashboard();
    }

    if($method == 'showUsers') {
        $User->showUsers();
    }

    if($method == 'logout') {
        $User->logout();
    }

}

class UserController {
    private $Path = "../users/";

    public function getAuth() {
        if($_SESSION['User']['role'] == 'head') {
            $this->Path = '../head/';
        }
    }
    public function showLogin() {
        header('location: '.$this->Path.'login.php');
    }

    public function login() {
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['User_login'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $data = [
                    'email'=>$email,
                ];
                $error=[];
                if (empty($email)) {
                    array_push($error,"email required");
                } 
                if (empty($password)) {
                    array_push($error,"password requires");
                } 
                if (strlen($password)>0 && strlen($password)<8) {
                    array_push($error,"this password less than 8 digit");
                }  
                $User = selectOne('*','Users',"email = '$email'");
                if (empty($User)) {
                    array_push($error,"this email not exist in Database");
                } 

                if (!empty($User) ) {
                    if(! password_verify($password,$User['password'])) {
                            array_push($error,"this password is invalid");
                    }
                }

                if(!empty($error))
                {
                    $_SESSION['oldData'] = $data;
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'login.php');
                    exit();
                }
                
                $_SESSION['User'] = $User;
                $_SESSION['username'] = $User['name'];
                $_SESSION['msg'] = "Dr".$User['name']." Login Successfuly";

                if($User['role'] == 'head') {
                    header('location: ../head/dashboard.php');

                } else {
                    header('location: ../User/dashboard.php');
                }
               
                


            }
        }
    }


    public function showRegister() {
        $_SESSION['departments'] = selectAll('*','departments');
        header('location: '.$this->Path.'register.php');
    }

    public function register() {
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['User_register'])) {
                $name=trim($_POST['name']);
                $email = trim($_POST['email']);
                $mobile = trim($_POST['mobile']);
                $office_location = trim($_POST['office_location']);
                $office_phone = trim($_POST['office_phone']);
                $department_id = trim($_POST['department_id']);
                $password = trim($_POST['password']);
                $confirm_password = trim($_POST['confirm_password']);
                $hashpassword = password_hash($password, PASSWORD_BCRYPT);
                $data = [
                    'email'=>$email,'name'=>$name,'password'=> $hashpassword,'mobile' => $mobile,'role' => 'User',
                    'office_location' => $office_location,'office_phone' => $office_phone,'department_id' => $department_id
                ];
                $_SESSION['oldData'] = $data;
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } if (empty($email)) {
                    array_push($error,"email required");
                } if (empty($mobile)) {
                    array_push($error,"Mobile required");
                } if (empty($office_phone)) {
                    array_push($error,"Office Phone required");
                }if (empty($department_id)) {
                    array_push($error,"Department Id required");
                }if (empty($office_location)) {
                    array_push($error,"Office Location required");
                } if (empty($password)) {
                    array_push($error,"password required");
                } if (strlen($password)>0 && strlen($password)<8) {
                    array_push($error,"this password less than 8 digit");
                } if (empty($confirm_password)) {
                    array_push($error,"confirm_password required");
                } if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                } 
                $User = selectOne('*','Users',"email = '$email'");
                if (!empty($User)) {
                    array_push($error,"this email exist in Database");
                } if(!empty($error))
                {
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'register.php');
                    exit();
                }
                $inserted = array_values($data);
                $keys = join(',',array_keys($data));
                $id = insert($keys,'Users','?,?,?,?,?,?,?,?',$inserted);
                if(!empty($id)) {
                    $result = selectOne('*','Users','id = '.$id);
                    $_SESSION['User'] = $result;
                    $_SESSION['username'] = $result['name'];
                    $_SESSION['msg'] = "Dr".$result['name']." Register Successfuly";
                    $this->showDashboard();  
                }
            }
        }
    }


    public function changePassword() {
        $this->getAuth();
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['change_password'])) {
                $confirm_password = trim($_POST['confirm_password']);
                $password = trim($_POST['password']);
                $hashpassword = password_hash($password, PASSWORD_BCRYPT);
                $User_id = $_SESSION['User']['id'];
                $data = [
                    'password'=>$hashpassword,
                    'id'=>$User_id
                ];
                $error=[];
                if (empty($password)) {
                    array_push($error,"password required");
                } 
                if (strlen($password)>0 && strlen($password)<8) {
                    array_push($error,"this password less than 8 digit");
                } 
                if (empty($confirm_password)) {
                    array_push($error,"confirm_password required");
                } 
                if ($password!=$confirm_password) {
                    array_push($error,"passwords not matched");
                }

                if(!empty($error))
                {
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'changePassword.php');
                    exit();
                }

                $success = update('password = ?','Users',array_values($data),'id = ?');
                if($success) {
                    $_SESSION['User']['password'] = $hashpassword;
                    $_SESSION['msg'] = "Change Password Successfuly";

                    header('location: '.$this->Path);
                }

            }
        }
    }

    public function editProfile() {
        $this->getAuth();
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['edit_profile'])) {
                $email = trim($_POST['email']);
                $name = trim($_POST['name']);
                $mobile = trim($_POST['mobile']);
                $office_location = trim($_POST['office_location']);
                $office_phone = trim($_POST['office_phone']);
                $User_id = $_SESSION['User']['id'];
                $photoName = $_FILES['photo']['name'];
                $current_password = trim($_POST['current_password']);
                $password = trim($_POST['new_password']);
                $confirm_password = $password ? trim($_POST['confirm_password']) : '';
                $hashpassword = $password ? password_hash($password, PASSWORD_BCRYPT) : '';
                if(!empty($photoName)) {
                    $photoSize = $_FILES['photo']['size'];
                    $photoTmp	= $_FILES['photo']['tmp_name'];
                    $photoAllowedExtension = array("jpeg", "jpg", "png");
                    $explode = explode('.', $photoName);
                    $photoExtension = strtolower(end($explode));
                }
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'office_location' => $office_location,
                    'office_phone' => $office_phone,
                    'mobile' => $mobile,
                    'password' => $password ? $hashpassword : $_SESSION['User']['password'],

                    

                ];
                $error=[];
                if (empty($email)) {
                    array_push($error,"email required");
                } 
                if (empty($name)) {
                    array_push($error,"name required");
                } 
                if (empty($mobile)) {
                    array_push($error,"Mobile required");
                }
                if (empty($office_phone)) {
                    array_push($error,"Office Phone required");
                }
                if (empty($office_location)) {
                    array_push($error,"Office Location required");
                } 
                if($email != $_SESSION['User']['email']) {
                    $User = selectOne('*','Users',"email = '$email'");
                    if (!empty($User) ) {
                        array_push($error,"this email exist in Database");
                    } 
                }
                if (! empty($photoName) && ! in_array($photoExtension, $photoAllowedExtension)) {
                    $error[] = 'This Extension Is Not <strong>Allowed</strong>';
                }

                if (!empty($password)) {
                    if (empty($current_password)) {
                        array_push($error,"Old Password required");
                    }
                    if (strlen($current_password)>0 && strlen($current_password)<8) {
                        array_push($error,"This Cuttent password less than 8 digit");
                    } 
                    if(!password_verify($current_password,$_SESSION['User']['password'])) {
                        array_push($error,"This Current password invalid");
                    }
                    if (strlen($password)>0 && strlen($password)<8) {
                        array_push($error,"This password less than 8 digit");
                    } 
                    if (empty($confirm_password)) {
                        array_push($error,"Confirm Password required");
                    } 
                    if ($password!=$confirm_password) {
                        array_push($error,"passwords not matched");
                    }
                } 

                if (! empty($photoName) && $photoSize > 4194304) {
                    $error[] = 'photo Cant Be Larger Than <strong>4MB</strong>';
                }
                if(!empty($error))
                {
                    $_SESSION['errors'] = $error;
                    $_SESSION['oldData'] = $data;
                    header('location: '.$this->Path.'settings.php');
                    exit();
                }

                $oldphoto = $_SESSION['User']['photo'];
                if(!empty($photoName)) {
                    $path = '../assets/images/Users/'.$User_id;
                    if(!is_dir($path)) {
                        mkdir($path);
                    } 
                    if($oldphoto != null) {
                        unlink($path.'/'.$oldphoto);
                    }
                    move_uploaded_file($photoTmp, $path.'/'. $photoName);
                }
                $photo = !empty($photoName) ? $photoName : $oldphoto;
                $data['photo'] = $photo;
                $data['id'] = $User_id;
                $success = update('email = ? , name = ? , office_location = ? , office_phone = ? , mobile = ?,password = ?, photo = ?','Users',array_values($data),'id = ?');
                if($success) {
                    $_SESSION['username'] = $name;
                    $_SESSION['User']['email'] = $email; 
                    $_SESSION['User']['name'] = $name; 
                    $_SESSION['User']['photo'] = $photo; 
                    $_SESSION['User']['office_location'] = $office_location; 
                    $_SESSION['User']['office_phone'] = $office_phone; 
                    $_SESSION['User']['mobile'] = $mobile; 
                    $_SESSION['User']['password'] = $password ? $hashpassword : $_SESSION['User']['password']; 


                    $_SESSION['msg'] = "Edit Profile Successfuly";

                    header('location: '.$this->Path);

                }


            }
        }
    }

    public function showSettings() {
        $this->getAuth();
        header('location: '.$this->Path.'settings.php');
    }

    public function showChangePassword() {
        $this->getAuth();
        header('location: '.$this->Path.'change-password.php');

    }

    public function showProfile() {
        $this->getAuth();
        $department = selectOne('name','departments', "id = {$_SESSION['User']['department_id']}");
        $_SESSION['User']['department'] = $department['name'];
        header('location: '.$this->Path);
    }

    public function showDashboard() {
        $this->getAuth();
        header('location: '.$this->Path.'dashboard.php');
    }


    public function showUsers() {
        $_SESSION['Users'] = selectAll('*','Users','role = "User" and department_id ='.$_SESSION['User']['department_id']);
        header('location: ../head/Users/');

    }

    
    public function logout(){
        unsetAllSession();
        unset($_SESSION['User']);
        unset($_SESSION['username']);
        header('location: ../');

    }
    


}
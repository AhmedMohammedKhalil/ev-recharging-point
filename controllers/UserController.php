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

    if($method == 'showProfile') {
        $User->showProfile();
    }

    if($method == 'logout') {
        $User->logout();
    }

}

class UserController {
    private $Path = "../users/";

    public function showLogin() {
        header('location: '.$this->Path.'login.php');
    }

    public function login() {
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['user_login'])) {
                $account_number = trim($_POST['account_number']);
                $pin = trim($_POST['pin']);
                $data = [
                    'account_number'=>$account_number,
                ];
                $error=[];
                if (empty($account_number)) {
                    array_push($error,"Account Number required");
                } 
                if (empty($pin)) {
                    array_push($error,"pin requires");
                } 

                if (strlen($account_number) != 10) {
                    array_push($error,"Account Number must be 10 digit");
                }

                if (strlen($pin) != 6) {
                    array_push($error,"pin must be 6 digit");
                }
                
                if (!is_numeric($pin)) {
                    array_push($error,"pin must be numbers only");
                }

                $User = selectOne('*','Users',"account_number = '$account_number'");
                if (empty($User)) {
                    array_push($error,"This Account not exist in Database");
                } 

                if (!empty($User) ) {
                    if($User['pin'] != $pin) {
                            array_push($error,"This Pin is invalid");
                    }
                }

                if(!empty($error))
                {
                    $_SESSION['oldData'] = $data;
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'login.php');
                    exit();
                }
                
                $_SESSION['user'] = $User;
                $_SESSION['username'] = $User['name'];
                $_SESSION['msg'] = $User['name']." Login Successfuly";
                $this->showProfile();
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
            if(isset($_POST['user_register'])) {
                $name=trim($_POST['name']);
                $account_number = trim($_POST['account_number']);
                $pin = trim($_POST['pin']);
                $data = [
                    'account_number'=>$account_number,'name'=>$name,'pin'=> $pin
                ];
                $_SESSION['oldData'] = $data;
                $error=[];
                if (empty($name)) {
                    array_push($error,"name required");
                } if (empty($account_number)) {
                    array_push($error,"account_number required");
                } if (empty($pin)) {
                    array_push($error,"pin required");
                }
                
                if (strlen($account_number) != 10) {
                    array_push($error,"account number must be 10 digit");
                }

                if (strlen($pin) != 6) {
                    array_push($error,"pin must be 6 digit");
                }
                
                if (!is_numeric($pin)) {
                    array_push($error,"pin must be numbers only");
                }

                $User = selectOne('*','Users',"account_number = '$account_number'");
                if (!empty($User)) {
                    array_push($error,"this Account exist in Database");
                } if(!empty($error))
                {
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'register.php');
                    exit();
                }
                $inserted = array_values($data);
                $keys = join(',',array_keys($data));
                $id = insert($keys,'Users','?,?,?',$inserted);
                if(!empty($id)) {
                    $result = selectOne('*','Users','id = '.$id);
                    $_SESSION['user'] = $result;
                    $_SESSION['username'] = $result['name'];
                    $_SESSION['msg'] =  $result['name']." Register Successfuly";
                    $this->showProfile();  
                }
            }
        }
    }



    
    

    public function showProfile() {
        header('location: '.$this->Path);
    }

    public function logout(){
        unsetAllSession();
        unset($_SESSION['user']);
        unset($_SESSION['username']);
        header('location: ../');

    }
    


}
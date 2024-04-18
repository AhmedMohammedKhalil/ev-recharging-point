<?php 
session_start();

include_once('../layout/functions/functions.php');
$method = $_GET['method'];
if($method != "") {
    $Charging = new ChargingController();

    if($method == 'showChargingDetails') {
        $Charging->showChargingDetails();
    }
    
    if($method == 'createCharging') {
        $Charging->createCharging();
    }

    if($method == 'cancelCharging') {
        $Charging->cancelCharging();
    }

    if($method == 'startCharging') {
        $Charging->startCharging();
    }

    if($method == 'loadingCharging') {
        $Charging->loadingCharging();
    }

    if($method == 'finishCharging') {
        $Charging->finishCharging();
    }

}

class ChargingController {
    private $Path = "../users/charging_details/";
    private $user;
        

    public function __construct() {
       $this->user = $_SESSION['user'];
    }


    public function showChargingDetails() {
        $where = "user_id = {$this->user['id']} And open ='open'";
        $charging_details = selectOne('*','charging_details',$where);
        if(!empty($charging_details)) {
            $_SESSION['charging_details'] = $charging_details;
            if($charging_details['status'] == 'wait-starting') {
                $this->showStartingDetails();
                exit();
            } elseif($charging_details['status'] == 'wait-ending') {
                $this->showLoadingDetails();
                exit();
            } elseif($charging_details['status'] == 'canceling') {
                $this->showCancelingDetails();
                exit();
            }
        } else {
            $this->showCreateCharging();
        }
    }


    

    public function createCharging() {
       
    }

    public function startCharging() {
       
    }

    public function finishCharging() {
       
    }

    public function cancelCharging() {
       
    }

    public function loadingCharging() {
       
    }

    public function showCreateCharging() {
        header('location: '.$this->Path."create_charging.php");
    }


    public function showStartingDetails() {
        header('location: '.$this->Path."starting_details.php");
    }

    public function showLoadingDetails() {
        header('location: '.$this->Path."loading_details.php");
    }

    public function showCancelingDetails() {
        header('location: '.$this->Path."canceling_details.php");
    }

    public function showFinishingDetails() {
        header('location: '.$this->Path."finishing_details.php");
    }



}
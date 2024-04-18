<?php 
if (session_id() === "") {session_start();}

if(isset($_GET['method'])) {
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
}


class ChargingController {
    private $Path = "../users/charging_details/";
    private $user;

    private $powerLevels = [
        'car' => 7,         // Power level for car (7 kW)
        'e-bike' => 0.9,    // Power level for e-bike (0.9 kW)
        'e-scooter' => 0.25 // Power level for e-scooter (0.25 kW)
    ];
    
    // Define charge durations for each vehicle type in hours
    private $chargeDurations = [
        'car' => 8,         // Charge duration for car (8 hours)
        'e-bike' => 2,      // Charge duration for e-bike (2 hours)
        'e-scooter' => 1    // Charge duration for e-scooter (1 hour)
    ];
        

    public function __construct() {
       $this->user = $_SESSION['user'];
       $this->calculatePower();
    }

    public function calculateKWPerMinute($powerLevel, $chargeDuration) {
        $chargeDurationInMinutes = $chargeDuration * 60;
        $kWPerMinute = $powerLevel / $chargeDurationInMinutes;
        return $kWPerMinute;
    }


    public function calculatePower() {

        foreach ($this->powerLevels as $vehicleType => $powerLevel) {
            $chargeDuration = $this->chargeDurations[$vehicleType];
            $kWPerMinute = $this->calculateKWPerMinute($powerLevel, $chargeDuration);
            if($vehicleType == 'car') {
                $_SESSION['power']['car'] = $kWPerMinute;
            } elseif($vehicleType == 'e-bike') {
                $_SESSION['power']['e-bike'] = $kWPerMinute;
            } else {
                $_SESSION['power']['e-scooter'] = $kWPerMinute;
            }
        }
    }


    public static function calculateRemainingTime() {

        $startTime = strtotime($_SESSION['charging_details']['time_start']);
        $endTime = strtotime($_SESSION['charging_details']['time_end']);
        $currentTime = time();
        $remainingTime = $endTime - $currentTime;
        $chargingTime = $currentTime - $startTime;
        $_SESSION['charging_details']['time_charging'] = $chargingTime;
        $_SESSION['charging_details']['time_up'] = gmdate("H:i:s",$remainingTime);
    }
    
    public static function calculateCurrentPower() {
        if($_SESSION['charging_details']['vehicle_type'] == 'car') {
            $power = $_SESSION['power']['car'];
        } elseif($_SESSION['charging_details']['vehicle_type'] == 'e-bike') {
            $power =  $_SESSION['power']['e-bike'];
        } else {
            $power =  $_SESSION['power']['e-scooter'];
        }
        $currentPower = $power * ($_SESSION['charging_details']['time_charging'] / 60);
        
        $_SESSION['charging_details']['power_up'] = round($currentPower + $_SESSION['charging_details']['power_init'],2);
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
            } else {
                $this->showFinishingDetails();
                exit();
            }
        } else {
            $this->showCreateCharging();
        }
    }


    

    public function createCharging() {
        // add all details after validation
        //then redirect to showChargingDetails function
    }

    public function startCharging() {
        // start charge after update details
        //then redirect to showChargingDetails function

    }

    public function finishCharging() {
        // close charge 
        //then redirect to showChargingDetails function

    }

    public function cancelCharging() {
        //cancel charge with validation pin and update details
        //then redirect to showChargingDetails function

    }

    public static function loadingCharging() {
        ChargingController::calculateRemainingTime();
        ChargingController::calculateCurrentPower();
        
        //check if finish charge and update charge

    }

    public function showCreateCharging() {
        header('location: '.$this->Path."create_charging.php");
    }


    public function showStartingDetails() {
        header('location: '.$this->Path."starting_details.php");
    }

    public function showLoadingDetails() {
        $this->loadingCharging();
        header('location: '.$this->Path."loading_details.php");
    }

    public function showCancelingDetails() {
        header('location: '.$this->Path."canceling_details.php");
    }

    public function showFinishingDetails() {
        header('location: '.$this->Path."finishing_details.php");
    }


}
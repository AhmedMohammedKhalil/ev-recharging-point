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
    private $user,$car_power_m,$bike_power_m,$scooter_power_m;

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
        // Calculate kW per minute
        $kWPerMinute = $powerLevel / $chargeDurationInMinutes;
        return $kWPerMinute;
    }


    public function calculatePower() {

        foreach ($this->powerLevels as $vehicleType => $powerLevel) {
            $chargeDuration = $this->chargeDurations[$vehicleType];
            $kWPerMinute = $this->calculateKWPerMinute($powerLevel, $chargeDuration);
            if($vehicleType == 'car') {
                $this->car_power_m = $kWPerMinute;
            } elseif($vehicleType == 'e-bike') {
                $this->bike_power_m = $kWPerMinute;
            } else {
                $this->scooter_power_m = $kWPerMinute;
            }
        }
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
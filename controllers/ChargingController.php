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
        unset( $_SESSION['charging_details']['time_charging'], $_SESSION['charging_details']['time_up']);
        $startTime = strtotime($_SESSION['charging_details']['time_start']);
        $endTime = strtotime($_SESSION['charging_details']['time_end']);
        $currentTime = strtotime('now');
        $remainingTime = $endTime - $currentTime;
        $chargingTime = $currentTime - $startTime;
        $_SESSION['charging_details']['time_charging'] = $chargingTime;
        $_SESSION['charging_details']['time_up'] = gmdate("H:i:s",$remainingTime);
    }
    
    public static function calculateCurrentPower() {
        unset( $_SESSION['charging_details']['power_up']);
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
        unset($_SESSION['charging_details']);
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
        unset($_SESSION['charging_details']);
        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['create_charging'])) {
                $power_init=trim($_POST['power_init']);
                $vehicle_type = trim($_POST['vehicle_type']);
                $charging_bay = trim($_POST['charging_bay']);
                $charge_duration = trim($_POST['charge_duration']);
                $power_level = $this->powerLevels[$vehicle_type];
                $payment_type = trim($_POST['payment_type']);
                $user_id = $this->user['id'];

                $data = [

                    'power_init'  => $power_init,
                    'vehicle_type'  =>  $vehicle_type,
                    'charging_bay' =>  $charging_bay,
                    'charge_duration' => $charge_duration,
                    'power_level' => $power_level,
                    'payment_type' =>  $payment_type,
                    'open' =>  'open',
                    'status' => 'wait-starting',
                    'user_id' => $user_id,
                ];

                $_SESSION['oldData'] = $data;
                $error=[];

                if (empty($power_init)) {
                    array_push($error,"car power required");
                } if (empty($vehicle_type)) {
                    array_push($error,"vehicle type required");
                } if (empty($charging_bay)) {
                    array_push($error,"charging bay required");
                } if (empty($payment_type)) {
                    array_push($error,"payment type required");
                } if (empty($charge_duration)) {
                    array_push($error,"charge duration required");
                } if (!is_numeric($charge_duration)) {
                    array_push($error,"charge duration must be number");
                } if ($power_init > $this->powerLevels[$vehicle_type]) {
                    array_push($error,"Car power must be less than ".$this->powerLevels[$vehicle_type]);
                } if ($charge_duration > $this->chargeDurations[$vehicle_type]) {
                    array_push($error,"charge duration must be less than ".$this->chargeDurations[$vehicle_type]);
                } if (empty($errors)) {
                    $chargingpower = ($charge_duration * 60 * $_SESSION['power'][$vehicle_type]) + $power_init;
                    if($chargingpower > $this->powerLevels[$vehicle_type]) {
                        array_push($error,"car power or charging Duration are Invalid that total power greater than".$this->powerLevels[$vehicle_type]);
                    }
                }


                

                if(!empty($error))
                {
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'create_charginig.php');
                    exit();
                }
                $inserted = array_values($data);
                $keys = join(',',array_keys($data));
                $id = insert($keys,'charging_details','?,?,?,?,?,?,?,?,?',$inserted);
                if(!empty($id)) {
                    $this->showChargingDetails();  
                }
            }
        }
    }

    public function startCharging() {

        $now = date("H:i:s",strtotime('now'));
        $charge = ($_SESSION['charging_details']['charge_duration'] * 60);
        $end_time = date('H:i:s', strtotime("now +". $charge ." Minutes"));
        $data = [
            'time_start' => $now,
            'time_end' => $end_time,
            'status' => 'wait-ending',
            'id' => $_SESSION['charging_details']['id'],
        ];

        $success = update('time_start = ? , time_end = ? , status = ?','charging_details',array_values($data),'id = ?');
        if($success) {
            $this->showChargingDetails();  
        }
        

    }

    public function finishCharging() {

        $data = [
            'status' => 'finishing',
            'open' => 'close',
            'id' => $_SESSION['charging_details']['id'],
        ];
        $success = update('status = ? , open = ?','charging_details',array_values($data),'id = ?');
        if($success) {
            $this->showChargingDetails();  
        }
        

    }

    public function cancelCharging() {


        $error=[];
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if(isset($_POST['cancel_charging'])) {


                $pin = trim($_POST['pin']);
                if (empty($pin)) {
                    array_push($error,"pin requires");
                } 
                if (strlen($pin) != 6) {
                    array_push($error,"pin must be 6 digit");
                }
                
                if (!is_numeric($pin)) {
                    array_push($error,"pin must be numbers only");
                }

                if($this->user['pin'] != $pin) {
                    array_push($error,"This Pin is invalid");
                }

                if(!empty($error))
                {
                    $_SESSION['errors'] = $error;
                    header('location: '.$this->Path.'loading_details.php');
                    exit();
                }

                $data = [
                    'status' => 'canceling',
                    'power_up' => $_SESSION['charging_details']['power_up'],
                    'time_up' => $_SESSION['charging_details']['time_up'],
                    'id' => $_SESSION['charging_details']['id'],
                ];
                $success = update('status = ? , power_up = ? , time_up = ?','charging_details',array_values($data),'id = ?');
                if($success) {
                    $this->showChargingDetails();  
                }
            }
        }
        
        

    }

    public static function loadingCharging() {
        unset( $_SESSION['charging_details']['time_charging'], $_SESSION['charging_details']['time_up'],$_SESSION['charging_details']['power_up']);
        ChargingController::calculateRemainingTime();
        ChargingController::calculateCurrentPower();
        
        if(strtotime('now') > strtotime($_SESSION['charging_details']['time_end']) && $_SESSION['charging_details']['status'] == 'wait-ending') {
            $data = [
                'status' => 'finishing',
                'power_up' => ($_SESSION['charging_details']['charge_duration'] * 60 * $_SESSION['power'][$_SESSION['charging_details']['vehicle_type']]) + $_SESSION['charging_details']['power_init'],
                'time_up' => date('H:s:i',strtotime('00:00:00')),
                'id' => $_SESSION['charging_details']['id'],
            ];
            $success = update('status = ? , power_up = ? , time_up = ?','charging_details',array_values($data),'id = ?');

            if($success) {
                $where = "user_id = {$_SESSION['charging_details']['user_id']} And open ='open'";
                $charging_details = selectOne('*','charging_details',$where);
                unset( $_SESSION['charging_details']);
                $_SESSION['charging_details'] = $charging_details;
                header("location: finishing_details.php");
            }
        }
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
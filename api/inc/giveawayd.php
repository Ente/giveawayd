<?php
namespace GiveawayD{
ob_start();
require_once "discord.inc.php";
ob_end_flush();
class GiveawayD{

    private array $ini;

    public \mysqli $db;

    public function __construct(){
        $this->ini = parse_ini_file("app.ini", true);
        $this->db = $this->database_connect($this->ini["db"]);
    }

    public static function database_connect(array $db_config): \mysqli{
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        if(mysqli_connect_error()){
            throw new \Exception("Could not establish a connection to the database!");
        } else {
            return $conn;
        }
    }

    public function checkID(){
        @session_start();
        if(@$_SESSION["access_token"]){
            global $apiURLBase;
            $user = apiRequest($apiURLBase);
            $id = $user->id;
            $sql = "SELECT id FROM users WHERE id = '{$id}';";
            $res = mysqli_query($this->db, $sql);
            $count = mysqli_num_rows($res);
            $_SESSION["id"] = $user->id;

            if($count == 1){
                return $_SESSION["log_checkid"] = true;
            } else {
                header("Location: /api/v1/registerUser.php");
            }
        } else {
            return false;
        }
    }

    public function data($user_id){
        $sql = "SELECT * FROM users WHERE id = '{$user_id}';";
        $res = mysqli_query($this->db, $sql);
        $count = mysqli_num_rows($res);

        if($count == 1){
            $data = mysqli_fetch_assoc($res);
            return json_encode($data);
        } else {
            return false;
        }
    }

    public function check_participant($g_id){
        if(@$_SESSION["access_token"]){
            global $apiURLBase;
            $user = apiRequest($apiURLBase);
            $id = $user->id;
            $g_id = mysqli_real_escape_string($this->db, $g_id);
            $sql = "SELECT g_participants FROM giveaway WHERE g_id = '{$g_id}';";
            $res = mysqli_query($this->db, $sql);
            $count = mysqli_num_rows($res);
            if($count == 1){
                $data = json_decode(mysqli_fetch_assoc($res)["g_participants"], true);
                foreach($data as $key => $member){
                    if((int) $member == (int) $id){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function check_giveaway($g_id){
        if(@$_SESSION["access_token"]){
            $g_id = mysqli_real_escape_string($this->db, $g_id);
            $sql = "SELECT g_id FROM giveaway WHERE g_id = '{$g_id}';";
            $res = mysqli_query($this->db, $sql);
            $count = mysqli_num_rows($res);
            if($count == 1){
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_participants($g_id){
        $sql = "SELECT * FROM participants WHERE g_id = '{$g_id}';";
        $res = mysqli_query($this->db, $sql);
        $count = mysqli_num_rows($res);
        if($count == 0){
            return 0;
        } else {
            return mysqli_fetch_assoc($res);
        }
    }

    public function createView($view){
        require_once $_SERVER["DOCUMENT_ROOT"] . "/views/" . $view . ".php";
    }
}
}



?>
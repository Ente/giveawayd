<?php
namespace GiveawayD{
    class api extends GiveawayD{

        private $gwd;

        public function __construct($gwd){
            $this->gwd = $gwd;
        }

        public function leaveGiveaway($id, $g_id){
            $g_id = mysqli_real_escape_string($this->gwd, $g_id);
            $sql = "SELECT * FROM giveaways WHERE id = '{$g_id}';";
            $res = mysqli_query($this->gwd, $sql);
            $count = mysqli_num_rows($res);
            if($count == 0){
                $data = array_flip(json_decode(mysqli_fetch_assoc($res)["g_participants"], true));
                if(!isset($data[$id])){
                    return false;
                } else {
                    unset($data[$id]);
                    $data = json_encode(array_flip($data));
                    $sql = "UPDATE giveaway SET g_participants = '{$data}' WHERE id = '{$g_id}';";
                    $res = mysqli_query($this->gwd, $sql);
                    if($res == false){
                        return false;
                    } else {
                        return true;
                    }
                }
                
            }
        }

        public function enterGiveaway($id, $g_id){
            $g_id = mysqli_real_escape_string($this->gwd, $g_id);
            if(GiveawayD::check_giveaway($g_id) == true){
                $name = GiveawayD::data($id)["name"];
                $sql = "INSERT INTO participants (g_id, name, user_id) VALUES ('{$g_id}', '{$name}', '{$id}');";
                $res = mysqli_query($this->gwd, $sql);
                if($res == true){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}



?>
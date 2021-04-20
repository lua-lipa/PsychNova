
<?php
include("./user.php");
class Login
{

    private $error = "";

    public function authenticateUser($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";

        $DB = new Database();
        $result = $DB->readOne($query);
        $userid = $result['user_id'];

        if ($result) {
            $banQuery = "SELECT * FROM banned_users WHERE user_id = '$userid';";
            $banned = $DB->readOne($banQuery);
            if($banned){
                $date = new DateTime($banned['date_of_unban']);
                $now = new DateTime();
                if($date < $now){
                    $_SESSION['userid'] = $result['user_id'];
                    $removeBan = "DELETE FROM banned_user WHERE user_id = '$userid'";
                    $unbanResult = $DB->save($removeBan);
                }else{
                    $unbanDate = $banned['date_of_unban'];
                    $this->error .= "You have been banned for violating our guidelines. You will be unbanned on $unbanDate";
                }
            }else{
                if ($password == $result['password']) {
                    $_SESSION['userid'] = $result['user_id'];
                } else {
                    $this->error .= "Incorrect password";
                }
            }
        } else {
            $this->error .= "Email not found";
        }

        return $this->error;
    }

}

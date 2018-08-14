<?php
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
class RegisterController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {   
        $this->view->sessUser = true;
    }

    public function registerAction()
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $validation = new Validation();
        $validation->add(
            'name',
            new PresenceOf(
                [
                    'message' => 'The name is required',
                ]
            )
        );
        $validation->add(
            'email',
            new Email(
                [
                    'message' => 'Email not valid',
                ]
            )
        );
        $validation->add(
            'password',
            new PresenceOf(
                [
                    'message' => 'The password is required',
                ]
            )
        );
        $arr = array(
            "name"=>$name,
            "email"=>$email,
            "password"=>$password
        );
        $messages = $validation->validate($arr);
        if (count($messages)) {
            /*foreach ($messages as $message) {
                echo $message, '<br>';
            }*/
            echo "Error";
        }
        else
        {
            $password = md5($password);
            $status = 0;
            $user = new User();
            $match = $user->validateUser($email);
            $this->view->disable();
            if($match)
            {
                echo "Error";
            }
            else
            {
                $index      = $user->countUser();
                $id         = "B".str_pad($index,5,'0',STR_PAD_LEFT);
                $user->insertUser($name,$email,$password,$status);
                $bio        = "";
                $image      = "userImage/user.jpg";
                $status     = "1";
                $profile    = new Userprofile();
                $profile->insertUserProfile($id,$name,$email,$bio,$image,$status);
                echo "Berhasil";
            }
        }
    }

}

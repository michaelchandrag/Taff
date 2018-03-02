<?php

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
            $user->insertUser($name,$email,$password,$user,$status);
            echo "Berhasill";
        }
    }

}


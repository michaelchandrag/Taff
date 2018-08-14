<?php

class LoginController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->sessUser = true;
    }

    public function loginAction()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password = md5($password);
        $remember = $_POST["remember"];
        $user = new User();
        $id = $user->doLogin($email,$password);
        $this->view->disable();
        if($id != null)
        {
            if($remember == "true")
            {
                $this->cookies->set(
                    "userId",
                    $id,
                    time() + 15 * 86400
                );
            }
            $this->session->set("userId", $id);
            echo "Berhasil";
        }
        else
        {
            echo "Error";
        }
    }

    public function logoutAction()
    {
        $this->view->disable();
        $id = $this->cookies->get("userId");
        // Delete the cookie
        $id->delete();
        $this->session->destroy();
        echo "Berhasil";
    }

    public function googleLoginAction()
    {
        $name       = $_POST["name"];
        $email      = $_POST["email"];
        $password   = $_POST["password"];
        $bio        = "";
        $image      = $_POST["image"];
        $password   = md5($password);
        $remember   = $_POST["remember"];
        $status     = "1";
        $user       = new User();
        $match      = $user->validateUser($email);
        $id         = "";
        $this->view->disable();
        if($match)
        {
            $id = $user->doLogin($email,$password);
        }
        else
        {
            $user->insertUser($name,$email,$password,$user,$status);
            $id = $user->doLogin($email,$password);
            $profile = new Userprofile();
            $profile->insertUserProfile($id,$name,$email,$bio,$image,$status);
        }
        $this->cookies->set(
            "userId",
            $id,
            time() + 15 * 86400
        );
        $this->session->set("userId", $id);
        echo "Berhasil";
    }

}


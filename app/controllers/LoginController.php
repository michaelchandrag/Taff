<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class LoginController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->sessUser = true;
    }

    public function loginAction()
    {
        $email = $this->request->getPost("email","email");
        $password = $this->request->getPost("password","string");
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
            $this->response->setContent("Berhasil");
            return $this->response->send();
        }
        else
        {
            $this->response->setContent("Error");
            return $this->response->send();
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
        $name       = $this->request->getPost("name");
        $email      = $this->request->getPost("email");
        $password   = $this->request->getPost("password");
        $bio        = "";
        $image      = $this->request->getPost("image");
        $password   = md5($password);
        $remember   = $this->request->getPost("remember");
        $status     = "1";
        $user       = new User();
        //$match      = $user->validateUser($email);
        $match = User::findFirst(
                [
                    "userEmail='".$email."'"    
                ]
            );
        $id         = "";
        $this->view->disable();
        if($match)
        {
            $id = $match->userId;
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
        $this->response->setContent("Berhasil");
        return $this->response->send();
    }

}


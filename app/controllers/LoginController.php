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

}


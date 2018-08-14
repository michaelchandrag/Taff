<?php

class AdmloginController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->sessUser = true;
    }

    public function loginAction()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $admin = Admin::findFirst(
            [
                "conditions"=>"adminEmail='".$email."' AND adminStatus='1'"
            ]
        );
        $response = "false";
        $this->view->disable();
        if($admin)
        {
            if($this->security->checkHash($password,$admin->adminPassword))
            {
                $response = "true";
                $this->session->set("adminId", $admin->adminId);
            }
            else
                $reponse = "false";
        }
        else
            $response = "false";
        return $response;

    }

    public function logoutAction()
    {
        $this->view->disable();
        $this->session->destroy();
    }

}


<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class AdmloginController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->sessUser = true;
    }

    public function loginAction()
    {
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
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
        $this->response->setContent($response);
        return $this->response->send();

    }

    public function logoutAction()
    {
        $this->view->disable();
        $this->session->destroy();
    }

}


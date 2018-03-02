<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
    	if($this->cookies->has(userId))
    	{
    		// Get the cookie
            $cookies = $this->cookies->get('userId');

            // Get the cookie's value
            $id = $cookies->getValue();

            $this->session->set("userId", $id);
            $this->response->redirect('home');
    	}
    	else
    	{
    		$this->response->redirect('login');
    	}
    }

}


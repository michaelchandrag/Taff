<?php

class TestController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	$this->view->user = Test::find();
    }

    public function registerAction()
    {
    	$user = new Test();
    	$user->name = "Chan YANG BARU";
    	$user->email = "chan@chan.com";
    	$user->save();
		// Store and check for errors
		/*$success = $user->save(
			$this->request->getPost(),
			array('name', 'email')
		);

		if ($success) {
			echo "Thanks for registering!";
		} else {
			echo "Sorry, the following problems were generated: ";
			foreach ($user->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}*/


		$this->view->disable();
    }

}


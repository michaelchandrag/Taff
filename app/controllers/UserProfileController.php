<?php

class UserProfileController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	$userId = "";
        if(isset($_GET["userId"]))
        {
            $userId = $_GET["userId"];
        }
       	$profile = Userprofile::findFirst(
       		[
       			"userId='".$userId."'"
       		]
       	);
       	$board = Board::find(
       		[
       			"boardOwner='".$userId."'"
       		]
       	);
       	$this->view->userProfile 	= $profile;
       	$this->view->userId 		= $userId;
       	$this->view->board 			= $board;
    }

    public function submitImageAction()
    {
        $this->view->disable();
        $userId = $_POST["userId"];
        $name = "userImage/".$userId.".jpg";
        if ( 0 < $_FILES['file1']['error'] ) 
        {
          echo 'Error: ' . $_FILES['file1']['error'] . '<br>';
        }
        else {
          $temp = explode(".", $_FILES["file1"]["name"]);
          move_uploaded_file($_FILES['file1']['tmp_name'], $name);
          echo $name;
        }
    }

}


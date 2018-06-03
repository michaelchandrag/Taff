<?php

class UserprofileController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	$userId = "";
        if(isset($_GET["userId"]))
        {
            $userId = $_GET["userId"];
        }
        $sess_userId = $this->session->get("userId");
        if($sess_userId == null || $userId == "")
        {
          $this->response->redirect("home");
        }
        $owner = "true";
        if($sess_userId == $userId)
          $owner = "true";
        else
          $owner = "false";
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
        $groupUser = Groupuser::find(
          [
            "groupStatus='1'"
          ]
        );
        $groupMember = Groupmember::find(
          [
            "userId='".$userId."'"
          ]
        );
        $user = Userprofile::findFirst(
          [
            "userId='".$sess_userId."'"
          ]
        );
        $this->view->user = $user;
        $this->view->groupMember = $groupMember;
        $this->view->groupUser = $groupUser;
       	$this->view->userProfile 	= $profile;
       	$this->view->userId 		= $userId;
       	$this->view->board 			= $board;
        $this->view->owner = $owner;
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

    public function changeDataAction()
    {
      $userId = $_POST["userId"];
      $userName = $_POST["userName"];
      $userBio = $_POST["userBio"];
      $userLocation = $_POST["userLocation"];
      $userGender = $_POST["userGender"];
      $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
      $profile->changeData($userId,$userName,$userBio,$userLocation,$userGender);
      $user = User::findFirst(
        [
          "userId='".$userId."'"
        ]
      );
      $user->setName($userId,$userName);
      $this->view->disable();
      echo "Berhasil";
    }

    public function changePasswordAction()
    {
      $userId = $_POST["userId"];
      $userPassword = $_POST["userPassword"];
      $userPassword = md5($userPassword);
      $user = User::findFirst(
        [
          "userId='".$userId."'"
        ]
      );
      $user->setPassword($userId,$userPassword);
      $this->view->disable();
      echo "Berhasil";
    }

}


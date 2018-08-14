<?php

class MuserController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $this->assets->addCss("js/plugins/data-tables/css/jquery.dataTables.min.css");
        $user = User::find();
        $this->view->user = $user;
        //<link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    }

    public function getUserByIdAction()
    {
        $userId = $_POST["userId"];
        $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($profile);
    }

    public function setUserByIdAction()
    {
        $userId = $_POST["userId"];
        $userName = $_POST["userName"];
        $userBio = $_POST["userBio"];
        $userLocation = $_POST["userLocation"];
        $userGender = $_POST["userGender"];
        $userStatus = $_POST["userStatus"];
        $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $profile->changeDataAdmin($userId,$userName,$userBio,$userLocation,$userGender,$userStatus);
        $user = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $user->setNameAdmin($userId,$userName,$userStatus);
        $this->view->disable();
        echo "Berhasil";
    }

    public function createUserAction()
    { 
        $userName = $_POST["userName"];
        $userEmail = $_POST["userEmail"];
        $userPassword = $_POST["userPassword"];
        $userPassword = md5($userPassword);
        $userStatus = 0;
        $user = new User();
        $match = $user->validateUser($userEmail);
        $this->view->disable();
        if($match)
        {
            echo "Error";
        }
        else
        {
            $index      = $user->countUser();
            $id         = "B".str_pad($index,5,'0',STR_PAD_LEFT);
            $user->insertUser($userName,$userEmail,$userPassword,$userStatus);
            $bio        = "";
            $image      = "userImage/user.jpg";
            $status     = "1";
            $profile    = new Userprofile();
            $profile->insertUserProfile($id,$userName,$userEmail,$bio,$image,$status);
            echo "Berhasil";
        }
    }

}


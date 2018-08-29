<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
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
        $userId = $this->request->getPost("userId");
        $userName = $this->request->getPost("userName");
        $userBio = $this->request->getPost("userBio");
        $userLocation = $this->request->getPost("userLocation");
        $userGender = $this->request->getPost("userGender");
        $userStatus = $this->request->getPost("userStatus");
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
        $user->userName = $userName;
        $user->userStatus = $userStatus;
        $user->save();
        $this->view->disable();
        $this->response->setContent("Berhasil");
        return $this->response->send();
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


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class GroupprofileController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $groupId = "";
        if(isset($_GET["id"]))
        {
            $groupId = $_GET["id"];
        }
        $sess_userId = $this->session->get("userId");
        if($sess_userId == null || $groupId == "")
        {
            $this->response->redirect("home");
        }
        $owner = "true";
        /*if($sess_userId == $userId)
          $owner = "true";
        else
          $owner = "false";*/
        $board = Board::find(
            [
                "condition" => "boardGroup='1' AND boardStatus='1' AND boardClosed ='0'"
            ]
        );
        $boardGroup = Boardgroup::find(
            [
                "groupId='".$groupId."'"
            ]
        );
        $groupUser = Groupuser::findFirst(
          [
            "groupId='".$groupId."'"
          ]
        );
        $groupMember = Groupmember::find(
          [
            "conditions" => "groupUserId='".$groupId."' and memberStatus='1'"
          ]
        );
        $user = Userprofile::findFirst(
          [
            "userId='".$sess_userId."'"
          ]
        );
        $owner = "false";
        $role = "";
        foreach($groupMember as $gm)
        {
            if($gm->userId == $sess_userId && $sess_userId != null)
            {
                if($gm->memberRole == "Admin")
                {
                    $owner = "true";
                    $role = $gm->memberRole;
                }
                else if($gm->memberRole = "Member")
                {
                    $owner = "true";
                    $role = $gm->memberRole;
                }
            }
        }
        $listUser = User::find(
            [
                "userStatus='1'"
            ]
        );
        $listUserProfile = Userprofile::find(
            [
                "userStatus='1'"
            ]
        );
        $this->view->role = $role;
        $this->view->owner = $owner;
        $this->view->groupUser = $groupUser;
        $this->view->user = $user;
        $this->view->listUser = $listUser;
        $this->view->listUserProfile = $listUserProfile;
        $this->view->board          = $board;
        $this->view->boardGroup = $boardGroup;
        $this->view->groupMember = $groupMember;
        //$this->view->owner = $owner;
    }

    public function changeDataAction()
    {
        $groupId = $this->request->getPost("groupId");
        $groupName = $this->request->getPost("groupName");
        $groupDescription = $this->request->getPost("groupDescription");
        $groupWebsite = $this->request->getPost("groupWebsite");
        $groupLocation = $this->request->getPost("groupLocation");
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $group->changeData($groupId,$groupName,$groupDescription,$groupWebsite,$groupLocation);
        $this->view->disable();
        $this->response->setContent("Berhasil");
        return $this->response->send();
    }

    public function submitImageAction()
    {
        $this->view->disable();
        $groupId = $this->request->getPost("groupId");
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $name = "groupImage/".$groupId.".jpg";
        $group->groupImage = $name;
        $group->save();
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

    public function leaveGroupAction()
    {
        $sess_userId = $this->session->get("userId");
        $groupId = $this->request->getPost("groupId");
        $groupMember = Groupmember::findFirst(
            [
                "conditions" => "groupUserId='".$groupId."' and userId='".$sess_userId."'"
            ]
        );
        $groupMember->leaveGroup($groupId,$sess_userId);
        $this->view->disable();
        $this->response->setContent("Berhasil");
        return $this->response->send();
    }

    public function deleteGroupAction()
    {
        $groupId = $this->request->getPost("groupId");
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $group->groupStatus = "0";
        $group->save();
        $this->view->disable();
        $this->response->setContent("Berhasil");
        return $this->response->send();
    }

    public function createInviteAction()
    {
        $groupId = $_POST["groupId"];
        $email = $_POST["email"];
        $this->view->disable();
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        //$mail->SMTPDebug = 1;
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->Host     = 'silver.hidden-server.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'admin@taff.top';                 // SMTP username
        $mail->Password = 'Cancan110796';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port     = 465;
        
        $mail->setFrom('admin@taff.top', 'Taff');
        $mail->addAddress($email);
        $mail->Subject = 'Invitation from Taff.top';
        $mail->isHTML(true);
        $mail->Body = 'You have been invited to a group in taff.top<br>
                        to join the group click <a href="http://www.taff.top/invite/getInviteGroup/'.$groupId.'">here</a> or the link below<br><br>
                        http://www.taff.top/invite/getInviteGroup/'.$groupId;
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function updateMemberRoleAction()
    {
        $groupId = $_POST["groupId"];
        $userId = $_POST["userId"];
        $role = $_POST["role"];
        $gm = Groupmember::findFirst(
            [
                "conditions" => "groupUserId='".$groupId."' AND userId='".$userId."'"
            ]
        );
        $gm->memberRole = $role;
        $gm->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function getGroupMemberAction()
    {
        $groupId = $_POST["groupId"];
        $gm = array();
        $gm = Groupmember::find(
            [
                "conditions" => "groupUserId='".$groupId."' AND memberStatus='1'"
            ]
        );
        $datas = array();
        foreach($gm as $g)
        {
            $user = Userprofile::findFirst(
                [
                    "conditions"=>"userId='".$g->userId."'"        
                ]
            );
            $userId = $user->userId;
            $userName = $user->userName;
            $userImage = $user->userImage;
            $array = array(
                "memberId"=>$g->memberId,
                "memberRole"=>$g->memberRole,
                "userId"=>$userId,
                "userName"=>$userName,
                "userImage"=>$userImage
            );
            array_push($datas,$array);
        }
        $this->view->disable();
        echo json_encode($datas);
    }

    public function removeMemberAction()
    {
        $groupId = $_POST["groupId"];
        $userId = $_POST["userId"];
        $gm = Groupmember::findFirst(
            [
                "conditions" => "groupUserId='".$groupId."' AND userId='".$userId."'"
            ]
        );
        $gm->memberStatus ='0';
        $gm->save();
        $this->view->disable();
        echo "Berhasil";
    }

}


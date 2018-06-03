<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
        //$this->view->groupMember = $groupMember;
        //$this->view->groupUser = $groupUser;
        //$this->view->userProfile    = $profile;
        //$this->view->userId         = $userId;
        $this->view->board          = $board;
        $this->view->boardGroup = $boardGroup;
        $this->view->groupMember = $groupMember;
        //$this->view->owner = $owner;
    }

    public function changeDataAction()
    {
        $groupId = $_POST["groupId"];
        $groupName = $_POST["groupName"];
        $groupDescription = $_POST["groupDescription"];
        $groupWebsite = $_POST["groupWebsite"];
        $groupLocation = $_POST["groupLocation"];
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $group->changeData($groupId,$groupName,$groupDescription,$groupWebsite,$groupLocation);
        $this->view->disable();
        echo "Berhasil";
    }

    public function submitImageAction()
    {
        $this->view->disable();
        $groupId = $_POST["groupId"];
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
        $groupId = $_POST["groupId"];
        $groupMember = Groupmember::findFirst(
            [
                "conditions" => "groupUserId='".$groupId."' and userId='".$sess_userId."'"
            ]
        );
        $groupMember->leaveGroup($groupId,$sess_userId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteGroupAction()
    {
        $groupId = $_POST["groupId"];
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $group->deleteGroup($groupId);
        $this->view->disable();
        echo "Berhasil";
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

        $mail->Host     = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'canzinzzide@gmail.com';                 // SMTP username
        $mail->Password = 'cancan110796';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port     = 587;
        
        $mail->setFrom('canzinzzide@gmail.com', 'Michael Chandra');
        $mail->addReplyTo('michaelchandrag114@yahoo.co.id', 'gg');
        $mail->addAddress($email);
        $mail->Subject = 'Invitation from Taff.top';
        $mail->isHTML(true);
        $mail->Body = 'You have been invited to a group in taff.top<br>
                        to join the group click the link below<br>
                        localhost/trello/invite/getInviteGroup/'.$groupId;
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
        $this->view->disable();
        echo json_encode($gm);
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


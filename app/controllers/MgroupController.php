<?php

class MgroupController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $this->assets->addCss("js/plugins/data-tables/css/jquery.dataTables.min.css");
        $group = Groupuser::find();
        $user = User::find();
        $this->view->group = $group;
        $this->view->user = $user;
    }

    public function getGroupByIdAction()
    {
        $groupId = $_POST["groupId"];
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($group);
    }

    public function setGroupByIdAction()
    {
        $groupId = $_POST["groupId"];
        $groupName = $_POST["groupName"];
        $groupDescription = $_POST["groupDescription"];
        $groupWebsite = $_POST["groupWebsite"];
        $groupLocation = $_POST["groupLocation"];
        $groupStatus = $_POST["groupStatus"];
        $group = Groupuser::findFirst(
            [
                "groupId='".$groupId."'"
            ]
        );
        $group->changeDataAdmin($groupId,$groupName,$groupDescription,$groupWebsite,$groupLocation,$groupStatus);
        $this->view->disable();
        echo "Berhasil";
    }

    public function createGroupAction()
    {
        $name = $_POST["groupName"];
        $status = "1";
        $userId = $_POST["userId"];
        $groupUser = new Groupuser();
        $index = $groupUser->countGroup();
        $groupId = "GU".str_pad($index,5,'0',STR_PAD_LEFT);
        $groupUser->insertGroupUser($name,$status);

        $groupMember = new Groupmember();
        $role = "Admin";
        $groupMember->insertGroupMember($userId,$groupId,$role,$status);
        $this->view->disable();

        echo $groupId;
    }

    public function getMemberByGroupIdAction()
    {
        $groupId = $_POST["groupId"];
        $member = Groupmember::find(
            [
                "groupUserId='".$groupId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($member);
    }

    public function insertMemberAction()
    {
        $groupId = $_POST["groupId"];
        $userId = $_POST["userId"];
        $match = Groupmember::findFirst(
            [
                "conditions" => "groupUserId='".$groupId."' AND userId='".$userId."'"
            ]
        );
        if($match == null)
        {
            $userId = (string)$userId;
            $gm = new Groupmember();
            $role = "Member";
            $status = "1";
            $gm->insertGroupMember($userId,$groupId,$role,$status);
            $this->response->redirect("home");
        }
        else
        {
            
            $match->memberStatus = '1';
            $match->save();
        }
        echo "Berhasil";
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


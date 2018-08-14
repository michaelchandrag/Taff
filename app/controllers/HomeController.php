<?php

class HomeController extends ControllerBase
{

    public function indexAction()
    {
        $userId = $this->session->get("userId");
        $find  = null;
        if(isset($_GET["find"]))
        {
            $find = $_GET["find"];
        }
        if($userId == null)
        {
            $this->response->redirect("login");
        }
        $inviteBoardId = $this->session->get("inviteBoardId");
        if($inviteBoardId != null)
        {
            $match = Boardmember::findFirst(
                [
                    "conditions" => "boardId='".$inviteBoardId."' AND userId='".$userId."'"
                ]
            );
            if($match == null)
            {
                $bm = new Boardmember();
                $role = $this->session->get("inviteRoleMember");
                $status = "1";
                $bm->insertBoardMember($userId,$inviteBoardId,$role,$status);
            }
            else
            {
                $match->memberStatus = '1';
                $match->save();
            }
            $this->session->remove("inviteBoardId");
            $this->session->remove("inviteRoleMember");
        }
        $inviteGroupId = $this->session->get("inviteGroupId");
        if($inviteGroupId != null)
        {
            $match = Groupmember::findFirst(
                [
                    "conditions" => "groupUserId='".$inviteGroupId."' AND userId='".$userId."'"
                ]
            );
            if($match == null)
            {
                $gm = new Groupmember();
                $role = "Member";
                $status = "1";
                $gm->insertGroupMember($userId,$inviteGroupId,$role,$status);
                $this->response->redirect("home");
            }
            else
            {
                $match->memberStatus = '1';
                $match->save();
                $this->response->redirect("home");
            }
            $this->session->remove("inviteGroupId");
        }
        $board = Board::find(
            [
                "conditions" => "boardClosed='0' AND boardStatus ='1'"
            ]
        );
        if($find != null)
        {
            $board = Board::find(
                [
                    "conditions" => "boardTitle like '%".$find."%'"
                ]
            );
        }
        $groupMember = new Groupmember();
        $groupMember = $groupMember->findGroup($userId);
        $groupUser = Groupuser::find(
            [
                "groupStatus='1'"
            ]
        );
        $boardGroup = Boardgroup::find();
        $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $favorite = Boardfavorite::find(
            [
                "userId='".$userId."'"
            ]
        );
        $boardMember = Boardmember::find(
            [
                "userId='".$userId."'"
            ]
        );
        $this->view->boardMember       = $boardMember;
        $this->view->userProfile       = $profile;
        $this->view->board             = $board;
        $this->view->userId            = $userId;
        $this->view->groupMember       = $groupMember;
        $this->view->groupUser         = $groupUser;
        $this->view->boardGroup        = $boardGroup;
        $this->view->boardFavorite     = $favorite;
    }

    public function createBoardAction()
    {
        $title = $_POST["title"];
        $owner = $_POST["owner"];
        $public = "1";
        $status = '1';
        $background = "blue";
        $group = "0";
        $userId = $this->session->get("userId");
        if(substr($owner,0,1) == "B")
        {
            $group = "0";
        }
        else if(substr($owner,0,1) == "G")
        {
            $group = "1";
        }
        $board = new Board();
        $index = $board->countBoard();
        $id = "BO".str_pad($index,5,'0',STR_PAD_LEFT);
        $board->insertBoard($userId,$title,$public,$group,$status,$background);
        if($group == "1")
        {
            $boardGroup = new Boardgroup();
            $boardGroup->insertBoardGroup($id,$owner,$title,$status);
            $groupMember = Groupmember::find(
                [
                    "groupUserId='".$owner."' AND memberStatus='1'"
                ]
            );
            foreach($groupMember as $g)
            {
                $role = "Creator";
                /*if($g->userId == $userId)
                {
                    $role = "Creator";
                }
                else
                {
                    $role = "Collaborator";
                }*/
                $boardMember = new Boardmember();
                $boardMember->insertBoardMember($g->userId,$id,$role,$status);
            }
            //role collaborator dan client
            $listCreate = "0";
            $listEdit = "0";
            $listDelete = "0";
            $cardCreate = "0";
            $cardEdit = "0";
            $cardDelete = "0";
            $activityAM = "0";
            $activityLabel = "0";
            $activityChecklist = "0";
            $activityStartDate = "0";
            $activityDueDate = "0";
            $activityAttachment = "0";
            $roleStatus = "0";
            $coll = new Boardrolecollaborator();
            $coll->insertBoardRoleCollaborator($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,"1","1","1","1","1","1","1");

            $client = new Boardroleclient();
            $client->insertBoardRoleClient($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus);
        }
        else
        {
            $role="Creator";
            $boardMember = new Boardmember();
            $boardMember->insertBoardMember($userId,$id,$role,$status);
            //role collaborator dan client
            $listCreate = "0";
            $listEdit = "0";
            $listDelete = "0";
            $cardCreate = "0";
            $cardEdit = "0";
            $cardDelete = "0";
            $activityAM = "0";
            $activityLabel = "0";
            $activityChecklist = "0";
            $activityStartDate = "0";
            $activityDueDate = "0";
            $activityAttachment = "0";
            $roleStatus = "0";
            $coll = new Boardrolecollaborator();
            $coll->insertBoardRoleCollaborator($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,"1","1","1","1","1","1","1");

            $client = new Boardroleclient();
            $client->insertBoardRoleClient($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus);
        }
        $this->view->disable();
        echo $id;
    }

    public function createGroupAction()
    {
        $name = $_POST["name"];
        $status = "1";
        $userId = $this->session->get("userId");
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

    public function getClosedBoardAction()
    {
        $userId = $this->session->get("userId");
        $board = Board::find(
            [
                "boardOwner='".$userId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($board);
    }

    public function setClosedBoardAction()
    {
        $boardId = $_POST["boardId"];
        $status = $_POST["status"];
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $title = $board->boardTitle;
        $board->boardClosed = $status;
        $board->save();
        $this->view->disable();
        echo $title;
    }

    public function setStatusBoardAction()
    {
        $boardId = $_POST["boardId"];
        $status = $_POST["status"];
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $title = $board->boardTitle;
        $board->boardStatus = $status;
        $board->save();
        $this->view->disable();
        echo "Berhasil";
    }


}

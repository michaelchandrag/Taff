<?php

class HomeController extends ControllerBase
{

    public function indexAction()
    {
    	$userId = $this->session->get("userId");
    	$board = Board::find();
    	$groupMember = new Groupmember();
    	$groupMember = $groupMember->findGroup($userId);
    	$groupUser = Groupuser::find();
    	$boardGroup = Boardgroup::find();
    	$this->view->board = $board;
    	$this->view->userId = $userId;
    	$this->view->groupMember = $groupMember;
    	$this->view->groupUser = $groupUser;
    	$this->view->boardGroup = $boardGroup;
    }

    public function createBoardAction()
    {
    	$title = $_POST["title"];
    	$owner = $_POST["owner"];
    	$public = "1";
    	$status = '1';
    	$background = "Blue";
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
                    "groupUserId='".$owner."'"
                ]
            );
            foreach($groupMember as $g)
            {
                $role = "Creator";
                if($g->userId == $userId)
                {
                    $role = "Creator";
                }
                else
                {
                    $role = "Collaborator";
                }
                $boardMember = new Boardmember();
                $boardMember->insertBoardMember($g->userId,$id,$role,$status);
            }
        }
        else
        {
            $role="Creator";
            $boardMember = new Boardmember();
            $boardMember->insertBoardMember($userId,$id,$role,$status);
        }
    	$this->view->disable();
    	echo "Berhasil";
    }

    public function createGroupAction()
    {
    	$name = $_POST["name"];
    	$status = 1;
    	$userId = $this->session->get("userId");
    	$groupUser = new Groupuser();
    	$index = $groupUser->countGroup();
        $groupId = "GU".str_pad($index,3,'0',STR_PAD_LEFT);
    	$groupUser->insertGroupUser($name,$status);

    	$groupMember = new Groupmember();
    	$role = "Admin";
    	$groupMember->insertGroupMember($userId,$groupId,$role,$status);
    	$this->view->disable();

    	echo "Berhasil";
    }


}

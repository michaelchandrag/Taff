<?php

class HomeController extends ControllerBase
{

    public function indexAction()
    {
    	$userId = $this->session->get("userId");
    	$board = new Board();
    	$listBoardUser = $board->findBoardByUser($userId);
    	$groupMember = new Groupmember();
    	$groupMember = $groupMember->findGroup($userId);
    	$groupUser = Groupuser::find();
    	$groupBoard = Groupboard::find();
    	$this->view->listBoardUser = $listBoardUser;
    	$this->view->userId = $userId;
    	$this->view->groupMember = $groupMember;
    	$this->view->groupUser = $groupUser;
    	$this->view->groupBoard = $groupBoard;
    }

    public function createBoardAction()
    {
    	$title = $_POST["title"];
    	$owner = $_POST["owner"];
    	$public = 1;
    	$status = 1;
    	$background = "Blue";
    	$userId = $this->session->get("userId");
    	/*$boardUser = new Boarduser();
    	$boardUser->insertBoardUser($userId,$title,$public,$status);*/
    	if(substr($owner,0,1) == 'B')
    	{
    		$board = new Board();
    		$index = $board->countBoard();
       		$id = "BO".str_pad($index,3,'0',STR_PAD_LEFT);
    		$board->insertBoard($owner,$title,$public,$status,$background);

    		$role="Creator";
    		$boardMember = new Boardmember();
    		$boardMember->insertBoardMember($userId,$id,$role,$status);
    	}
    	else if(substr($owner,0,1) == "G")
    	{
    		$board = new Groupboard();
    		$index = $board->countBoard();
       		$id = "GB".str_pad($index,3,'0',STR_PAD_LEFT);
    		$board->insertGroupBoard($owner,$title,$public,$status,$background);

    		$role="Creator";
    		$boardMember = new Groupboardmember();
    		$boardMember->insertGroupBoardMember($userId,$id,$role,$status);
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

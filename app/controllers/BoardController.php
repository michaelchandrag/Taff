<?php

class BoardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	$boardId = $_GET["id"];
    	$board = "";
    	$boardList = "";
    	$boardCard = "";
    	if(substr($boardId,0,2) == "BO")
    	{
    		$board = Board::find(
	    		[
	    			"boardId='".$boardId."'"
	    		]
    		);
    		$boardList = Boardlist::find(
	    		[
	    			"listBoardId='".$boardId."'"
	    		]
    		);
    		$boardCard = Boardcard::find();
    	}
    	else if(substr($boardId,0,2) == "GB")
    	{
	    	$board = Groupboard::find(
	    		[
	    			"boardId='".$boardId."'"
	    		]
	    	);
	    	$boardList = Groupboardlist::find(
	    		[
	    			"listBoardId='".$boardId."'"
	    		]
	    	);
	    	$boardCard = Groupboardcard::find();
    	}
    	$this->view->board = $board;
    	$this->view->boardList = $boardList;
    	$this->view->boardCard = $boardCard;
    }

    public function createListAction()
    {
    	$title = $_POST["title"];
    	$owner = $_POST["owner"];
    	$archive = "0";
    	$status = "1";
    	if(substr($owner,0,2) == "BO")
    	{
    		$list = new Boardlist();
    		$list->insertBoardList($owner,$title,$archive,$status);
    	}
    	else if(substr($owner,0,2) == "GB")
    	{
    		$list = new Groupboardlist();
    		$list->insertBoardList($owner,$title,$archive,$status);
    	}
    	$this->view->disable();
    	echo "Berhasil";
    }

    public function createCardAction()
    {
    	$title = $_POST["title"];
    	$listId = $_POST["owner"];
    	$owner = $this->session->get("userId");
    	$description = "null";
    	$archive = "0";
    	$status = "1";
    	if(substr($listId,0,2) == "BL")
    	{
    		$card = new Boardcard();
    		$card->insertBoardCard($listId,$owner,$title,$description,$archive,$status);
    	}
    	else if(substr($listId,0,2) == "GL")
    	{
    		$card = new Groupboardcard();
    		$card->insertGroupBoardCard($listId,$owner,$title,$description,$archive,$status);
    	}
    	$this->view->disable();
    	echo "Berhasil";

    }

    public function getBoardCardAction()
    {
    	$cardId = $_POST["id"];
    	$cardTitle = "";
    	$cardDescription = "";
    	$listTitle = "";
    	$data = array();
    	if(substr($cardId,0,2) == "BC")
    	{	
    		$card = Boardcard::findFirst(
    			[
    				"cardId='".$cardId."'"
    			]
    		);
    		$list = Boardlist::findFirst(
    			[
    				"listId='".$card->cardListId."'"
    			]
    		);
    		$cardTitle			= $card->cardTitle;
    		$cardDescription 	= $card->cardDescription;
    		$listTitle 			= $list->listTitle;
    		$data = array(
    			'cardId'			=> $cardId, 
    			'cardTitle'			=> $cardTitle,
    			'cardDescription'	=> $cardDescription,
    			'listTitle'			=> $listTitle
    		);
    	}
    	$datas[] = $data;
    	$this->view->disable();
    	echo json_encode($datas);
    }

}


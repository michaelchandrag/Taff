<?php

class CalendarController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	$userId = $this->session->get("userId");
        if($userId == null)
        {
            $this->response->redirect("login");
        }
        $boardId = "";
        if(isset($_GET["id"]))
        {
            $boardId = $_GET["id"];
        }
        $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $this->view->boardId = $boardId;
        $this->view->userProfile       = $profile;
    }

    public function getListAction()
    {
    	$boardId = $_POST["boardId"];
    	$list = Boardlist::find(
    		[
    			"listBoardId='".$boardId."'"
    		]
    	);
    	$this->view->disable();
    	echo json_encode($list);
    }

    public function getCardAction()
    {
    	$listId = $_POST["listId"];
    	$card = Boardcard::find(
    		[
    			"cardListId='".$listId."'"
    		]
    	);
    	$this->view->disable();
    	echo json_encode($card);
    }

    public function getStartDateAction()
    {
    	$cardId = $_POST["cardId"];
    	$date = "";
        $id = "";
    	$card = Boardstartdate::findFirst(
    		[
    			"cardId='".$cardId."'"
    		]
    	);
    	if($card != null)
    	{
            if($card->startDateStatus == "1")
            {
                $date = $card->startDate;
                $id = $card->startDateId;
                $date = $date." ".$id;
            }
    	}
    	$this->view->disable();
    	echo $date;
    }

    public function getDueDateAction()
    {
    	$cardId = $_POST["cardId"];
    	$date = "";
        $id = "";
    	$card = Boardduedate::findFirst(
    		[
    			"cardId='".$cardId."'"
    		]
    	);
    	if($card != null)
    	{
            if($card->dueDateStatus == "1")
            {
                $date = $card->dueDate;
                $id= $card->dueDateId;
                $date = $date." ".$id; 
            }
    	}
    	$this->view->disable();
    	echo $date;
    }

}


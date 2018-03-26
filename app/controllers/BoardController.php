<?php

class BoardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $boardId = "";
        if(isset($_GET["id"]))
        {
            $boardId = $_GET["id"];
        }
    	$board = "";
    	$boardList = "";
    	$boardCard = "";
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
        $boardCard = Boardcard::find(
            [
                "cardBoardId='".$boardId."'"
            ]
        );
        $boardLabelCard = Boardlabelcard::find(
            [
                "boardId='".$boardId."'"
            ]
        );
    	$this->view->board = $board;
        $this->view->boardLabelCard = $boardLabelCard;
    	$this->view->boardList = $boardList;
    	$this->view->boardCard = $boardCard;
    }

    public function createListAction()
    {
    	$title = $_POST["title"];
    	$owner = $_POST["owner"];
    	$archive = "0";
    	$status = "1";
        $list = new Boardlist();
        $list->insertBoardList($owner,$title,$archive,$status);
    	$this->view->disable();
    	echo "Berhasil";
    }

    public function createCardAction()
    {
    	$title = $_POST["title"];
    	$listId = $_POST["owner"];
        $boardId = "";
        if(isset($_GET["id"]))
        {
            $boardId = $_GET["id"];
        }
    	$owner = $this->session->get("userId");
    	$description = "null";
    	$archive = "0";
    	$status = "1";

        //cardId
        $card = new Boardcard();
        $index = $card->countCard();
        $cardId = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
        //listId = $listId

        //boardId
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $boardId = $list->listBoardId;
        //..
        //create card
        $card->insertBoardCard($listId,$boardId,$owner,$title,$description,$archive,$status);
        //create assign members
        $member = Boardmember::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        foreach($member as $r)
        {
            $userId = $r->userId;
            $user = User::findFirst(
                [
                    "userId='".$r->userId."'"
                ]
            );
            $userName = $user->userName;
            $assign = new Boardassignmembers();
            $assign->insertBoardAssignMembers($cardId,$userId,$userName,$status);
        }
    	$this->view->disable();
		echo $cardId;

    }

    public function updateCardTitleAction()
    {
        $id = $_POST["cardId"];
        $title = $_POST["cardTitle"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]);
        $card->setTitle($id,$title);
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
        $cardTitle          = $card->cardTitle;
        $cardDescription    = $card->cardDescription;
        $listTitle          = $list->listTitle;
        $data = array(
            'cardId'            => $cardId, 
            'cardTitle'         => $cardTitle,
            'cardDescription'   => $cardDescription,
            'listTitle'         => $listTitle
        );
    	$datas[] = $data;
    	$this->view->disable();
    	echo json_encode($datas);
    }

    public function getBoardAssignMembersAction()
    {
    	$cardId = $_POST["id"];
    	$assign = array();
        $assign = Boardassignmembers::find(
                [
                    "cardId='".$cardId."'"
                ]
            );
    	$this->view->disable();	
    	echo json_encode($assign);
    }

    public function setStartDateAction()
    {
    	$cardId = $_POST["id"];
    	$status = "1";
    	$date = $_POST["date"]; // 7 March, 2018
    	$pecah = explode(" ",$date);
    	$tgl = $pecah[0];
    	$bln = substr($pecah[1],0,strlen($pecah[1])-1);
    	if($bln == "January")
    	{
    		$bln = "1";
    	}
    	else if($bln == "February")
    	{
    		$bln = "2";
    	}
    	else if($bln == "March")
    	{
    		$bln = "3";
    	}
    	else if($bln == "April")
    	{
    		$bln = "4";
    	}
    	else if($bln == "May")
    	{
    		$bln = "5";
    	}
    	else if($bln == "June")
    	{
    		$bln = "6";
    	}
    	else if($bln == "July")
    	{
    		$bln = "7";
    	}
    	else if($bln == "August")
    	{
    		$bln = "8";
    	}
    	else if($bln == "September")
    	{
    		$bln = "9";
    	}
    	else if($bln == "October")
    	{
    		$bln = "10";
    	}
    	else if($bln == "November")
    	{
    		$bln = "11";
    	}
    	else if($bln == "December")
    	{
    		$bln = "12";
    	}
    	$thn = substr($pecah[2],2,2);

    	$time = $_POST["time"];
    	$d=mktime($time, 00, 00, $bln, $tgl, $thn);
        $date = new Boardstartdate();
        $date->insertBoardStartDate($cardId,$d,$status);

    	$this->view->disable();
    	echo "Berhasil";

    }

    public function getStartDateAction()
    {
    	$cardId = $_POST["id"];
    	$startDate = array();
        $startDate = Boardstartdate::find(
            [
                "cardId='".$cardId."'"
            ]
        );


    	$this->view->disable();
    	echo json_encode($startDate);

    }

    public function setDueDateAction()
    {
        $cardId = $_POST["id"];
        $status = "1";
        $date = $_POST["date"]; // 7 March, 2018
        $pecah = explode(" ",$date);
        $tgl = $pecah[0];
        $bln = substr($pecah[1],0,strlen($pecah[1])-1);
        if($bln == "January")
        {
            $bln = "1";
        }
        else if($bln == "February")
        {
            $bln = "2";
        }
        else if($bln == "March")
        {
            $bln = "3";
        }
        else if($bln == "April")
        {
            $bln = "4";
        }
        else if($bln == "May")
        {
            $bln = "5";
        }
        else if($bln == "June")
        {
            $bln = "6";
        }
        else if($bln == "July")
        {
            $bln = "7";
        }
        else if($bln == "August")
        {
            $bln = "8";
        }
        else if($bln == "September")
        {
            $bln = "9";
        }
        else if($bln == "October")
        {
            $bln = "10";
        }
        else if($bln == "November")
        {
            $bln = "11";
        }
        else if($bln == "December")
        {
            $bln = "12";
        }
        $thn = substr($pecah[2],2,2);

        $time = $_POST["time"];
        $d=mktime($time, 00, 00, $bln, $tgl, $thn);
        $date = new Boardduedate();
        $date->insertBoardDueDate($cardId,$d,$status);

        $this->view->disable();
        echo "Berhasil";

    }

    public function getDueDateAction()
    {
        $cardId = $_POST["id"];
        $dueDate = array();
        $dueDate = Boardduedate::find(
            [
                "cardId='".$cardId."'"
            ]
        );

        $this->view->disable();
        echo json_encode($dueDate);

    }

    public function createChecklistAction()
    {
        $cardId = $_POST["id"];
        $title = $_POST["title"];
        $status = "1";
        $checklist = new Boardchecklist();
        $index = $checklist->countChecklist();
        $id = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
        $checklist->insertBoardChecklist($cardId,$title,$status);
        $this->view->disable();
        echo $id;
    }

    public function getChecklistAction()
    {
        $cardId = $_POST["id"];
        $checklist = array();
        $checklist = Boardchecklist::find(
            [
                "cardId='".$cardId."'"
            ]
        );


        $this->view->disable();
        echo json_encode($checklist);

    }

    public function createChecklistItemAction()
    {
        $checklistId = $_POST["checklistId"];
        $cardId = $_POST["id"];
        $title = $_POST["title"];
        $status = "0";
        $checklist = new Boardchecklistitem();
        $index = $checklist->countChecklistItem();
        $id = "BCI".str_pad($index,5,'0',STR_PAD_LEFT);
        $checklist->insertBoardChecklistItem($checklistId,$cardId,$title,$status);
        $this->view->disable();
        echo $id;

    }

    public function getChecklistItemAction()
    {
        $checklistId = $_POST["id"];
        $item = array();
        $item = Boardchecklistitem::find(
            [
                "checklistId='".$checklistId."'"
            ]
        );


        $this->view->disable();
        echo json_encode($item);

    }

    public function setCardArchiveAction()
    {
        $id = $_POST["id"];
        $status = $_POST["status"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]);
        $card->setArchive($id,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getCardArchiveAction()
    {
        $status = "1";
        $card = array();
        $card = Boardcard::find(
            [
                "cardArchive='".$status."'"

            ]);
        $this->view->disable();
        echo json_encode($card);
    }

    public function createCommentAction()
    {
        $boardId = $_POST["boardId"];
        $cardId = $_POST["cardId"];
        $text = $_POST["text"];
        $userId = $this->session->get("userId");
        $status = "1";
        $comment = new Boardcomment();
        $index = $comment->countComment();
        $id = "BUC".str_pad($index,5,'0',STR_PAD_LEFT);
        $comment->insertBoardComment($cardId,$boardId,$userId,$text,$status);

        $this->view->disable();
        echo $id;
    }

    public function getCommentAction()
    {
        $cardId = $_POST["id"];
        $comment = array();
        $comment = Boardcomment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($comment);

    }

    public function createReplyCommentAction()
    {
        $commentId  = $_POST["commentId"];
        $boardId    = $_POST["boardId"];
        $cardId     = $_POST["cardId"];
        $text       = $_POST["text"];
        $userId     = $this->session->get("userId");
        $status     = "1";
        $reply      = new Boardreplycomment();
        $reply->insertBoardReplyComment($commentId,$cardId,$boardId,$userId,$text,$status);

        $this->view->disable();
        echo $text;
    }

    public function getReplyCommentAction()
    {
        $commentId = $_POST["commentId"];
        $reply = array();
        $reply = Boardreplycomment::find(
            [
                "commentId='".$commentId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($reply);
    }

    public function createChatAction()
    {
        $boardId = $_POST["boardId"];
        $chatText = $_POST["chatText"];
        $userId = $this->session->get("userId");
        $status = "1";
        $chat = new Boardchat();
        $chat->insertBoardChat($boardId,$userId,$chatText,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getChatAction()
    {
        $boardId = $_POST["boardId"];
        $chat = array();
        $chat = Boardchat::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($chat);
    }

    public function createLabelCardAction()
    {
        $boardId    = $_POST["boardId"];
        $cardId     = $_POST["cardId"];
        $red        = $_POST["red"];
        $yellow     = $_POST["yellow"];
        $green      = $_POST["green"];
        $blue       = $_POST["blue"];
        $status     = "1";
        $label = new Boardlabelcard();
        $label->insertBoardLabelCard($boardId,$cardId,$red,$yellow,$green,$blue,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getlabelCardAction()
    {
        $cardId = $_POST["id"];
        $label = array();
        $label = Boardlabelcard::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($label);
    }


}


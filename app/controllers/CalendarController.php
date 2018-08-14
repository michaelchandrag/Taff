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
        if($userId == null || $boardId == "")
        {
            $this->response->redirect("board");
        }
        $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $this->assets->addCss("js/plugins/fullcalendar/css/fullcalendar.min.css");
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

    public function getAllAction()
    {
        $boardId = $_POST["boardId"];
        $list = Boardlist::find(
            [
                "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'"
            ]
        );
        $datas = array();
        foreach($list as $list)
        {
            $card = Boardcard::find(
                [
                    "conditions"=>"cardListId='".$list->listId."' AND cardArchive='0' AND cardStatus='1'"
                ]
            );
            foreach($card as $card)
            {
                $cardTitle = $card->cardTitle;
                $startDate = "";
                $dueDate = "";
                $start = Boardstartdate::findFirst(
                    [
                        "conditions"=>"cardId='".$card->cardId."' AND startDateStatus='1'"
                    ]
                );
                if($start != null)
                {
                    $startDate = $start->startDate;
                }
                $due = Boardduedate::findFirst(
                    [
                        "conditions"=>"cardId='".$card->cardId."' AND dueDateStatus='1'"
                    ]
                );
                if($due != null)
                {
                    $dueDate = $due->dueDate;
                }
                if($startDate != "" || $dueDate != "")
                {
                    $arr = array(
                        "cardTitle"=>$cardTitle,
                        "startDate"=>$startDate,
                        "dueDate"=>$dueDate
                    );
                    array_push($datas,$arr);
                }
            }
        }
        $this->view->disable();
        echo json_encode($datas);
    }

}


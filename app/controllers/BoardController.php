<?php

require_once __DIR__ . '/../../vendor/autoload.php';
class BoardController extends \Phalcon\Mvc\Controller
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
                "listBoardId='".$boardId."'",
                "order"=>"listPosition ASC"
            ]
        );
        $boardCard = Boardcard::find(
            [
                "cardBoardId='".$boardId."'",
                "order" => "cardPosition ASC"
            ]
        );
        $boardLabelCard = Boardlabelcard::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $profile = Userprofile::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $this->view->userId            = $userId;
        $this->view->userProfile       = $profile;
    	$this->view->board             = $board;
        $this->view->boardLabelCard    = $boardLabelCard;
    	$this->view->boardList         = $boardList;
    	$this->view->boardCard         = $boardCard;
    }

    public function createListAction()
    {
    	$title = $_POST["title"];
    	$owner = $_POST["owner"];
    	$archive = "0";
    	$status = "1";
        $list = new Boardlist();
        $index = $list->countList();
        $id = "BL".str_pad($index,5,'0',STR_PAD_LEFT);
        $list->insertBoardList($owner,$title,$archive,$status);
    	$this->view->disable();
    	echo $id;
    }

    public function createCardAction()
    {
    	$title         = $_POST["title"];
    	$listId        = $_POST["owner"];
        $boardId       = "";
        if(isset($_GET["id"]))
        {
            $boardId   = $_GET["id"];
        }
    	$owner = $this->session->get("userId");
    	$description   = "";
    	$archive       = "0";
    	$status        = "1";
        $checked       = "1";

        //cardId
        $card           = new Boardcard();
        $index          = $card->countCard();
        $cardId         = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
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
            $assign->insertBoardAssignMembers($cardId,$userId,$userName,$checked,$status);
        }
    	$this->view->disable();
		echo $cardId;

    }

    public function copyAllCardAction()
    {
        $boardId = $_POST["boardId"];
        $listTujuan = $_POST["listTujuan"];
        $listId = $_POST["listId"];
        $owner = $this->session->get("userId");
        $card = Boardcard::find(
            [
                "cardListId='".$listId."'",
                "order"=>"cardPosition ASC"
            ]
        );
        $global = "";
        foreach($card as $c)
        {
            if($c->cardArchive == "0" && $c->cardStatus == "1")
            {
                //insert card
                $cardId = $c->cardId;
                $title = $c->cardTitle;
                $archive = $c->cardArchive;
                $status = $c->cardStatus;
                $description = $c->cardDescription;
                $c2 = new Boardcard();
                $index = $c->countCard();
                $cardIdAkhir    = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
                $c2->insertBoardCard($listTujuan,$boardId,$owner,$title,$description,$archive,$status);

                $global = $global."%20".$cardIdAkhir."%10".$title;
                //insert assign members
                $assign = Boardassignmembers::find(
                    [
                        "cardId='".$cardId."'"
                    ]
                );
                foreach($assign as $a)
                {
                    $userIdAM = $a->userId;
                    $userNameAM = $a->userName;
                    $checkedAM = $a->assignChecked;
                    $statusAM = $a->assignStatus;
                    $assign2 = new Boardassignmembers();
                    $assign2->insertBoardAssignMembers($cardIdAkhir,$userIdAM,$userNameAM,$checkedAM,$statusAM);
                }

                //insert label card
                $label = Boardlabelcard::findFirst(
                    [
                        "cardId='".$cardId."'"
                    ]
                );
                if($label != null)
                {
                    $red2 = $label->labelRed;
                    $yellow2 = $label->labelYellow;
                    $green2 = $label->labelGreen;
                    $blue2 = $label->labelBlue;
                    $status2 = $label->labelStatus;
                    $label2 = new Boardlabelcard();
                    $label2->insertBoardLabelCard($boardId,$cardIdAkhir,$red2,$yellow2,$green2,$blue2,$status2);
                }

                //insert attachment
                $attachment = Boardattachment::find(
                    [
                        "cardId='".$cardId."'"
                    ]
                );
                foreach($attachment as $att)
                {
                    if($att->attachmentStatus == "1")
                    {
                        $title2 = $att->attachmentTitle;
                        $directory2 = $att->attachmentDirectory;
                        $status2 = $att->attachmentStatus;
                        $attachment2 = new Boardattachment();
                        $attachment2->insertBoardAttachment($boardId,$cardIdAkhir,$title2,$directory2,$status2);
                    }
                }

                //insert checklist
                $checklist = Boardchecklist::find(
                    [
                        "cardId='".$cardId."'"
                    ]
                );
                foreach($checklist as $c)
                {
                    if($c->checklistStatus == "1")
                    {
                        $idChecklist = $c->checklistId;
                        $title2 = $c->checklistTitle;
                        $status2 = $c->checklistStatus;
                        $checklist2      = new Boardchecklist();
                        $index          = $checklist2->countChecklist();
                        $id             = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
                        $checklist2->insertBoardChecklist($cardIdAkhir,$title2,$status2);

                        //insert checklist item
                        $item = Boardchecklistitem::find(
                            [
                                   "checklistId='".$idChecklist."'"  
                            ]
                        ); 
                        foreach($item as $i)
                        {
                            if($i->itemStatus == "1")
                            {
                                $title3 = $i->itemTitle;
                                $checked3 = $i->itemChecked;
                                $status3 = $i->itemStatus;
                                $item2 = new Boardchecklistitem(); 
                                $item2->insertBoardChecklistItem($id,$cardIdAkhir,$title3,$checked3,$status3);
                            }
                        }
                    }
                }

                //insert start date
                $start = Boardstartdate::findFirst(
                    [
                        "cardId='".$cardId."'"
                    ]
                );
                if($start != null)
                {
                    $d2 = $start->startDate; //2018-04-12 12:00:00
                    $pecah = explode(" ",$d2);
                    $pecah2 = explode("-",$pecah[0]); //date
                    $bln = $pecah2[1];
                    $thn = $pecah2[0];
                    $tgl = $pecah2[2];
                    $pecah3 = explode(":",$pecah[1]); //time
                    $time = $pecah3[0];
                    $d3=mktime($time, 00, 00, $bln, $tgl, $thn);
                    $checked2 = $start->startDateChecked;
                    $status2 = $start->startDateStatus;
                    $date = new Boardstartdate();
                    $date->insertBoardStartDate($cardIdAkhir,$d3,$checked2,$status2);
                }
                

                //insert due date
                $due = Boardduedate::findFirst(
                    [
                        "cardId='".$cardId."'"
                    ]
                );
                if($due != null)
                {
                    $d2 = $due->dueDate;
                    $pecah = explode(" ",$d2);
                    $pecah2 = explode("-",$pecah[0]); //date
                    $bln = $pecah2[1];
                    $thn = $pecah2[0];
                    $tgl = $pecah2[2];
                    $pecah3 = explode(":",$pecah[1]); //time
                    $time = $pecah3[0];
                    $d3=mktime($time, 00, 00, $bln, $tgl, $thn);
                    $checked2 = $due->dueDateChecked;
                    $status2 = $due->dueDateStatus;
                    $date = new Boardduedate();
                    $date->insertBoardDueDate($cardIdAkhir,$d3,$checked2,$status2);
                }


            }
        }
        $this->view->disable();
        echo $global;
    }

    public function archiveListAction()
    {
        $boardId = $_POST["boardId"];
        $listId = $_POST["listId"];
        $posAwal = 0;
        $list2 = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $posAwal = $list2->listPosition;
        $list = Boardlist::find(
            [
                "listBoardId='".$boardId."'",
                "order"=>"listPosition ASC"
            ]
        );
        foreach($list as $l)
        {
            if($l->listArchive == "0" && $l->listStatus == "1" && $l->listPosition > 0)
            {
                if($l->listPosition > $posAwal)
                {
                    $listId2 = $l->listId;
                    $position = $l->listPosition;
                    $position = $position - 1;
                    $l->setPosition($listId2,$position);
                }
            }
        }
        $posAkhir = "-1";
        $archive = "1";
        $list2->setPosition($listId,$posAkhir);
        $list2->setArchive($listId,$archive);
        $this->view->disable();
        echo "Berhasil";
    }

    public function copyCardAction()
    {
        $cardId = $_POST["cardId"];
        $title = $_POST["title"];
        $listId = $_POST["listId"];
        $boardId = $_POST["boardId"];
        $owner = $this->session->get("userId");
        $description   = "";
        $archive       = "0";
        $status        = "1";

        //insert card
        $card           = new Boardcard();
        $index          = $card->countCard();
        $cardIdAkhir    = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
        $card->insertBoardCard($listId,$boardId,$owner,$title,$description,$archive,$status);

        //insert assign members
        $assign = Boardassignmembers::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        foreach($assign as $a)
        {
            $userIdAM = $a->userId;
            $userNameAM = $a->userName;
            $checkedAM = $a->assignChecked;
            $statusAM = $a->assignStatus;
            $assign2 = new Boardassignmembers();
            $assign2->insertBoardAssignMembers($cardIdAkhir,$userIdAM,$userNameAM,$checkedAM,$statusAM);
        }

        //insert label card
        $label = Boardlabelcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($label != null)
        {
            $red2 = $label->labelRed;
            $yellow2 = $label->labelYellow;
            $green2 = $label->labelGreen;
            $blue2 = $label->labelBlue;
            $status2 = $label->labelStatus;
            $label2 = new Boardlabelcard();
            $label2->insertBoardLabelCard($boardId,$cardIdAkhir,$red2,$yellow2,$green2,$blue2,$status2);
        }
        

        //insert attachment
        $attachment = Boardattachment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        foreach($attachment as $att)
        {
            if($att->attachmentStatus == "1")
            {
                $title2 = $att->attachmentTitle;
                $directory2 = $att->attachmentDirectory;
                $status2 = $att->attachmentStatus;
                $attachment2 = new Boardattachment();
                $attachment2->insertBoardAttachment($boardId,$cardIdAkhir,$title2,$directory2,$status2);
            }
        }

        //insert checklist
        $checklist = Boardchecklist::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        foreach($checklist as $c)
        {
            if($c->checklistStatus == "1")
            {
                $idChecklist = $c->checklistId;
                $title2 = $c->checklistTitle;
                $status2 = $c->checklistStatus;
                $checklist2      = new Boardchecklist();
                $index          = $checklist2->countChecklist();
                $id             = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
                $checklist2->insertBoardChecklist($cardIdAkhir,$title2,$status2);

                //insert checklist item
                $item = Boardchecklistitem::find(
                    [
                           "checklistId='".$idChecklist."'"  
                    ]
                ); 
                foreach($item as $i)
                {
                    if($i->itemStatus == "1")
                    {
                        $title3 = $i->itemTitle;
                        $checked3 = $i->itemChecked;
                        $status3 = $i->itemStatus;
                        $item2 = new Boardchecklistitem(); 
                        $item2->insertBoardChecklistItem($id,$cardIdAkhir,$title3,$checked3,$status3);
                    }
                }
            }
        }

        //insert start date
        $start = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($start != null)
        {
            $d2 = $start->startDate; //2018-04-12 12:00:00
            $pecah = explode(" ",$d2);
            $pecah2 = explode("-",$pecah[0]); //date
            $bln = $pecah2[1];
            $thn = $pecah2[0];
            $tgl = $pecah2[2];
            $pecah3 = explode(":",$pecah[1]); //time
            $time = $pecah3[0];
            $d3=mktime($time, 00, 00, $bln, $tgl, $thn);
            $checked2 = $start->startDateChecked;
            $status2 = $start->startDateStatus;
            $date = new Boardstartdate();
            $date->insertBoardStartDate($cardIdAkhir,$d3,$checked2,$status2);
        }
        

        //insert due date
        $due = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($due != null)
        {
            $d2 = $due->dueDate;
            $pecah = explode(" ",$d2);
            $pecah2 = explode("-",$pecah[0]); //date
            $bln = $pecah2[1];
            $thn = $pecah2[0];
            $tgl = $pecah2[2];
            $pecah3 = explode(":",$pecah[1]); //time
            $time = $pecah3[0];
            $d3=mktime($time, 00, 00, $bln, $tgl, $thn);
            $checked2 = $due->dueDateChecked;
            $status2 = $due->dueDateStatus;
            $date = new Boardduedate();
            $date->insertBoardDueDate($cardIdAkhir,$d3,$checked2,$status2);
        }

        

        $this->view->disable();
        echo $cardIdAkhir;
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

    public function updateCardDescriptionAction()
    {
        $id             = $_POST["cardId"];
        $description    = $_POST["cardDescription"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]);
        $card->setDescription($id,$description);
        $this->view->disable();
        echo $description;
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
        $cardListId         = $card->cardListId;
        $data = array(
            'cardId'            => $cardId, 
            'cardTitle'         => $cardTitle,
            'cardDescription'   => $cardDescription,
            'cardListId'        => $cardListId,
            'listTitle'         => $listTitle
        );
    	$datas[] = $data;
    	$this->view->disable();
    	echo json_encode($datas);
    }

    public function getBoardMemberAction()
    {
    	$boardId = $_POST["boardId"];
    	$assign = array();
        $assign = Boardmember::find(
            [
                "boardId='".$boardId."'"
            ]
        );
    	$this->view->disable();	
    	echo json_encode($assign);
    }

    public function getBoardAssignCheckedAction()
    {
        $userId = $_POST["userId"];
        $cardId = $_POST["cardId"];
        $assign = Boardassignmembers::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $check = "false";
        foreach($assign as $a)
        {
            if($a->userId == $userId)
            {
                if($a->assignChecked == "1")
                {
                    $check = "true";
                }
            }
        }
        $this->view->disable();
        echo $check;
    }

    public function createAssignMembersAction()
    {
        $cardId = $_POST["cardId"];
        $userId = $_POST["userId"];
        $check = $_POST["check"];
        $name = $_POST["name"];
        $match = false;
        $status = "1";
        $assignId = "";
        $assign = Boardassignmembers::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        foreach($assign as $a)
        {
            if($a->userId == $userId)
            {
                $match = true; //UPDATE checked saja
                $assignId = $a->assignId;
            }
        }
        if($match == false)
        {
            //baru masuk ke board, ditambahkan ke tabel boardassignmembers
            $assign2 = new Boardassignmembers();
            $assign2->insertBoardAssignMembers($cardId,$userId,$name,$check,$status);
        }
        else
        {
            //update check saja
            $assign2 = Boardassignmembers::findFirst(
                [
                    "assignId='".$assignId."'"
                ]
            );
            $assign2->changeAssignChecked($assignId,$check);
        }
        $this->view->disable();
        echo "Berhasil";

    }

    public function setStartDateAction()
    {
    	$cardId = $_POST["id"];
        $checked = "0";
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
        $match = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($match == null)
        {
            $date = new Boardstartdate();
            $date->insertBoardStartDate($cardId,$d,$checked,$status);
        }
        else
        {
            $match->changeStartDate($cardId,$d,$checked,$status);
        }

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
        $checked = "0";
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
        $match = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($match == null)
        {
            
            $date = new Boardduedate();
            $date->insertBoardDueDate($cardId,$d,$checked,$status);
        }
        else
        {
            $match->changeDueDate($cardId,$d,$checked,$status);
        }

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
        $cardId         = $_POST["id"];
        $title          = $_POST["title"];
        $status         = "1";
        $checklist      = new Boardchecklist();
        $index          = $checklist->countChecklist();
        $id             = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
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
        $checked = "0";
        $status = "1";
        $checklist = new Boardchecklistitem();
        $index = $checklist->countChecklistItem();
        $id = "BCI".str_pad($index,5,'0',STR_PAD_LEFT);
        $checklist->insertBoardChecklistItem($checklistId,$cardId,$title,$checked,$status);
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
        $listId = $_POST["listId"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$id."'"
            ]
        );
        $posAwal = $card->cardPosition;
        $position = -1;
        $card->setArchive($id,$status);

        $card->setPosition($listId,$id,$position);

        //mengatur posisi card
        $card2 = Boardcard::find(
            [
                "cardListId='".$listId."'",
                "order" => "cardPosition ASC"
            ]
        );
        foreach($card2 as $c)
        {
            if($c->cardPosition > $posAwal)
            {
                $cardId2 = $c->cardId;
                $position2 = $c->cardPosition-1;
                $c->setPosition($listId,$cardId2,$position2);
            }
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function sendBackCardAction()
    {
        $cardId = $_POST["id"];
        $status = $_POST["status"];
        $listId = "";
        $card = array();
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $title = $card->cardTitle;
        $listId = $card->cardListId;
        $card->setArchive($cardId,$status);
        $posAkhir = Boardcard::maximum(
            [
                "column"        => "cardPosition",
                "conditions"    => "cardListId='".$listId."'"
            ]
        );
        if($posAkhir < 0)
        {
            $posAkhir = 0;
        }
        $posAkhir = $posAkhir+1;
        $card->setPosition($listId,$cardId,$posAkhir);
        $this->view->disable();
        echo $listId."%20".$title;
    }

    public function sendBackListAction()
    {
        $listId = $_POST["listId"];
        $status = $_POST["status"];
        $boardId = $_POST["boardId"];
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $title = $list->listTitle;
        $list->setArchive($listId,$status);
        $posAkhir = Boardlist::maximum(
            [
                "column" => "listPosition",
                "conditions" => "listBoardId='".$boardId."'"
            ]
        );
        if($posAkhir < 0)
        {
            $posAkhir = 0;
        }
        $posAkhir = $posAkhir+1;
        $list->setPosition($listId,$posAkhir);
        $this->view->disable();
        echo $title;
    }

    public function deleteCardAction()
    {
        $cardId = $_POST["cardId"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $card->deleteCard($cardId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteListAction()
    {
        $listId = $_POST["listId"];
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $list->deleteList($listId);
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

    public function getListArchiveAction()
    {
        $status = "1";
        $list = array();
        $list = Boardlist::find(
            [
                "listArchive='".$status."'"

            ]);
        $this->view->disable();
        echo json_encode($list);
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
        $index      = $reply->countReply();
        $id         = "BRC".str_pad($index,5,'0',STR_PAD_LEFT);
        $reply->insertBoardReplyComment($commentId,$cardId,$boardId,$userId,$text,$status);

        $this->view->disable();
        echo $id;
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
        $match = Boardlabelcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($match == null)
        {
            $label = new Boardlabelcard();
            $label->insertBoardLabelCard($boardId,$cardId,$red,$yellow,$green,$blue,$status);
        }
        else
        {
            $match->setColor($cardId,$red,$yellow,$green,$blue);
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function getLabelCardAction()
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

    public function createAttachmentAction()
    {
        $this->view->disable();
        $boardId    = $_POST["boardId"];
        $cardId     = $_POST["cardId"];
        $title      = $_POST["title"];
        $extension  = $_POST["extension"];
        $status     = "1";
        $attachment = new Boardattachment();
        $index      = $attachment->countAttachment();
        $id         = "BAT".str_pad($index,5,'0',STR_PAD_LEFT);
        $directory  = "userAttachment/".$id.".".$extension;
        $attachment->insertBoardAttachment($boardId,$cardId,$title,$directory,$status);
        if ( 0 < $_FILES['file1']['error'] ) 
        {
          echo 'Error: ' . $_FILES['file1']['error'] . '<br>';
        }
        else {
          $temp = explode(".", $_FILES["file1"]["name"]);
          move_uploaded_file($_FILES['file1']['tmp_name'], $directory);
        }
        echo $id;
    }

    public function getAttachmentAction()
    {
        $cardId = $_POST["id"];
        $attachment = array();
        $attachment = Boardattachment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($attachment);
    }

    public function getBoardAction()
    {
        $boardId    = $_POST["id"];
        $board      = array();
        $board      = Board::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($board);
    }

    public function changeBackgroundAction()
    {
        $boardId    = $_POST["id"];
        $color      = $_POST["color"];
        $board      = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $board->setBackground($boardId,$color);
        $this->view->disable();
        echo $color;
    }

    public function changeBoardTitleAction()
    {
        $boardId    = $_POST["id"];
        $title      = $_POST["title"];
        $board      = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $board->setTitle($boardId,$title);
        $this->view->disable();
        echo "Berhasil";

    }

    public function getMoveCardAction()
    {
        $boardId = $_POST["boardId"];
        $list    = Boardlist::find(
            [
                "listBoardId='".$boardId."'",
                "order"=> "listPosition ASC"
            ]
        );
        $this->view->disable();
        echo json_encode($list);
    }

    public function getListPositionAction()
    {
        $listId = $_POST["listId"];
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $position = $list->listPosition;
        $this->view->disable();
        echo $position;
    }

    public function changeListPositionAction()
    {
        $boardId = $_POST["boardId"];
        $listId = $_POST["listId"];
        $posAwal = $_POST["posAwal"];
        $posTujuan = $_POST["posTujuan"];
        $list = Boardlist::find(
            [
                "listBoardId='".$boardId."'",
                "order"=>"listPosition ASC"
            ]
        );
        $gerak = "";
        $diff = 0;
        if($posAwal < $posTujuan)
        {
            $diff = $posTujuan - $posAwal;
            $gerak = "atas";
        }
        else
        {
            $diff = $posAwal - $posTujuan;
            $gerak = "bawah";
        }
        $ctr = 0;
        foreach($list as $l)
        {
            if($l->listArchive == "0" && $l->listStatus == "1" && $ctr < $diff)
            {

                $listId2 = $l->listId;
                $position = $l->listPosition;
                if($gerak == "atas" && $position>$posAwal)
                {
                    $position2 = $position-1;
                    $l->setPosition($listId2,$position2);
                    $ctr++;
                }
                else if($gerak == "bawah" && $position>=$posTujuan)
                {
                    $position2 = $position+1;
                    $l->setPosition($listId2,$position2);
                    $ctr++;
                }
            }
        }
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $list->setPosition($listId,$posTujuan);
        $this->view->disable();
        echo $gerak;
    }

    public function getMoveCardPositionAction()
    {
        $listId = $_POST["listId"];
        $card = Boardcard::find(
            [
                "cardListId='".$listId."'",
                "order" => "cardPosition ASC"
            ]
        );
        $this->view->disable();
        echo json_encode($card);

    }

    public function updateCardPositionAction()
    {
        $cardId = $_POST["cardId"];
        $global = "Berhasil";
        $listSelect = $_POST["listSelect"];
        $position = $_POST["position"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $listMatch = "false";
        if($card->cardListId == $listSelect)
        {
            $listMatch = "true";
        }
        if($listMatch == "true")
        {
            $posAwal = $card->cardPosition;
            if($posAwal < $position)
            {
                //kebawah
                $diff = $position - $posAwal;//banyak card yang terpengaruh oleh perpindahan card dalam satu list
                $card2 = Boardcard::find(
                    [
                        "cardListId='".$listSelect."'",
                        "order" => "cardPosition ASC"
                    ]
                );
                $tempdiff = 0;
                foreach($card2 as $c2)
                {
                    if($c2->cardPosition > $posAwal && $tempdiff < $diff && $c2->cardArchive == "0" && $c2->cardStatus=="1") //melakukan pengecekan jika posisi awal lebih kecil dari posisi yang ditentukan dan jumlah card yang terpengaruh masih mencukupi
                    {
                        $tempCardId = $c2->cardId;
                        $tempPos = ($c2->cardPosition-1);
                        $c2->setPosition($listSelect,$tempCardId,$tempPos);
                        $tempdiff++;
                    }
                }
                $global = "bawah";
            }
            else if($posAwal > $position)
            {
                //keatas
                $diff = $posAwal - $position;
                $card2 = Boardcard::find(
                    [
                        "cardListId='".$listSelect."'",
                        "order" => "cardPosition ASC"
                    ]
                );
                $tempdiff = 0;
                foreach($card2 as $c2)
                {
                    if($position <= $c2->cardPosition && $tempdiff < $diff  && $c2->cardArchive == "0" && $c2->cardStatus=="1")
                    {
                        $tempCardId = $c2->cardId;
                        $tempPos = ($c2->cardPosition+1);
                        $c2->setPosition($listSelect,$tempCardId,$tempPos);
                        $tempdiff++;
                    }
                }
                $global = "atas";
            }
            $card->setPosition($listSelect,$cardId,$position);
        }
        else
        {
            $listAwal = $card->cardListId;
            $posAwal = $card->cardPosition;
            //memperbaiki list awal
            $card2 = Boardcard::find(
                [
                    "cardListId='".$listAwal."'",
                    "order" => "cardPosition ASC"
                ]
            );
            foreach($card2 as $c2)
            {
                if($c2->cardPosition > $posAwal  && $c2->cardArchive == "0" && $c2->cardStatus=="1")
                {
                    $tempCardId = $c2->cardId;
                    $tempPos = ($c2->cardPosition-1);
                    $c2->setPosition($listAwal,$tempCardId,$tempPos);
                }
            }
            //memperbaiki list baru
            $card3 = Boardcard::find(
                [
                    "cardListId='".$listSelect."'",
                    "order" => "cardPosition ASC"
                ] 
            );
            foreach($card3 as $c3)
            {
                if($c3->cardPosition >= $position  && $c2->cardArchive == "0" && $c2->cardStatus=="1")
                {
                    $tempCardId = $c3->cardId;
                    $tempPos = ($c3->cardPosition+1);
                    $c3->setPosition($listSelect,$tempCardId,$tempPos);
                }
            }
            //memasukkan card ke list baru
            $card->setPosition($listSelect,$cardId,$position);
        }

        $this->view->disable();
        echo $global;
    }

    public function moveAllCardAction()
    {
        $listId = $_POST["listId"]; //list awal
        $listTujuan = $_POST["listTujuan"];
        $card = Boardcard::find(
            [
                "cardListId='".$listId."'",
                "order"=>"cardPosition ASC"
            ]
        );
        foreach($card as $c)
        {
            if($c->cardArchive == "0" && $c->cardStatus == "1")
            {
                $cardId = $c->cardId;
                $position = Boardcard::maximum(
                    [
                        "column"=>"cardPosition",
                        "conditions"=>"cardListId='".$listTujuan."'"
                    ]
                );
                $position = $position+1;
                $c->setPosition($listTujuan,$cardId,$position);
            }
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function archiveAllCardAction()
    {
        $listId = $_POST["listId"];
        $card = Boardcard::find(
            [
                "cardListId='".$listId."'",
                "order"=>"cardPosition ASC"
            ]
        );
        foreach($card as $c)
        {
            if($c->cardArchive == "0" && $c->cardStatus == "1")
            {
                $id = $c->cardId;
                $status = "1";
                $position = "-1";
                $c->setArchive($id,$status);
                $c->setPosition($listId,$id,$position);

            }
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteAttachmentAction()
    {
        $attachmentId = $_POST["id"];
        $attachment = Boardattachment::findFirst(
            [
                "attachmentId='".$attachmentId."'"
            ]
        );
        $attachment->deleteAttachment($attachmentId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function downloadAttachmentAction()
    {
        $attachmentId = "";
        if(isset($_GET["id"]))
        {
            $attachmentId = $_GET["id"];
        }
        $attachment = Boardattachment::findFirst(
            [
                "attachmentId='".$attachmentId."'"
            ]
        );
        $name = $attachment->attachmentTitle;
        $directory = $attachment->attachmentDirectory;

        $file = $directory;

        if (file_exists($file)) {
            header('Pragma: public');
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function deleteChecklistAction()
    {
        $checklistId = $_POST["id"];
        $checklist = Boardchecklist::findFirst(
            [
                "checklistId='".$checklistId."'"
            ]
        );
        $checklist->deleteChecklist($checklistId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteChecklistItemAction()
    {
        $itemId = $_POST["id"];
        $item = Boardchecklistitem::findFirst(
            [
                "itemId='".$itemId."'"
            ]
        );
        $item->deleteChecklistItem($itemId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function changeItemCheckedAction()
    {
        $itemId = $_POST["id"];
        $check = $_POST["check"];
        $item = Boardchecklistitem::findFirst(
            [
                "itemId='".$itemId."'"
            ]
        );
        $item->changeItemChecked($itemId,$check);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteStartDateAction()
    {
        $cardId = $_POST["id"];
        $date = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $date->deleteStartDate($cardId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function changeStartDateCheckedAction()
    {
        $cardId = $_POST["id"];
        $checked = $_POST["check"];
        $date = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $date->changeStartDateChecked($cardId,$checked);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteDueDateAction()
    {
        $cardId = $_POST["id"];
        $date = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $date->deleteDueDate($cardId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function changeDueDateCheckedAction()
    {
        $cardId = $_POST["id"];
        $checked = $_POST["check"];
        $date = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $date->changeDueDateChecked($cardId,$checked);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteCommentAction()
    {
        $commentId = $_POST["id"];
        $comment = Boardcomment::findFirst(
            [
                "commentId='".$commentId."'"
            ]
        );
        $comment->deleteComment($commentId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function changeCommentTextAction()
    {
        $commentId = $_POST["id"];
        $text = $_POST["text"];
        $comment = Boardcomment::findFirst(
            [
                "commentId='".$commentId."'"
            ]
        );
        $comment->changeCommentText($commentId,$text);
        $this->view->disable();
        echo "Berhasil";
    }

    public function deleteReplyAction()
    {
        $replyId = $_POST["id"];
        $reply = Boardreplycomment::findFirst(
            [
                "replyId='".$replyId."'"
            ]
        );
        $reply->deleteReply($replyId);
        $this->view->disable();
        echo "Berhasil";
    }

    public function changeReplyTextAction()
    {
        $replyId = $_POST["id"];
        $text = $_POST["text"];
        $reply = Boardreplycomment::findFirst(
            [
                "replyId='".$replyId."'"
            ]
        );
        $reply->changeReplyText($replyId,$text);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getNameUserAction()
    {
        $userId = $_POST["id"];
        $user = User::findFirst(
            "userId='".$userId."'"
        );

        $name = $user->userName;
        $this->view->disable();
        return $name;
    }

    public function getDirectoryUserAction()
    {
        $userId = $_POST["id"];
        $user = Userprofile::findFirst(
            "userId='".$userId."'"
        );

        $directory = $user->userImage;
        $this->view->disable();
        return $directory;
    }

    public function createFavoriteAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $check = $_POST["check"];
        $match = false;
        $favorite = Boardfavorite::find(
            [
                "userId='".$userId."'"
            ]
        );
        $favoriteId2 = "";
        foreach($favorite as $f)
        {
            if($f->boardId == $boardId)
            {
                $match = true;
                $favoriteId2 = $f->favoriteId;
            }
        }
        if($match == true)
        {
            //update
            $favorite = Boardfavorite::findFirst(
                [
                    "favoriteId='".$favoriteId2."'"
                ]
            );
            $favorite->setCheck($favoriteId2,$check);
        }
        else
        {
            //insert
            $status = "1";
            $favorite = new Boardfavorite();
            $favorite->insertBoardFavorite($boardId,$userId,$check,$status);
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function getFavoriteAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $board = Boardfavorite::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($board);
    }

    public function getSubscribeAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $board = Boardsubscribe::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($board);
    }

    public function createSubscribeAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $check = $_POST["check"];
        $match = false;
        $subscribe = Boardsubscribe::find(
            [
                "userId='".$userId."'"
            ]
        );
        $subscribeId2 = "";
        foreach($subscribe as $s)
        {
            if($s->boardId == $boardId)
            {
                $match = true;
                $subscribeId2 = $s->subscribeId;
            }
        }
        if($match == true)
        {
            //update
            $subscribe = Boardsubscribe::findFirst(
                [
                    "subscribeId='".$subscribeId2."'"
                ]
            );
            $subscribe->setCheck($subscribeId2,$check);
        }
        else
        {
            //insert
            $status = "1";
            $subscribe = new Boardsubscribe();
            $subscribe->insertBoardSubscribe($boardId,$userId,$check,$status);
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function getCardListAction()
    {
        $listId = $_POST["listId"];
        $card = Boardcard::find(
            [
                "cardListId='".$listId."'",
                "order" => "cardPosition ASC"
            ]
        ); 
        $this->view->disable();
        echo json_encode($card);
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

    public function copyBoardAction()
    {
        $boardId = $_POST["boardId"];
        $title = $_POST["title"];
        $userId = $this->session->get("userId");
        $b = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $public = "1";
        $group = "0";
        $status = "1";
        $background = "blue";
        $board = new Board();
        $index = $board->countBoard();
        $id = "BO".str_pad($index,5,'0',STR_PAD_LEFT);
        $board->insertBoard($userId,$title,$public,$group,$status,$background);

        $role="Creator";
        $boardMember = new Boardmember();
        $boardMember->insertBoardMember($userId,$id,$role,$status);

        $list = Boardlist::find(
            [
                "listBoardId='".$boardId."'"
            ]
        );
        foreach($list as $l)
        {
            if($l->listArchive == "0" && $l->listStatus == "1")
            {
                $title = $l->listTitle;
                $nList = new Boardlist();
                $archive = "0";
                $status = "1";
                $newList = new Boardlist();
                $index = $newList->countList();
                $listTujuan = "BL".str_pad($index,5,'0',STR_PAD_LEFT);
                $newList->insertBoardList($id,$title,$archive,$status);

                $owner = $this->session->get("userId");
                $card = Boardcard::find(
                    [
                        "cardListId='".$l->listId."'",
                        "order"=>"cardPosition ASC"
                    ]
                );
                foreach($card as $c)
                {
                    if($c->cardArchive == "0" && $c->cardStatus == "1")
                    {
                        //insert card
                        $cardId = $c->cardId;
                        $title = $c->cardTitle;
                        $archive = $c->cardArchive;
                        $status = $c->cardStatus;
                        $description = $c->cardDescription;
                        $c2 = new Boardcard();
                        $index = $c->countCard();
                        $cardIdAkhir    = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
                        $c2->insertBoardCard($listTujuan,$id,$owner,$title,$description,$archive,$status);

                        //insert assign members
                        $assign = Boardassignmembers::find(
                            [
                                "cardId='".$cardId."'"
                            ]
                        );
                        foreach($assign as $a)
                        {
                            $userIdAM = $a->userId;
                            $userNameAM = $a->userName;
                            $checkedAM = $a->assignChecked;
                            $statusAM = $a->assignStatus;
                            $assign2 = new Boardassignmembers();
                            $assign2->insertBoardAssignMembers($cardIdAkhir,$userIdAM,$userNameAM,$checkedAM,$statusAM);
                        }

                        //insert label card
                        $label = Boardlabelcard::findFirst(
                            [
                                "cardId='".$cardId."'"
                            ]
                        );
                        if($label != null)
                        {
                            $red2 = $label->labelRed;
                            $yellow2 = $label->labelYellow;
                            $green2 = $label->labelGreen;
                            $blue2 = $label->labelBlue;
                            $status2 = $label->labelStatus;
                            $label2 = new Boardlabelcard();
                            $label2->insertBoardLabelCard($id,$cardIdAkhir,$red2,$yellow2,$green2,$blue2,$status2);
                        }

                        //insert attachment
                        $attachment = Boardattachment::find(
                            [
                                "cardId='".$cardId."'"
                            ]
                        );
                        foreach($attachment as $att)
                        {
                            if($att->attachmentStatus == "1")
                            {
                                $title2 = $att->attachmentTitle;
                                $directory2 = $att->attachmentDirectory;
                                $status2 = $att->attachmentStatus;
                                $attachment2 = new Boardattachment();
                                $attachment2->insertBoardAttachment($id,$cardIdAkhir,$title2,$directory2,$status2);
                            }
                        }

                        //insert checklist
                        $checklist = Boardchecklist::find(
                            [
                                "cardId='".$cardId."'"
                            ]
                        );
                        foreach($checklist as $c)
                        {
                            if($c->checklistStatus == "1")
                            {
                                $idChecklist = $c->checklistId;
                                $title2 = $c->checklistTitle;
                                $status2 = $c->checklistStatus;
                                $checklist2      = new Boardchecklist();
                                $index          = $checklist2->countChecklist();
                                $idCheck             = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
                                $checklist2->insertBoardChecklist($cardIdAkhir,$title2,$status2);

                                //insert checklist item
                                $item = Boardchecklistitem::find(
                                    [
                                           "checklistId='".$idChecklist."'"  
                                    ]
                                ); 
                                foreach($item as $i)
                                {
                                    if($i->itemStatus == "1")
                                    {
                                        $title3 = $i->itemTitle;
                                        $checked3 = $i->itemChecked;
                                        $status3 = $i->itemStatus;
                                        $item2 = new Boardchecklistitem(); 
                                        $item2->insertBoardChecklistItem($idCheck,$cardIdAkhir,$title3,$checked3,$status3);
                                    }
                                }
                            }
                        }

                        //insert start date
                        $start = Boardstartdate::findFirst(
                            [
                                "cardId='".$cardId."'"
                            ]
                        );
                        if($start != null)
                        {
                            $d2 = $start->startDate; //2018-04-12 12:00:00
                            $pecah = explode(" ",$d2);
                            $pecah2 = explode("-",$pecah[0]); //date
                            $bln = $pecah2[1];
                            $thn = $pecah2[0];
                            $tgl = $pecah2[2];
                            $pecah3 = explode(":",$pecah[1]); //time
                            $time = $pecah3[0];
                            $d3=mktime($time, 00, 00, $bln, $tgl, $thn);
                            $checked2 = $start->startDateChecked;
                            $status2 = $start->startDateStatus;
                            $date = new Boardstartdate();
                            $date->insertBoardStartDate($cardIdAkhir,$d3,$checked2,$status2);
                        }
                        

                        //insert due date
                        $due = Boardduedate::findFirst(
                            [
                                "cardId='".$cardId."'"
                            ]
                        );
                        if($due != null)
                        {
                            $d2 = $due->dueDate;
                            $pecah = explode(" ",$d2);
                            $pecah2 = explode("-",$pecah[0]); //date
                            $bln = $pecah2[1];
                            $thn = $pecah2[0];
                            $tgl = $pecah2[2];
                            $pecah3 = explode(":",$pecah[1]); //time
                            $time = $pecah3[0];
                            $d3=mktime($time, 00, 00, $bln, $tgl, $thn);
                            $checked2 = $due->dueDateChecked;
                            $status2 = $due->dueDateStatus;
                            $date = new Boardduedate();
                            $date->insertBoardDueDate($cardIdAkhir,$d3,$checked2,$status2);
                        }


                    }
                }
            }
        }
        $this->view->disable();
        echo $id;
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
        $board->boardClosed = $status;
        $board->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function setProgressDateAction()
    {
        $boardId = $_POST["boardId"];
        $date = $_POST["date"];
        $d = "";
        if($date != "")
        {
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
            $d=mktime(10, 00, 00, $bln, $tgl, $thn);
        }
        
        $date2 = Boardprogressdate::findFirst(
            "boardId='".$boardId."'"
        );
        if($date2 != null)
        {
            //ada
            if($date != "")
            {
                $id = $date2->dateId;
                $date2->setDate($id,$d);
            }
        }
        else
        {
            //tidak ada
            $status = "1";
            $new = new Boardprogressdate();
            $new->insertBoardProgressDate($boardId,$d,$status);

        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function getProgressDateAction()
    {
        $boardId = $_POST["boardId"];
        $d = "";
        $date = Boardprogressdate::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        if($date != null)
        { 
            $d = $date->date;
        }
        $this->view->disable();
        echo $d;
    }

    public function getProgressItemAction()
    {
        $boardId = $_POST["boardId"];
        $item = Boardprogressitem::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($item);
    }

    public function setProgressItemAction()
    {
        $boardId = $_POST["boardId"];
        $text = $_POST["text"];
        $title = $text;
        $checked = "0";
        $status = "1";
        $item = new Boardprogressitem();
        $index              = $item->countProgressItem();
        $id                 = "BPI".str_pad($index,5,'0',STR_PAD_LEFT);
        $item->progressItemId       = $id;
        $item->insertBoardProgressItem($boardId,$title,$checked,$status);
        $this->view->disable();
        echo $id;
    }

    public function deleteProgressItemAction()
    {
        $itemId = $_POST["itemId"];
        $status = "0";
        $item = Boardprogressitem::findFirst(
            [
                "progressItemId='".$itemId."'"
            ]
        );
        $item->deleteProgressItem($itemId,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function changeProgressItemAction()
    {
        $itemId = $_POST["itemId"];
        $status = $_POST["status"];
        $item = Boardprogressitem::findFirst(
            [
                "progressItemId='".$itemId."'"
            ]
        );
        $item->changeProgressItem($itemId,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function setLeaveBoardAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $member = Boardmember::findFirst(
            [
                "boardId= '".$boardId."' AND userId = '".$userId."'"
            ]
        );
        $member->memberStatus = "0";
        $member->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function getRoleCollaboratorAction()
    {
        $boardId = $_POST["boardId"];
        $role = Boardrolecollaborator::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($role);

    }

    public function getRoleClientAction()
    {
        $boardId = $_POST["boardId"];
        $role = Boardroleclient::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($role);
    }

    public function setRoleClientAction()
    {
        $boardId = $_POST["boardId"];
        $cliListCreate  = $_POST["cliListCreate"];
        $cliListEdit    = $_POST["cliListEdit"];
        $cliListDelete  = $_POST["cliListDelete"];
        $cliCardCreate  = $_POST["cliCardCreate"];
        $cliCardEdit    = $_POST["cliCardEdit"];
        $cliCardDelete  = $_POST["cliCardDelete"];
        $cliActAM       = $_POST["cliActAM"];
        $cliActLabel    = $_POST["cliActLabel"];
        $cliActCheck    = $_POST["cliActCheck"];
        $cliActStart    = $_POST["cliActStart"];
        $cliActDue      = $_POST["cliActDue"];
        $cliActAtt      = $_POST["cliActAtt"];

        $cli = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $cli->setRoleClient($boardId,$cliListCreate,$cliListEdit,$cliListDelete,$cliCardCreate,$cliCardCreate,$cliCardDelete,$cliActAM,$cliActLabel,$cliActCheck,$cliActStart,$cliActDue,$cliActAtt);
        $this->view->disable();
        echo "Berhasil";
    }

    public function setRoleCollaboratorAction()
    {
        $boardId = $_POST["boardId"];
        $collListCreate = $_POST["collListCreate"];
        $collListEdit   = $_POST["collListEdit"];
        $collListDelete = $_POST["collListDelete"];
        $collCardCreate = $_POST["collCardCreate"];
        $collCardEdit   = $_POST["collCardEdit"];
        $collCardDelete = $_POST["collCardDelete"];
        $collActAM      = $_POST["collActAM"];
        $collActLabel   = $_POST["collActLabel"];
        $collActCheck   = $_POST["collActCheck"];
        $collActStart   = $_POST["collActStart"];
        $collActDue     = $_POST["collActDue"];
        $collActAtt     = $_POST["collActAtt"];
        /*$cliListCreate  = $_POST["cliListCreate"];
        $cliListEdit    = $_POST["cliListEdit"];
        $cliListDelete  = $_POST["cliListDelete"];
        $cliCardCreate  = $_POST["cliCardCreate"];
        $cliCardEdit    = $_POST["cliCardEdit"];
        $cliCardDelete  = $_POST["cliCardDelete"];
        $cliActAM       = $_POST["cliActAM"];
        $cliActLabel    = $_POST["cliActLabel"];
        $cliActCheck    = $_POST["cliActCheck"];
        $cliActStart    = $_POST["cliActStart"];
        $cliActDue      = $_POST["cliActDue"];
        $cliActAtt      = $_POST["cliActAtt"];*/
        $coll = Boardrolecollaborator::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $coll->setRoleCollaborator($boardId,$collListCreate,$collListEdit,$collListDelete,$collCardCreate,$collCardEdit,$collCardDelete,$collActAM,$collActLabel,$collActCheck,$collActStart,$collActDue,$collActAtt);
        /*$cli = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $cli->setRoleClient($boardId,$collListCreate,$collListEdit,$collListDelete,$collCardCreate,$collCardEdit,$collCardDelete,$collActAM,$collActLabel,$collActCheck,$collActStart,$collActDue,$collActAtt);*/
        $this->view->disable();
        echo "Berhasil";
    }

    public function getRoleAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $this->session->get("userId");
        $member = Boardmember::findFirst(
            [
                "boardId= '".$boardId."' AND userId = '".$userId."'"
            ]
        );
        $response = "";
        if($member == null)
        {
            $this->response->redirect("home");
        }
        else
        {
            $response = $member->memberRole;
        }
        $this->view->disable();
        echo $response;
    }

    public function createPDFAction()
    {
        set_time_limit(0);
        $this->view->disable();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output('filename.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    }

    public function createInviteAction()
    {
        /*$loader = new Loader();
        $loader->registerDirs(
            [
                APP_PATH . '/library/PHPMailer/src/',
            ]
        );
        $loader->register();*/
        $filepath = APP_PATH . '/library/PHPMailer/src/PHPMailer.php';
        if (file_exists($filepath)) {
        }
        $filepath2 = APP_PATH . '/library/PHPMailer/src/Exception.php';
        $filepath3 = APP_PATH . '/library/PHPMailer/src/SMTP.php';
        require_once $filepath;
        require_once $filepath2;
        require_once $filepath3;
        $this->view->disable();
        $mail = new PHPMailer\PHPMailer\PHPMailer; //Server settings
            
        try {
            $mail->isSMTP();    
            $mail->SMTPDebug = 2;                                       // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                  // Enable verbose debug output
            $mail->SMTPAuth = true;                            // Enable SMTP authentication
            $mail->Username = 'canzinzzide@gmail.com';                 // SMTP username
            $mail->Password = 'cancan110796';                           // SMTP password
            $mail->SMTPSecure = 'smtp';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
            
            //Recipients
            $mail->setFrom('canzinzzide@gmail.com', 'Taff');
            $mail->addAddress('web-ra4tr@mail-tester.com', '');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            //$mail->send();
            if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
            }
            else
            {
                echo 'Message has been sent';  
            }
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

}


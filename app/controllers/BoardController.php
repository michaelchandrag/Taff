<?php


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class BoardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $userId = $this->session->get("userId");
        
        $boardId = "";
        if(isset($_GET["id"]))
        {
            $boardId = $_GET["id"];
        }
        if($userId == null)
        {
            $this->response->redirect("home");
        }
        $board = "";
        $boardList = "";
        $boardCard = "";
        $board = Board::find(
            [
                "boardId='".$boardId."'"
            ]
        );
        $board2 = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        if($board2 == null || $board2 == "")
        {
            $this->view->pick("board/notFound");
        }
        if(empty($boardId))
        {
            $this->view->pick("board/notFound");
        }

        foreach($board as $b)
        {
            if($b->boardClosed == "1" && $b->boardStatus == "1")
            {
                $this->view->pick("board/closed");
            }
            else if($b->boardStatus == "0")
            {
                $this->view->pick("board/notFound");
            }
            $bm = Boardmember::findFirst(
                [
                    "conditions" => "boardId='".$b->boardId."' AND userId='".$userId."'"
                ]
            );
            if($bm->memberStatus != "1" || $bm == null)
            {
                $this->view->pick("board/nonMember");
            }
        }
        $boardList = Boardlist::find(
            [
                "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'",
                "order"=>"listPosition ASC"
            ]
        );
        $boardCard = Boardcard::find(
            [
                "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='0' AND cardStatus='1'",
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
        $role = Boardmember::findFirst(
            [
                "conditions"=>"boardId='".$boardId."' AND userId='".$userId."'"
            ]
        );
        $roleColl = Boardrolecollaborator::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $roleClient = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->assets->addCss("css/cssku.css");
        $this->view->userId            = $userId;
        $this->view->userProfile       = $profile;
        $this->view->board             = $board;
        $this->view->boardLabelCard    = $boardLabelCard;
        $this->view->boardList         = $boardList;
        $this->view->boardCard         = $boardCard;
        $this->view->role              = $role->memberRole; //Creator - Collaborator - Client
        $this->view->roleCollaborator  = $roleColl;
        $this->view->roleClient        = $roleClient;
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $message = $userNameNotification." created a list called ".$title;
        $status = "1";
        $notification->insertBoardNotification($owner,$userId,$message,$status);
        $this->view->disable();
        echo $id;
    }

    public function createCardAction()
    {
        $title         = $_POST["title"];
        $listId        = $_POST["owner"];
        $description    = $_POST["description"];
        $boardId       = $_POST["boardId"];
        $owner = $this->session->get("userId");
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
                "conditions"=>"boardId='".$boardId."' AND memberStatus='1'"
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $message = $userNameNotification." created a card called ".$title;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        $this->view->disable();
        echo $cardId;

    }

    public function copyListAction()
    {
        $title = $_POST["title"];
        $owner = $_POST["owner"];
        $listId = $_POST["listId"];
        $boardId = $owner;
        $archive = "0";
        $status = "1";
        $list = new Boardlist();
        $index = $list->countList();
        $id = "BL".str_pad($index,5,'0',STR_PAD_LEFT);
        $listTujuan = $id;
        $list->insertBoardList($owner,$title,$archive,$status);

        $card = Boardcard::find(
            [
                "conditions"=>"cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1'",
                "order"=>"cardPosition ASC"
            ]
        );
        $arrCard = [];
        foreach($card as $c)
        {
            $cardId = $c->cardId;
            $title = $c->cardTitle;
            $archive = $c->cardArchive;
            $status = $c->cardStatus;
            $description = $c->cardDescription;
            $c2 = new Boardcard();
            $index = $c->countCard();
            $cardIdAkhir    = "BC".str_pad($index,5,'0',STR_PAD_LEFT);
            $userId = $this->session->get("userId");
            $c2->insertBoardCard($listTujuan,$boardId,$userId,$title,$description,$archive,$status);
            $assign = Boardassignmembers::find(
                [
                    "conditions"=>"cardId='".$cardId."' AND assignStatus='1'"
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
            $label = Boardlabelcard::findFirst(
                [
                    "conditions"=>"cardId='".$cardId."'"
                ]
            );
            if($label != false || $label != null)
            {
                $red2 = $label->labelRed;
                $yellow2 = $label->labelYellow;
                $green2 = $label->labelGreen;
                $blue2 = $label->labelBlue;
                $status2 = $label->labelStatus;
                $label2 = new Boardlabelcard();
                $label2->insertBoardLabelCard($boardId,$cardIdAkhir,$red2,$yellow2,$green2,$blue2,$status2);
            }
            $attachment = Boardattachment::find(
                [
                    "conditions"=>"cardId='".$cardId."' and attachmentStatus='1'"
                ]
            );
            foreach($attachment as $att)
            {
                $title2 = $att->attachmentTitle;
                $directory2 = $att->attachmentDirectory;
                $status2 = $att->attachmentStatus;
                $attachment2 = new Boardattachment();
                $attachment2->insertBoardAttachment($boardId,$cardIdAkhir,$title2,$directory2,$status2);
            }
            $checklist = Boardchecklist::find(
                [
                    "conditions"=>"cardId='".$cardId."' AND checklistStatus='1'"
                ]
            );
            foreach($checklist as $check)
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
                           "conditions"=>"checklistId='".$idChecklist."' and itemStatus='1'"  
                    ]
                ); 
                foreach($item as $i)
                {
                    $title3 = $i->itemTitle;
                    $checked3 = $i->itemChecked;
                    $status3 = $i->itemStatus;
                    $item2 = new Boardchecklistitem(); 
                    $item2->insertBoardChecklistItem($id,$cardIdAkhir,$title3,$checked3,$status3);
                }
            }
            //item
            $start = Boardstartdate::findFirst(
                [
                    "conditions"=>"cardId='".$cardId."' AND startDateStatus='1'"
                ]
            );
            if($start != null || $start != false)
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
            $due = Boardduedate::findFirst(
                [
                    "conditions"=>"cardId='".$cardId."' AND dueDateStatus='1'"
                ]
            );
            if($due != null || $due != false)
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
            $arr = array(
                'cardId'=> $cardIdAkhir,
                'cardTitle'=>$title,
                'label'=>$label
            );
            array_push($arrCard,$arr);
        }
        $datas = array(
            'listId'=>$listTujuan,
            'card'=>$arrCard
        );
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $message = $userNameNotification." copied a list called ".$title;
        $status = "1";
        $notification->insertBoardNotification($id,$userId,$message,$status);
        $this->view->disable();
        echo json_encode($datas);
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $message = $userNameNotification." archived a list called ".$list2->listTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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

    public function getCardDetailsAction()
    {
        $cardId = $_POST["id"];
        $boardId = $_POST["boardId"];
        $cardTitle = "";
        $cardDescription = "";
        $listTitle = "";
        $data = array();
        function getProfile($userId)
        {
            $profile = Userprofile::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $profile;
        }
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
        //header
        $data = array(
            'cardId'            => $cardId, 
            'cardTitle'         => $cardTitle,
            'cardDescription'   => $cardDescription,
            'cardListId'        => $cardListId,
            'listTitle'         => $listTitle
        );
        $datas[] = $data;
        //assign member
        $dataAssign = [];
        $member = Boardmember::find(
            [
                "conditions" => "boardId='".$boardId."' AND memberStatus='1'"
            ]
        );
        foreach($member as $member)
        {
            $profile = Userprofile::findFirst(
                [
                    "userId='".$member->userId."'"
                ]  
            );
            $assign = Boardassignmembers::findFirst(
                [
                    "cardId='".$cardId."' and userId='".$member->userId."'"
                ]
            );
            $check = "false";
            if($assign != null && $assign->assignChecked == "1")
            {
                $check = "true";
            }
            $arr = array(
                'userId' => $profile->userId,
                'userImage' => $profile->userImage,
                'userName' => $profile->userName,
                'checked' => $check,
                'memberStatus' => $member->memberStatus
            );
            array_push($dataAssign,$arr);
        }
        

        //label card
        $label = Boardlabelcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        //start date
        $startDate = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        //due date
        $dueDate = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        //checklist
        $assChecklist = [];
        $checklist = Boardchecklist::find(
            [
                "conditions"=>"cardId='".$cardId."' AND checklistStatus='1'"
            ]
        );
        foreach($checklist as $checklist)
        {
            $checklistId = $checklist->checklistId;
            $checklistTitle = $checklist->checklistTitle;
            $checklistStatus = $checklist->checklistStatus;
            $arrItem = array();
            $item = Boardchecklistitem::find(
                [
                    "conditions"=>"checklistId='".$checklistId."' AND itemStatus='1'"
                ]
            );
            foreach($item as $item)
            {
                $itemId = $item->itemId;
                $itemTitle = $item->itemTitle;
                $itemChecked = $item->itemChecked;
                $itemStatus = $item->itemStatus;
                $arrItem2 = array(
                    'itemId'=>$itemId,
                    'itemTitle'=>$itemTitle,
                    'itemChecked'=>$itemChecked,
                    'itemStatus'=>$itemStatus
                );
                array_push($arrItem,$arrItem2);
            }
            $arr = array(
                'checklistId'=>$checklistId,
                'checklistTitle'=>$checklistTitle,
                'checklistStatus'=>$checklistStatus,
                'item'=>$arrItem
            );
            array_push($assChecklist,$arr);
        }
        //comment
        $assComment = [];
        $comment = Boardcomment::find(
            [
                "conditions"=>"cardId='".$cardId."' AND commentStatus='1'"
            ]
        );
        foreach($comment as $comment)
        {
            $commentId = $comment->commentId;
            $commentUserId = $comment->userId;
            $commentText = $comment->commentText;
            $commentStatus = $comment->commentStatus;
            $userProfile = getProfile($comment->userId);
            $commentName = $userProfile->userName;
            $commentDirectory = $userProfile->userImage;
            $arrReply = array();
            $reply = Boardreplycomment::find(
                [
                    "conditions"=>"commentId='".$commentId."' and replyStatus='1'"
                ]
            );
            foreach($reply as $reply)
            {
                $replyId = $reply->replyId;
                $replyUserId = $reply->userId;
                $replyText = $reply->replyText;
                $replyStatus = $reply->replyStatus;
                $replyUserProfile = getProfile($reply->userId);
                $replyName = $replyUserProfile->userName;
                $replyDirectory = $replyUserProfile->userImage;
                $arr = array(
                    "replyId"=>$replyId,
                    "replyUserId"=>$replyUserId,
                    "replyText"=>$replyText,
                    "replyStatus"=>$replyStatus,
                    "replyName"=>$replyName,
                    "replyDirectory"=>$replyDirectory
                ); 
                array_push($arrReply,$arr);
            }
            $arrComment = array(
                "commentId"=>$commentId,
                "commentUserId"=>$commentUserId,
                "commentText"=>$commentText,
                "commentStatus"=>$commentStatus,
                "commentName"=>$commentName,
                "commentDirectory"=>$commentDirectory,
                "commentReply"=>$arrReply
            );
            array_push($assComment,$arrComment);
        }
        //attachment
        $attachment = Boardattachment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        //move card
        $list   = Boardlist::find(
            [
                "listBoardId='".$boardId."'",
                "order"=> "listPosition ASC"
            ]
        );
        $myarray = array("header"=>$datas,"member"=>$dataAssign,"label"=>$label,"startDate"=>$startDate,"dueDate"=>$dueDate,"checklist"=>$assChecklist,"comment"=>$assComment,"attachment"=>$attachment,"move"=>$list);

        $this->view->disable();
        echo json_encode($myarray);
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
                "conditions" => "boardId='".$boardId."' AND memberStatus='1'"
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
        $user = User::findFirst(
            [
                "userId='".$userId."'"    
            ]  
        );
        $name = $user->userName;
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
        $boardId = $_POST["boardId"];
        $cardId = $_POST["id"];
        $checked = "0";
        $status = "1";
        $date = $_POST["date"]; // 7 March, 2018
        $date2 = $date;
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." created a start date on ".$cardNotif->cardTitle." at ".$date2;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $boardId = $_POST["boardId"];
        $cardId = $_POST["id"];
        $checked = "0";
        $status = "1";
        $date = $_POST["date"]; // 7 March, 2018
        $date2 = $date;
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." created a due date on ".$cardNotif->cardTitle." at ".$date2;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        $this->view->disable();
        echo $boardId;

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
        $boardId        = $_POST["boardId"];
        $cardId         = $_POST["id"];
        $title          = $_POST["title"];
        $status         = "1";
        $checklist      = new Boardchecklist();
        $index          = $checklist->countChecklist();
        $id             = "BCL".str_pad($index,5,'0',STR_PAD_LEFT);
        $checklist->insertBoardChecklist($cardId,$title,$status);
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." created a checklist on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $boardId = $_POST["boardId"];
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." archived a card called ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function sendBackCardAction()
    {
        $boardId = $_POST["boardId"];
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." send back a card from archive with title ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $card = Boardcard::find(
            [
                "conditions"=>"cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1' AND cardPosition>0",
                "order" => "cardPosition ASC"
            ]
        );
        $arrCard = [];
        foreach($card as $card)
        {
            $label = Boardlabelcard::findFirst(
                [
                    "cardId='".$card->cardId."'"
                ]
            );
            $arr = array(
                'card'=>$card,
                'label'=>$label,
            );
            array_push($arrCard,$arr);
        }
        $datas = array(
            'listTitle'=>$title,
            'cardList'=>$arrCard
        );
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $message = $userNameNotification." send back a list called ".$title;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        $this->view->disable();
        echo json_encode($datas);
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
    public function getArchiveAction()
    {
        $boardId = $_POST["boardId"];
        $archive = "1";
        $status = "1";        
        $card = Boardcard::find(
            [
                "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='".$archive."' AND cardStatus='".$status."'"
            ]
        );
        $list = Boardlist::find(
            [
                "conditions"=>"listBoardId='".$boardId."' AND listArchive='".$archive."' AND listStatus='".$status."'"
            ]
        );
        $this->view->disable();
        $datas = array(
            "card"=>$card,
            "list"=>$list
        );
        echo json_encode($datas);
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
        $user = Userprofile::findFirst(
            [
                "userId='".$userId."'"    
            ]    
        );
        $data["user"] = $user;
        $data["id"] = $id;
        echo json_encode($data);
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
        $user = Userprofile::findfirst(
            [
                "userId='".$userId."'"
            ]
        );
        $chat->insertBoardChat($boardId,$userId,$chatText,$status);
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
          );
        $pusher = new Pusher\Pusher(
            '2f8c2f49f896f24ad17c',
            'f3e9abf675e5f559db4c',
            '551465',
            $options
          );
        $data["user"] = $user;
        $data["boardId"] = $boardId;
        $data['text'] = $chatText;
        $pusher->trigger('my-channel', 'my-event', $data);
        $this->view->disable();
        echo json_encode($user);
    }

    public function getChatAction()
    {
        $boardId = $_POST["boardId"];
        $chat = array();
        $chat = Boardchat::find(
            [
                "conditions"=>"boardId='".$boardId."' and chatStatus='1'",
                "order"=>"chatCreated DESC"
            ]
        );
        $datas = array();
        foreach($chat as $c)
        {
            $userId = $c->userId;
            $user = Userprofile::findFirst(
                [
                    "userId='".$userId."'"      
                ]
            );
            $userName = $user->userName;
            $userImage = $user->userImage;
            $arr = array(
                "userName"=>$userName,
                "userImage"=>$userImage,
                "chat"=>$c
            );
            array_push($datas,$arr);
        }
        $this->view->disable();
        echo json_encode($datas);
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." created an attachment on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        echo $id;
    }

    public function dropboxAction()
    {
        set_time_limit(0);
        $link = $_POST["link"];
        $name = $_POST["name"];
        $boardId = $_POST["boardId"];
        $cardId = $_POST["cardId"];
        $extension = $_POST["extension"];
        $url = file_get_contents( $link );
        $attachment = new Boardattachment();
        $index      = $attachment->countAttachment();
        $id         = "BAT".str_pad($index,5,'0',STR_PAD_LEFT);
        $directory  = "userAttachment/".$id.".".$extension;
        $title = $name;
        $status = "1";
        $attachment->insertBoardAttachment($boardId,$cardId,$title,$directory,$status);
        file_put_contents($directory, $url);
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." created an attachment on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        $this->view->disable();
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
        $boardId    = $_POST["boardId"];
        $userId     = $_POST["userId"];
        $board      = array();
        $board      = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $member = Boardmember::findFirst(
            [
                "conditions"=>"boardId='".$boardId."' AND userId='".$userId."'"
            ]
        );
        $favorite = $member->favoriteChecked;
        $subscribe = $member->subscribeChecked;
        $arr = array(
            "board" => $board,
            "favorite" => $favorite,
            "subscribe"=>$subscribe
        );
        $this->view->disable();
        echo json_encode($arr);
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
                "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1' AND listPosition > 0",
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
            if($ctr < $diff)
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

    public function sortListPositionAction()
    {
        $boardId = $_POST["boardId"];
        $listId = $_POST["listId"];
        $posTujuan = $_POST["posTujuan"];
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $posAwal = $list->listPosition;


        $list2 = Boardlist::find(
            [
                "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1' AND listPosition > 0",
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
        foreach($list2 as $l)
        {
            if($ctr < $diff)
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
        $boardId = $_POST["boardId"];
        $attachmentId = $_POST["id"];
        $attachment = Boardattachment::findFirst(
            [
                "attachmentId='".$attachmentId."'"
            ]
        );
        $attachment->deleteAttachment($attachmentId);
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$attachment->cardId."'"
            ]
        );
        $message = $userNameNotification." removed an attachment on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $boardId = $_POST["boardId"];
        $checklistId = $_POST["id"];
        $checklist = Boardchecklist::findFirst(
            [
                "checklistId='".$checklistId."'"
            ]
        );
        $checklist->deleteChecklist($checklistId);
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$checklist->cardId."'"
            ]
        );
        $message = $userNameNotification." removed an checklist on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $boardId = $_POST["boardId"];
        $cardId = $_POST["id"];
        $date = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $date->deleteStartDate($cardId);
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." removed an start date on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $boardId = $_POST["boardId"];
        $cardId = $_POST["id"];
        $date = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $date->deleteDueDate($cardId);
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $cardNotif = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $message = $userNameNotification." removed an due date on ".$cardNotif->cardTitle;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
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
        $member = Boardmember::findFirst(
            [
                "conditions"=>"boardId='".$boardId."' AND userId='".$userId."'"
            ]
        );
        $member->favoriteChecked = $check;
        $member->save();
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
        $member = Boardmember::findFirst(
            [
                "conditions"=>"boardId='".$boardId."' AND userId='".$userId."'"
            ]
        );
        $member->subscribeChecked = $check;
        $member->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function getGanttChartAction()
    {
        $boardId = $_POST["boardId"];
        $list = Boardlist::find(
            [
                "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'"
            ]
        );
        $datas = [];
        foreach($list as $list)
        {
            $listId = $list->listId;
            $card = Boardcard::find(
                [
                    "conditions"=>"cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1'"
                ]
            );
            $arrCard = [];            
            foreach($card as $card)
            {
                $cardId = $card->cardId;
                $start = Boardstartdate::findFirst(
                    [   
                        "conditions" => "cardId='".$cardId."' AND startDateStatus='1'"
                    ]
                );
                $due = Boardduedate::findFirst(
                    [
                        "conditions"=>"cardId='".$cardId."' AND dueDateStatus='1'"
                    ]
                );
                $checklist = Boardchecklist::find(
                    [
                        "conditions"=>"cardId='".$cardId."' AND checklistStatus='1'"
                    ]
                );
                $arrChecklist = [];
                foreach($checklist as $checklist)
                {
                    $checklistId = $checklist->checklistId;
                    $item = Boardchecklistitem::find(
                        [
                            "conditions"=>"checklistId='".$checklistId."' AND itemStatus='1'"
                        ]
                    );
                    $arr = array(
                        'checklist' =>$checklist,
                        'item'=>$item
                    );
                    array_push($arrChecklist,$arr);
                }
                $arrC = array(
                    'card'=>$card,
                    'startDate'=>$start,
                    'dueDate'=>$due,
                    'checklist'=>$arrChecklist
                );
                array_push($datas,$arrC);
            }
        }
        $this->view->disable();
        echo json_encode($datas);
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
        //notif
        $notification = new Boardnotification();
        $userId = $this->session->get("userId");
        $userNotification = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $userNameNotification = $userNotification->userName;
        $message = $userNameNotification." created a progress date on ".$date;
        $status = "1";
        $notification->insertBoardNotification($boardId,$userId,$message,$status);
        $this->view->disable();
        echo "Berhasil";
    }
    public function getProgressAction()
    {
        $boardId = $_POST["boardId"];
        $date = Boardprogressdate::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $item = Boardprogressitem::find(
            [
                "conditions"=>"boardId='".$boardId."' AND itemStatus='1'"
            ]
        );
        $datas = array(
            "date"=>$date,
            "item"=>$item
        );
        $this->view->disable();
        echo json_encode($datas);
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
    public function getRoleCollaboratorClientAction()
    {
        $boardId = $_POST["boardId"];
        $collaborator = Boardrolecollaborator::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $client = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $datas = array(
            "collaborator"=>$collaborator,
            "client"=>$client
        );
        $this->view->disable();
        echo json_encode($datas);

    }

    public function setRoleCollaboratorClientAction()
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
        $coll = Boardrolecollaborator::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $coll->setRoleCollaborator($boardId,$collListCreate,$collListEdit,$collListDelete,$collCardCreate,$collCardEdit,$collCardDelete,$collActAM,$collActLabel,$collActCheck,$collActStart,$collActDue,$collActAtt);
        $cli = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $cli->setRoleClient($boardId,$cliListCreate,$cliListEdit,$cliListDelete,$cliCardCreate,$cliCardCreate,$cliCardDelete,$cliActAM,$cliActLabel,$cliActCheck,$cliActStart,$cliActDue,$cliActAtt);
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

    public function createPDFAction($boardId)
    {
        set_time_limit(0);
        $boardId = $boardId;
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );

        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        function getBoardMember($boardId)
        {
            $bm = Boardmember::find(
                [
                    "conditions" => "boardId='".$boardId."' AND memberStatus='1'"
                ]
            );
            return $bm;
        }
        function getBoardList($boardId)
        {
            $list = Boardlist::find(
                [
                    "conditions" => "listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'",
                    "order" => "listPosition ASC"
                ]
            );
            return $list;
        }
        function getBoardCard($listId)
        {
            $card = Boardcard::find(
                [
                    "conditions" => "cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1'",
                    "order" => "cardPosition ASC"
                ]
            );
            return $card;
        }
        function getStartDate($cardId)
        {
            $date = Boardstartdate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND startDateStatus='1'"
                ]
            );
            return $date;
        }
        function getDueDate($cardId)
        {
            $date = Boardduedate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND dueDateStatus='1'"
                ]
            );
            return $date;
        }
        function getChecklist($cardId)
        {
            $checklist = Boardchecklist::find(
                [
                    "conditions" => "cardId='".$cardId."' AND checklistStatus='1'"
                ]
            );
            return $checklist;
        }
        function getChecklistItem($checklistId)
        {
            $item = Boardchecklistitem::find(
                [
                    "conditions" => "checklistId='".$checklistId."' AND itemStatus = '1'"
                ]
            );
            return $item;
        }
        $this->view->disable();
        $creator = getUser($board->boardOwner);
        $creator_name = $creator->userName;
        $pd = getProgressDate($boardId);
        if($pd == null)
            $pd = "";
        else
            $pd = date_format(new DateTime($pd->date),"d M Y");
        $pi = getProgressItem($boardId);
        $pi_string = "";
        $pi_count = 0;
        if($pi != null)
        {
            $pi_total = 0;
            $pi_checked = 0;
            foreach($pi as $item)
            {
                if($item->itemChecked == "1")
                {
                    $pi_string .= '<input type="checkbox" checked="checked"> '.$item->itemTitle."<br>";
                    $pi_checked++;
                }
                else
                    $pi_string .= '<input type="checkbox"> '.$item->itemTitle."<br>";

                $pi_total++;
            }
            $pi_count = $pi_checked*100/$pi_total;
        }
        $bm = getBoardMember($boardId);
        $bm_string = "";
        if($bm != null)
        {
            foreach($bm as $member)
            {
                $userId = $member->userId;
                $user = getUser($userId);
                $bm_string .= "- ".$user->userName." (".$member->memberRole.")<br>";
            }
        }
        $list = getBoardList($boardId);
        $list_string = "";
        $list_count = 0;
        if($list != null)
        {
            $list_string .='<div class="row">';
            foreach($list as $l)
            {
                $listId = $l->listId;
                $list_string .= '
                    <div class="list">
                        <p class="center-align" style="margin:auto;"><b>'.$l->listTitle.'</b></p>
                        <hr style="margin-top:-1px;">';
                $card = getBoardCard($listId);
                if($card != null)
                {
                    
                    foreach($card as $c)
                    {
                        $list_string .="<div class='card'>";
                        $list_string .= "<b>".$c->cardTitle.'</b><br>';
                        if($c->cardDescription != null)
                        {
                            $list_string .= $c->cardDescription.'<br>';
                        }
                        $sd = getStartDate($c->cardId);
                        $dd = getDueDate($c->cardId);
                        if($sd!= null)
                        {
                            if($sd->startDateChecked == '1')
                                $list_string .= "Start date : <input type='checkbox' checked='checked'>".date_format(new DateTime($sd->startDate),"d M Y")."<br>";
                            else
                                $list_string .= "Start date : <input type='checkbox'>".date_format(new DateTime($sd->startDate),"d M Y")."<br>";
                        }
                        if($dd!= null)
                        {
                            if($dd->dueDateChecked == '1')
                                $list_string .= "Due date : <input type='checkbox' checked='checked'>".date_format(new DateTime($dd->dueDate),"d M Y")."<br>";
                            else
                                $list_string .= "Due date : <input type='checkbox'>".date_format(new DateTime($dd->dueDate),"d M Y")."<br>";
                        }
                        $checklist = getChecklist($c->cardId);
                        if($checklist != null)
                        {
                            foreach($checklist as $check)
                            {
                                $checklist_string = "";
                                //$list_string .= $check->checklistTitle." - "."0%"."<br>";
                                $item = getChecklistItem($check->checklistId);
                                $itemCount = 0;
                                if($item != null)
                                {
                                    $itemTotal = 0;
                                    $itemChecked = 0;
                                    $item_string = "";
                                    foreach($item as $i)
                                    {
                                        if($i->itemChecked == '1')
                                        {
                                            $item_string .= "<input type='checkbox' checked='checked'>".$i->itemTitle."<br>";
                                            $itemChecked++;
                                        }
                                        else
                                        {
                                            $item_string .= "<input type='checkbox'>".$i->itemTitle."<br>";
                                        }
                                        $itemTotal++;
                                    }
                                    $itemCount = $itemChecked*100/$itemTotal;
                                }
                                $checklist_string .= $check->checklistTitle." - ".$itemCount."%"."<br>";
                                $checklist_string .= $item_string;
                                $list_string .= $checklist_string; 
                            }
                        }
                        $list_string .="</div>";
                        //$list_string .= "<p class='left-align' style='margin:auto;font-size:10px;'>".$c->cardTitle."</p>";
                    }
                }



                $list_string.='</div>';
                $list_count++;
                if($list_count > 0 && $list_count%4==0)
                {
                    $list_string .= '</div>';
                    $list_string .='<div class="row">';
                }
            }
            $list_string .= '</div>';
        }
        $mpdf = new \Mpdf\Mpdf();
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        $stylesheet = '';
        $stylesheet .= '
            @page
            {
                margin:20px;
            }
            .title{
                font-weight:bold;
                font-size:24px;
                text-align:center;
            }
            .divTitle
            {
                width:100%;
                float:left;
            }
            .row
            {
                width:100%;
                float:left;
            }
            p
            {
                font-size:12px;
            }
            .col
            {
                width:50%;
                float:left;
            }
            ul.b 
            {
                list-style-type: square;
                padding:0;
                margin:0;
            }
            li
            {
                font-size:12px;
            }
            .list
            {
                width:23%;
                float:left;
                margin-left:5px;
                margin-bottom:5px;
                border:1px solid black;
                height:90px;
            }
            .center-align
            {
                text-align:center;
            }
            .left-align
            {
                text-align:left;
            }
            .card
            {
                width:95%;
                height:75px;
                margin-bottom:5px;
                margin-left:auto;
                margin-right:auto;
                border: 1px solid black;
                float:left;
                font-size:10px;
                padding:2px;
            }
        ';
        $html = '';
        $html .= '<div class="divTitle"><h1 class="title">'.'Taff.top'.'</h1></div>';
        $html .= '<hr>';
        $html .= '  <div class="row" style="margin-top:-15px;">
                        <div class="col">
                            <p><b>Board details</b><br>
                            Title : '.$board->boardTitle.'<br>
                            Creator : '.$creator_name.'<br>
                            Created : '.date_format(new DateTime($b->boardCreated),"d M Y").'<br>
                            Deadline : '.$pd.'<br>
                            Progress : '.$pi_count.'%'.'<br>'
                            .$pi_string.'</p>'.
                        '</div>
                        <div class="col">
                            <p><b>Members</b><br>
                            '.$bm_string.'
                            </p>
                        </div>'. 
                    '</div>';
        $html .= '<hr>';
        if($list_count != 0)
        {
            $html .= $list_string;
        }

        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html,2);
        $filename = $board->boardTitle.".pdf";
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    }

    public function createExcelAction($boardId)
    {
        set_time_limit(0);
        $boardId = $boardId;
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );

        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        function getBoardMember($boardId)
        {
            $bm = Boardmember::find(
                [
                    "conditions" => "boardId='".$boardId."' AND memberStatus='1'"
                ]
            );
            return $bm;
        }
        function getBoardList($boardId)
        {
            $list = Boardlist::find(
                [
                    "conditions" => "listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'",
                    "order" => "listPosition ASC"
                ]
            );
            return $list;
        }
        function getBoardCard($listId)
        {
            $card = Boardcard::find(
                [
                    "conditions" => "cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1'",
                    "order" => "cardPosition ASC"
                ]
            );
            return $card;
        }
        function getStartDate($cardId)
        {
            $date = Boardstartdate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND startDateStatus='1'"
                ]
            );
            return $date;
        }
        function getDueDate($cardId)
        {
            $date = Boardduedate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND dueDateStatus='1'"
                ]
            );
            return $date;
        }
        function getChecklist($cardId)
        {
            $checklist = Boardchecklist::find(
                [
                    "conditions" => "cardId='".$cardId."' AND checklistStatus='1'"
                ]
            );
            return $checklist;
        }
        function getChecklistItem($checklistId)
        {
            $item = Boardchecklistitem::find(
                [
                    "conditions" => "checklistId='".$checklistId."' AND itemStatus = '1'"
                ]
            );
            return $item;
        }
        $creator = getUser($board->boardOwner);
        $creator_name = $creator->userName;
        $pd = getProgressDate($boardId);
        if($pd == null)
            $pd = "";
        else
            $pd = date_format(new DateTime($pd->date),"d M Y");
        $pi = getProgressItem($boardId);
        $pi_string = "";
        $pi_count = 0;
        if($pi != null)
        {
            $pi_total = 0;
            $pi_checked = 0;
            foreach($pi as $item)
            {
                if($item->itemChecked == "1")
                {
                    $pi_checked++;
                }
                
                $pi_total++;
            }
            $pi_count = $pi_checked*100/$pi_total;
        }
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Taff.top')
            ->setLastModifiedBy('Taff.top')
            ->setTitle('Office Taff')
            ->setSubject('Office Taff')
            ->setDescription('Taff.top report.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Report');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Taff.top')
            ->setCellValue('A2', 'Title : '.$board->boardTitle)
            ->setCellValue('A3', 'Creator :'.$creator_name)
            ->setCellValue('A4', 'Created :'.date_format(new DateTime($board->boardCreated),"d M Y"))
            ->setCellValue('A5', 'Deadline :'.$pd)
            ->setCellValue('A6', 'Progress : '.$pi_count.'%');

        $ctr = 7;
        foreach($pi as $item)
        {
            if($item->itemChecked == "1")
            {
                $spreadsheet->setActiveSheetIndex(0)->getCell('A'.$ctr)->setValue('[X]'.$item->itemTitle);
            }
            else
            {
                $spreadsheet->setActiveSheetIndex(0)->getCell('A'.$ctr)->setValue('[ ]'.$item->itemTitle);
            }
            $ctr++;
        }
        $temp = 3;
        $huruf = ["E","G","I"];
        $spreadsheet->setActiveSheetIndex(0)->getCell('E2')->setValue('Members');
        $bm = getBoardMember($boardId);
        if($bm != null)
        {
            $indeks = 0;
            foreach($bm as $member)
            {
                $userId = $member->userId;
                $user = getUser($userId);
                $bm_string = $user->userName." (".$member->memberRole.")";
                $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[$indeks].$temp)->setValue($bm_string);
                if($temp <= $ctr)
                {
                    $temp++;
                }
                else
                {
                    $temp = 3;
                    $indeks++;
                }
            }
        }

        $ctr+=1;
        $ctrawal = $ctr;
        $huruf2 = ["A","E","J","M","Q","U","Y","AC","AG","AK","AO","AS","AW","BA","BE","BI","BM","BQ","BU","BY","CC","CG","CK","CO","CS","CW","DA","DE","DI","DM","DQ","DU","DY","EC","EG","EK"];
        $list = getBoardList($boardId);
        $indeks = 0;
        $temp = $ctrawal;
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        foreach($list as $l)
        {
            //$sheet ->getStyle('B2:G8')->applyFromArray($styleArray);
            $list_id = $l->listId;
            $list_title = $l->listTitle;
            $card = getBoardCard($list_id);
            foreach($card as $card)
            {
                $ctr++;
                $start = $temp;
                $cardId = $card->cardId;
                $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue($card->cardTitle." (in list ".$list_title.")");
                if($card->cardDescription != null || $card->cardDescription != "")
                {
                    $temp++;
                    $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue($card->cardDescription);
                }

                $sd = getStartDate($cardId);
                $dd = getDueDate($cardId);
                if($sd != null)
                {
                    $temp++;
                    $checked = " ";
                    if($sd->startDateChecked == "1")
                        $checked = "X";
                    $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue("Start Date : [".$checked."]".date_format(new DateTime($sd->startDate),"d M Y"));
                }
                if($dd != null)
                {
                    $temp++;
                    $checked = " ";
                    if($dd->dueDateChecked == "1")
                        $checked = "X";
                    $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue("Due Date : [".$checked."]".date_format(new DateTime($dd->dueDate),"d M Y"));
                }
                $checklist = getChecklist($cardId);
                if($checklist != null)
                {
                    foreach($checklist as $check)
                    {
                        $checklist_string = "";
                        //$list_string .= $check->checklistTitle." - "."0%"."<br>";
                        $item = getChecklistItem($check->checklistId);
                        $temp++;
                        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue($check->checklistTitle);
                        $itemCount = 0;
                        if($item != null)
                        {
                            $itemTotal = 0;
                            $itemChecked = 0;
                            //$item_string = "";
                            foreach($item as $i)
                            {
                                $checked = " ";
                                if($i->itemChecked =="1")
                                {
                                    $checked = "X";
                                }
                                $temp++;
                                $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue("[".$checked."]".$i->itemTitle);
                                /*if($i->itemChecked == '1')
                                {
                                    //$item_string .= "<input type='checkbox' checked='checked'>".$i->itemTitle."<br>";
                                    $itemChecked++;
                                }
                                else
                                {
                                    //$item_string .= "<input type='checkbox'>".$i->itemTitle."<br>";
                                }
                                $itemTotal++;*/
                            }
                            //$itemCount = $itemChecked*100/$itemTotal;
                        }
                        //$checklist_string .= $check->checklistTitle." - ".$itemCount."%"."<br>";
                        //$checklist_string .= $item_string;
                        //$list_string .= $checklist_string; 
                    }
                }
                $akhir = $temp;
                $styleArray = [
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];
                //$spreadsheet->getStyle('A'.$start.':A'.$akhir)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A'.$start.':E'.$akhir)->applyFromArray($styleArray);
                $temp+=2;
            }
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="taff.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }

    public function createInviteAction()
    {
        $boardId = $_POST["boardId"];
        $email = $_POST["email"];
        $role = $_POST["role"];
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

        $mail->Host     = 'silver.hidden-server.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'admin@taff.top';                 // SMTP username
        $mail->Password = 'Cancan110796';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port     = 465;
        
        $mail->setFrom('admin@taff.top', 'Taff');
        $mail->addAddress($email);
        $mail->Subject = 'Invitation from Taff.top';
        $mail->isHTML(true);
        $mail->Body = 'You have been invited to a board in taff.top<br>
                        to join the board click the link <a href="http://www.taff.top/invite/getInvite/'.$boardId.'/'.$role.'">here</a> or copy this link.<br>
                        http://www.taff.top/invite/getInvite/'.$boardId.'/'.$role;
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function removeMemberAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $bm = Boardmember::findFirst(
            [
                "conditions" => "boardId='".$boardId."' and userId='".$userId."'"
            ]
        );
        $bm->memberStatus = '0';
        $bm->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function updateMemberRoleAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $role = $_POST["role"];
        $bm = Boardmember::findFirst(
            [
                "conditions" => "boardId='".$boardId."' and userId='".$userId."'"
            ]
        );
        $bm->memberRole = $role;
        $bm->save();
        $this->view->disable();
        echo "Berhasil";
    }


}


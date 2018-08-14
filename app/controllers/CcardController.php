<?php

class CcardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $link = "js/plugins/data-tables/css/jquery.dataTables.min.css";
        $this->assets->addCss($link);
        $cardId = "";
        if(isset($_GET["id"]))
        {
            $cardId = $_GET["id"];
        }
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $assign = Boardassignmembers::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $user = User::find();
        $attachment = Boardattachment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $label = Boardlabelcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $startDate = Boardstartdate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $dueDate = Boardduedate::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $checklist = Boardchecklist::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $item = Boardchecklistitem::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $comment = Boardcomment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $reply = Boardreplycomment::find(
            [
                "cardId='".$cardId."'"
            ]
        );
        $this->view->reply = $reply;
        $this->view->comment = $comment;
        $this->view->checklist = $checklist;
        $this->view->dueDate = $dueDate;
        $this->view->startDate = $startDate;
        $this->view->label = $label;
        $this->view->attachment =$attachment;
        $this->view->card = $card;
        $this->view->user = $user;
        $this->view->assign = $assign;
        $this->view->item = $item;
    }

    public function getAssignByIdAction()
    {
        $assignId = $_POST["assignId"];
        $assign = Boardassignmembers::findFirst(
            [
                "assignId='".$assignId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($assign);
    }

    public function setAssignByIdAction()
    {
        $assignId = $_POST["assignId"];
        $userName = $_POST["userName"];
        $assignChecked = $_POST["assignChecked"];
        $assignStatus = $_POST["assignStatus"];
        $assign = Boardassignmembers::findFirst(
            [
                "assignId='".$assignId."'"
            ]
        );
        $assign->userName = $userName;
        $assign->assignChecked = $assignChecked;
        $assign->assignStatus = $assignStatus;
        $assign->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function createAssignAction()
    {
        $userId = $_POST["userId"];
        $cardId = $_POST["cardId"];
        $assign = Boardassignmembers::findFirst(
            [
                "conditions"=>"cardId='".$cardId."' AND userId='".$userId."'"
            ]
        );
        if($assign == null)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            $userName = $user->userName;
            $checked = "0";
            $status = "1";
            $newAssign = new Boardassignmembers();
            $newAssign->insertBoardAssignMembers($cardId,$userId,$userName,$checked,$status);
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function getAttachmentByIdAction()
    {
        $attachmentId = $_POST["attachmentId"];
        $attachment = Boardattachment::findFirst(
            [
                "attachmentId='".$attachmentId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($attachment);
    }

    public function saveAttachmentByIdAction()
    {
        $attachmentId = $_POST["attachmentId"];
        $attachmentTitle = $_POST["attachmentTitle"];
        $attachmentStatus = $_POST["attachmentStatus"];
        $attachment = Boardattachment::findFirst(
            [
                "attachmentId='".$attachmentId."'"
            ]
        );
        $attachment->attachmentTitle = $attachmentTitle;
        $attachment->attachmentStatus = $attachmentStatus;
        $attachment->save();
        $this->view->disable();
        echo "Berhasil";
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
        echo "Berhasil";
    }

    public function saveLabelCardAction()
    {
        $cardId = $_POST["cardId"];
        $boardId = $_POST["boardId"];
        $labelRed = $_POST["labelRed"];
        $labelYellow = $_POST["labelYellow"];
        $labelGreen = $_POST["labelGreen"];
        $labelBlue = $_POST["labelBlue"];
        $label = Boardlabelcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        if($label == null)
        {
            $newLabel = new Boardlabelcard();
            $status = "1";
            $newLabel->insertBoardLabelCard($boardId,$cardId,$labelRed,$labelYellow,$labelGreen,$labelBlue,$status);
        }
        else
        {
            $label->labelRed = $labelRed;
            $label->labelYellow = $labelYellow;
            $label->labelGreen = $labelGreen;
            $label->labelBlue = $labelBlue;
            $label->save();
        }
        $this->view->disable();
        echo "Berhasil";

    }

    public function saveStartDateAction()
    {
        $boardId = $_POST["boardId"];
        $cardId = $_POST["cardId"];
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
        $this->view->disable();
        echo "Berhasil";
    }

    public function saveDueDateAction()
    {
        $boardId = $_POST["boardId"];
        $cardId = $_POST["cardId"];
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
        $this->view->disable();
        echo "Berhasil";
    }

    public function getChecklistByIdAction()
    {
        $checklistId = $_POST["checklistId"];
        $checklist = Boardchecklist::findFirst(
            [
                "checklistId='".$checklistId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($checklist);
    }

    public function saveChecklistAction()
    {
        $checklistId = $_POST["checklistId"];
        $checklistTitle = $_POST["checklistTitle"];
        $checklistStatus = $_POST["checklistStatus"];
        $checklist = Boardchecklist::findFirst(
            [
                "checklistId='".$checklistId."'"
            ]
        );
        $checklist->checklistTitle = $checklistTitle;
        $checklist->checklistStatus = $checklistStatus;
        $checklist->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function createChecklistAction()
    {
        $cardId =$_POST["cardId"];
        $checklistTitle = $_POST["checklistTitle"];
        $checklist = new Boardchecklist();
        $status="1";
        $checklist->insertBoardChecklist($cardId,$checklistTitle,$status);
        $this->View->disable();
        echo "Berhasil";
    }

    public function createItemAction()
    {
        $cardId = $_POST["cardId"];
        $checklistId = $_POST["checklistId"];
        $itemTitle = $_POST["itemTitle"];
        $item = new Boardchecklistitem();
        $checked = "0";
        $status = "1";
        $item->insertBoardChecklistItem($checklistId,$cardId,$itemTitle,$checked,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getItemByIdAction()
    {
        $itemId =$_POST["itemId"];
        $item = Boardchecklistitem::findFirst(
            [
                "itemId='".$itemId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($item);
    }

    public function saveItemByIdAction()
    {
        $itemId =$_POST["itemId"];
        $itemTitle = $_POST["itemTitle"];
        $itemChecked = $_POST["itemChecked"];
        $itemStatus = $_POST["itemStatus"];
        $item = Boardchecklistitem::findFirst(
            [
                "itemId='".$itemId."'"
            ]
        );
        $item->itemTitle = $itemTitle;
        $item->itemChecked = $itemChecked;
        $item->itemStatus = $itemStatus;
        $item->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function createCommentAction()
    {
        $cardId = $_POST["cardId"];
        $userId = $_POST["userId"];
        $commentText = $_POST["commentText"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $boardId = $card->cardBoardId;
        $comment = new Boardcomment();
        $status = "1";
        $comment->insertBoardComment($cardId,$boardId,$userId,$commentText,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getCommentByIdAction()
    {
        $commentId =$_POST["commentId"];
        $comment = Boardcomment::findFirst(
            [
                "commentId='".$commentId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($comment);
    }

    public function saveCommentByIdAction()
    {
        $commentId =$_POST["commentId"];
        $commentText = $_POST["commentText"];
        $commentStatus = $_POST["commentStatus"];
        $comment = Boardcomment::findFirst(
            [
                "commentId='".$commentId."'"
            ]
        );
        $comment->commentText = $commentText;
        $comment->commentStatus = $commentStatus;
        $comment->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function createReplyAction()
    {
        $cardId = $_POST["cardId"];
        $userId = $_POST["userId"];
        $replyText = $_POST["replyText"];
        $commentId = $_POST["commentId"];
        $replyText = $_POST["replyText"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $boardId = $card->cardBoardId;
        $reply = new Boardreplycomment();
        $status = "1";
        $reply->insertBoardReplyComment($commentId,$cardId,$boardId,$userId,$replyText,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getReplyByIdAction()
    {
        $replyId =$_POST["replyId"];
        $reply = Boardreplycomment::findFirst(
            [
                "replyId='".$replyId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($reply);
    }

    public function saveReplyByIdAction()
    {
        $replyId = $_POST["replyId"];
        $replyText = $_POST["replyText"];
        $replyStatus = $_POST["replyStatus"];
        $reply = Boardreplycomment::findFirst(
            [
                "replyId='".$replyId."'"
            ]
        );
        $reply->replyText = $replyText;
        $reply->replyStatus = $replyStatus;
        $reply->save();
        $this->view->disable();
        echo "Berhasil";
    }

}


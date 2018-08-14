<?php

class CboardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $link = "js/plugins/data-tables/css/jquery.dataTables.min.css";
        $this->assets->addCss($link);
        $boardId = "";
        if(isset($_GET["id"]))
        {
            $boardId = $_GET["id"];
        }
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $member = Boardmember::find(
            [
                "conditions"=>"boardId='".$boardId."'"
            ]
        );
        $coll = Boardrolecollaborator::findFirst(
            [
                "conditions"=>"boardId='".$boardId."'"
            ]
        );
        $cli = Boardroleclient::findFirst(
            [
                "conditions"=>"boardId='".$boardId."'"
            ]
        );
        $pdate = Boardprogressdate::findFirst(
            [
                "conditions"=>"boardId='".$boardId."'"
            ]
        );
        $pitem = Boardprogressitem::find(
            [
                "conditions"=>"boardId='".$boardId."'"
            ]
        );
        $user = User::find();
        $this->view->user = $user;
        $this->view->pitem = $pitem;
        $this->view->pdate = $pdate;
        $this->view->boardId = $boardId;
        $this->view->cli = $cli;
        $this->view->coll = $coll;
        $this->view->member = $member;
        $this->view->list = $list;
        $this->view->card = $card;
    }

    public function getMemberByIdAction()
    {
        $memberId = $_POST["memberId"];
        $member = Boardmember::findFirst(
            [
                "memberId='".$memberId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($member);
    }

    public function setMemberByIdAction()
    {
        $memberId = $_POST["memberId"];
        $memberRole = $_POST["memberRole"];
        $memberStatus = $_POST["memberStatus"];
        $member = Boardmember::findFirst(
            [
                "memberId='".$memberId."'"
            ]
        );
        $member->memberRole = $memberRole;
        $member->memberStatus = $memberStatus;
        $member->save();
        $this->view->disable();
        echo "Berhasil";

    }

    public function setCollaboratorByIdAction()
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
        $collActCheck   = $_POST["collActChecklist"];
        $collActStart   = $_POST["collActStart"];
        $collActDue     = $_POST["collActDue"];
        $collActAtt     = $_POST["collActAttachment"];
        $coll = Boardrolecollaborator::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $coll->setRoleCollaborator($boardId,$collListCreate,$collListEdit,$collListDelete,$collCardCreate,$collCardEdit,$collCardDelete,$collActAM,$collActLabel,$collActCheck,$collActStart,$collActDue,$collActAtt);
        $this->view->disable();
        echo "Berhasil";
    }

    public function setClientByIdAction()
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
        $cliActCheck    = $_POST["cliActChecklist"];
        $cliActStart    = $_POST["cliActStart"];
        $cliActDue      = $_POST["cliActDue"];
        $cliActAtt      = $_POST["cliActAttachment"];
        $cli = Boardroleclient::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $cli->setRoleClient($boardId,$cliListCreate,$cliListEdit,$cliListDelete,$cliCardCreate,$cliCardCreate,$cliCardDelete,$cliActAM,$cliActLabel,$cliActCheck,$cliActStart,$cliActDue,$cliActAtt);
        $this->view->disable();
        echo "Berhasil";
    }

    public function setProgressDateByIdAction()
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
    }

    public function deleteChatByIdAction()
    {
        $boardId = $_POST["boardId"];
        $chat = Boardchat::find(
            [
                "conditions"=>"boardId='".$boardId."' AND chatStatus='1'"
            ]
        );
        foreach($chat as $c)
        {
            $c->chatStatus ='0';
            $c->save(); 
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function inviteUserByIdAction()
    {
        $boardId = $_POST["boardId"];
        $userId = $_POST["userId"];
        $match = Boardmember::findFirst(
            [
                "conditions" => "boardId='".$boardId."' AND userId='".$userId."'"
            ]
        );
        if($match == null)
        {
            $userId = (string)$userId;
            $bm = new Boardmember();
            $role = $role;
            $status = "1";
            $bm->insertBoardMember($userId,$boardId,$role,$status);
        }
        else
        {
            $match->memberStatus = '1';
            $match->save();
        }
        $this->view->disable();
        echo "Berhasil";
    }

    public function insertItemByIdAction()
    {
        $boardId = $_POST["boardId"];
        $itemTitle = $_POST["itemTitle"];
        $title = $itemTitle;
        $checked = "0";
        $status = "1";
        $item = new Boardprogressitem();
        $item->insertBoardProgressItem($boardId,$title,$checked,$status);
        $this->view->disable();
        echo "Berhasil";
    }

    public function getItemByIdAction()
    {
        $itemId = $_POST["itemId"];
        $item = Boardprogressitem::findFirst(
            [
                "progressItemId='".$itemId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($item);
    }

    public function saveItemByIdAction()
    {
        $itemId = $_POST["itemId"];
        $itemTitle = $_POST["itemTitle"];
        $itemChecked = $_POST["itemChecked"];
        $itemStatus = $_POST["itemStatus"];
        $item = Boardprogressitem::findFirst(
            [
                "progressItemId='".$itemId."'"
            ]
        );
        $item->itemTitle = $itemTitle;
        $item->itemChecked = $itemChecked;
        $item->itemStatus = $itemStatus;
        $item->save();
        $this->view->disable();
        echo "Berhasil";
    }


}


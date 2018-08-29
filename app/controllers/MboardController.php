<?php
use Phalcon\Mvc\Url;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class MboardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $url = new Url();
        $url->setBaseUri('/trello/');
        $link = "js/plugins/data-tables/css/jquery.dataTables.min.css";
        $this->assets->addCss($link);
        $board = Board::find();
        $user = User::find();
        $group = Groupuser::find();
        $this->view->user = $user;
        $this->view->board = $board;
        $this->view->group = $group;
    }

    public function getBoardByIdAction()
    {
        $boardId = $_POST["boardId"];
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($board);
    }

    public function setBoardByIdAction()
    {
        $boardId = $_POST["boardId"];
        $boardOwner = $_POST["boardOwner"];
        $boardTitle = $_POST["boardTitle"];
        $boardCreated = $_POST["boardCreated"];
        $boardGroup = $_POST["boardGroup"];
        $boardClosed = $_POST["boardClosed"];
        $boardStatus = $_POST["boardStatus"];
        $boardBackground =$_POST["boardBackground"];
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );
        $board->setAll($boardOwner,$boardTitle,$boardGroup,$boardClosed,$boardStatus,$boardBackground);
        $this->view->disable();
        echo "Berhasil";
    }

    public function createBoardAction()
    {
        $title = $this->request->getPost("boardTitle");
        $owner = $this->request->getPost("groupId");
        $public = "1";
        $status = '1';
        $background = "blue";
        $group = "0";
        $userId = $this->request->getPost("userId");
        if($owner == "")
        {
            $owner = $userId;
        }
        if(substr($owner,0,1) == "B")
        {
            $group = "0";
            $owner = $userId;
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
                    "groupUserId='".$owner."' AND memberStatus='1'"
                ]
            );
            foreach($groupMember as $g)
            {
                $role = "Creator";
                /*if($g->userId == $userId)
                {
                    $role = "Creator";
                }
                else
                {
                    $role = "Collaborator";
                }*/
                $boardMember = new Boardmember();
                $boardMember->insertBoardMember($g->userId,$id,$role,$status);
            }
            //role collaborator dan client
            $listCreate = "1";
            $listEdit = "1";
            $listDelete = "1";
            $cardCreate = "1";
            $cardEdit = "1";
            $cardDelete = "1";
            $activityAM = "1";
            $activityLabel = "1";
            $activityChecklist = "1";
            $activityStartDate = "1";
            $activityDueDate = "1";
            $activityAttachment = "1";
            $roleStatus = "1";
            $coll = new Boardrolecollaborator();
            $coll->insertBoardRoleCollaborator($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus);

            $client = new Boardroleclient();
            $client->insertBoardRoleClient($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus);
        }
        else
        {
            $role="Creator";
            $boardMember = new Boardmember();
            $boardMember->insertBoardMember($userId,$id,$role,$status);
            //role collaborator dan client
            $listCreate = "1";
            $listEdit = "1";
            $listDelete = "1";
            $cardCreate = "1";
            $cardEdit = "1";
            $cardDelete = "1";
            $activityAM = "1";
            $activityLabel = "1";
            $activityChecklist = "1";
            $activityStartDate = "1";
            $activityDueDate = "1";
            $activityAttachment = "1";
            $roleStatus = "1";
            $coll = new Boardrolecollaborator();
            $coll->insertBoardRoleCollaborator($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus);

            $client = new Boardroleclient();
            $client->insertBoardRoleClient($id,$listCreate,$listEdit,$listDelete,$cardCreate,$cardEdit,$cardDelete,$activityAM,$activityLabel,$activityChecklist,$activityStartDate,$activityDueDate,$activityAttachment,$roleStatus);
        }
        $this->view->disable();
        $this->response->setContent($id);
        return $this->response->send();
    }

    public function checkBoardAction($id)
    {
        $url = new Url();
        $url->setBaseUri('/trello/');
        $link = "js/plugins/data-tables/css/jquery.dataTables.min.css";
        $this->assets->addCss($link);
        $boardId = $id;
        $list = Boardlist::find(
            [
                "conditions" => "listBoardId='".$boardId."'",
                "order"=> "listArchive ASC"
            ]
        );
        $card = Boardcard::find(
            [
                "conditions"=>"cardBoardId='".$boardId."'",
                "order"=>"cardArchive ASC"
            ]
        );
        $member = Boardmember::find(
            [
                "conditions"=>"boardId='".$boardId."'"
            ]
        );
        $this->view->member = $member;
        $this->view->list = $list;
        $this->view->card = $card;
    }

    public function getMemberByIdAction()
    {
        
        echo "ASD";
    }

}


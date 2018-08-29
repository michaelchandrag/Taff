<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class McardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $this->assets->addCss("js/plugins/data-tables/css/jquery.dataTables.min.css");
        $card = Boardcard::find();
        $list = Boardlist::find();
        $user = User::find();
        $this->view->user = $user;
        $this->view->list = $list;
        $this->view->card = $card;
    }

    public function getCardByIdAction()
    {
        $cardId = $_POST["cardId"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($card);
    }

    public function setCardByIdAction()
    {
        $cardId = $_POST["cardId"];
        $cardTitle = $_POST["cardTitle"];
        $cardDescription = $_POST["cardDescription"];
        $cardPosition = $_POST["cardPosition"];
        $cardArchive = $_POST["cardArchive"];
        $cardStatus = $_POST["cardStatus"];
        $card = Boardcard::findFirst(
            [
                "cardId='".$cardId."'"
            ]
        );
        $card->cardTitle = $cardTitle;
        $card->cardDescription = $cardDescription;
        $card->cardPosition = $cardPosition;
        $card->cardArchive = $cardArchive;
        $card->cardStatus = $cardStatus;
        $card->save();
        $this->view->disable();
        echo "Berhasil";
    }

    public function createCardAction()
    {
        $cardTitle = $this->request->getPost("cardTitle");
        $listId = $this->request->getPost("listId");
        $userId = $this->request->getPost("userId");
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $archive       = "0";
        $description    = "";
        $status        = "1";
        $boardId = $list->listBoardId;
        $card = new Boardcard();
        $card->insertBoardCard($listId,$boardId,$userId,$cardTitle,$description,$archive,$status);
        $this->view->disable();
        echo "Berhasil";

    }

}


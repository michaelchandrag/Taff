<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class MlistController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
        $this->assets->addCss("js/plugins/data-tables/css/jquery.dataTables.min.css");
        $list = Boardlist::find();
        $board = Board::find();
        $this->view->board = $board;
        $this->view->list = $list;
    }

    public function getListByIdAction()
    {
        $listId = $_POST["listId"];
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $this->view->disable();
        echo json_encode($list);
    }

    public function setListByIdAction()
    {
        $listId = $_POST["listId"];
        $listTitle = $_POST["listTitle"];
        $listPosition = $_POST["listPosition"];
        $listArchive = $_POST["listArchive"];
        $listStatus = $_POST["listStatus"];
        $list = Boardlist::findFirst(
            [
                "listId='".$listId."'"
            ]
        );
        $list->listTitle = $listTitle;
        $list->listPosition = $listPosition;
        $list->listArchive = $listArchive;
        $list->listStatus = $listStatus;
        $list->save();
        $this->view->disable();
        echo "Berhasil";

    }

    public function createListAction()
    {
        $listTitle = $this->request->getPost("listTitle");
        $boardId = $this->request->getPost("boardId");
        $archive = "0";
        $status = "1";
        $list = new Boardlist();
        $list->insertBoardList($boardId,$listTitle,$archive,$status);
        $this->view->disable();
        echo "Berhasil";
    }
}


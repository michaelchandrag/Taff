<?php
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
class TestBoardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->assets->addCss("css/cssku.css");
        $currentPage = 0;
        if($this->request->getQuery("currentPage"))
        {
            $currentPage = $this->request->getQuery("currentPage");
        }
        $user = User::find();
        $paginator = new PaginatorModel(
            [
                "data"  => $user,
                "limit" => 4,
                "page"  => $currentPage,
            ]
        );
        $page = $paginator->getPaginate();
        $this->view->page = $page;
    }

}


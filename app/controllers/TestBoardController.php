<?php

class TestBoardController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        //$this->assets->addCss("css/cssku.css");
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }

}


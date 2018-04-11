<?php

class DriveController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
    	$boardId = "";
    	$cardId = "";
    	if(isset($_GET["id"]))
        {
            $boardId = $_GET["id"];
        }
        if(isset($_GET["cardId"]))
        {
            $cardId = $_GET["cardId"];
        }
        $userId = $this->session->get("userId");
        if($userId == null)
        {
            $this->response->redirect("login");
        }
        if($boardId == null || $cardId == null)
        {
        	if($userId == null)
	        {
	            $this->response->redirect("login");
	        }
	        else
	        {
	        	$this->response->redirect("home");
	        }
        }
    	$this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    	$this->view->boardId = $boardId;
    	$this->view->cardId = $cardId;
    }

    public function downloadAction()
    {
		$fileId = $_POST["fileId"];
		$oauthToken = $_POST["oauthToken"];
		$this->view->disable();
		$url = 'https://www.googleapis.com/drive/v3/files/' . $fileId . '?alt=media';
		//$oAuthToken = $_POST['oAuthToken'];

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		// If google drive file download, we need the token
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $oauthToken]);

		$data = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_errno($ch);

		curl_close($ch);


		
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
		file_put_contents($directory, $data);
        echo $id;
		
    }

}

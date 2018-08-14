<?php

class InviteController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }

    public function getInviteAction($boardId,$role)
    {
        // localhost/trello/invite/getInvite/BO00000/Collaborator
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        set_time_limit(0);
        $boardId = $boardId;
        $userId = $this->cookies->get("userId");
        if($userId == null || $userId == "")
        {
            $userId = $this->session->get("userId");
        }
        if($userId == null || $userId == "")
        {
            $this->session->set("inviteBoardId",$boardId);
            $this->session->set("inviteRoleMember",$role);
            $this->response->redirect("login");
        }
        else
        {
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
                $this->response->redirect("board?id=".$boardId);
            }
            else
            {
                $match->memberStatus = '1';
                $match->save();
                $this->response->redirect("board?id=".$boardId);
            }
        }
    }

    public function getInviteGroupAction($groupId)
    {
        // http://localhost/trello/invite/getInviteGroup/GU00005
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        set_time_limit(0);
        $groupId = $groupId;
        $userId = $this->cookies->get("userId");
        if($userId == null || $userId == "")
        {
            $userId = $this->session->get("userId");
        }
        if($userId == null || $userId == "")
        {
            $this->session->set("inviteGroupId",$groupId);
            $this->session->set("kumparan",$groupId);
            //echo $this->session->get("inviteGroupId");
            $this->response->redirect("login");
        }
        else
        {
            $match = Groupmember::findFirst(
                [
                    "conditions" => "groupUserId='".$groupId."' AND userId='".$userId."'"
                ]
            );
            if($match == null)
            {
                $userId = (string)$userId;
                $gm = new Groupmember();
                $role = "Member";
                $status = "1";
                $gm->insertGroupMember($userId,$groupId,$role,$status);
                $this->response->redirect("home");
            }
            else
            {
                
                $match->memberStatus = '1';
                $match->save();
                $this->response->redirect("home");
            }
        }
    }

}


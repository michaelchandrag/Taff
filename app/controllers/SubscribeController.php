<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class SubscribeController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $this->view->disable();
        $user = User::find(
            [
                "userStatus='1'"
            ]
        );
        foreach($user as $user)
        {    
            $datas = array();
            $send_email = false;
            $userId = $user->userId;
            $member = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' AND subscribeChecked='1' AND memberStatus='1'"
                ]
            );
            foreach($member as $m)
            {
                $arrStartDate = array();
                $arrDueDate = array();
                $arrMessage = array();
                $alert = false;
                $boardId = $m->boardId;
                $boardTitle = "";
                $board = Board::findFirst(
                    [
                        "conditions"=>"boardId='".$boardId."'"
                    ]
                );
                $boardTitle = "";
                if($board->boardClosed=='0' && $board->boardStatus=='1')
                {
                    $boardTitle = $board->boardTitle;
                    $card = Boardcard::find(
                        [
                            "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='0' AND cardStatus='1'"
                        ]
                    );
                    foreach($card as $card)
                    {   
                        $cardTitle = $card->cardTitle;
                        $cardId = $card->cardId;
                        $start = Boardstartdate::findFirst(
                            [
                                "conditions"=>"cardId='".$cardId."' and startDateStatus='1'"
                            ]
                        );
                        $due = Boardduedate::findFirst(
                            [
                                "conditions"=>"cardId='".$cardId."' and dueDateStatus='1'"
                            ]
                        );
                        date_default_timezone_set('UTC');
                        $date = date('m/d/Y h:i:s', time());
                        $startDate = "";
                        $dueDate = "";
                        if($start != null)
                        {
                            $startDate = (string)$start->startDate;
                            $date = (string)$date;
                            $date1=date_create($startDate);
                            $date2=date_create($date);
                            $diff=date_diff($date1,$date2);
                            $diff =  (int)$diff->format("%R%a");
                            if($diff < 0 && $diff >= -4)
                            {
                                $arr = array(
                                    "cardTitle"=>$cardTitle,
                                    "startDate"=>$startDate
                                );
                                array_push($arrStartDate,$arr);
                            }
                        }
                        if($due != null)
                        {
                            $dueDate = (string)$due->dueDate;
                            $date1=date_create($dueDate);
                            $date2=date_create($date);
                            $diff=date_diff($date1,$date2);
                            $diff =  (int)$diff->format("%R%a");
                            if($diff < 0 && $diff >= -4)
                            {
                                $alert = true;
                                $arr = array(
                                    "cardTitle"=>$cardTitle,
                                    "dueDate"=>$dueDate
                                );
                                array_push($arrDueDate,$arr);
                            }
                        }
                    }
                    $notification = Boardnotification::count(
                        [
                            "conditions"=>"boardId='".$boardId."' AND notificationStatus='1'"
                        ]
                    );
                    if($notification == null)
                    {
                        if($alert != true)
                        {
                            $alert = false;
                        }
                    }
                    else
                    {
                        
                        $alert = true;
                        $notif = Boardnotification::count(
                            [
                                "conditions"=>"boardId='".$boardId."' AND notificationStatus='1'"
                            ]
                        );
                        foreach($notif as $n)
                        {
                            $arr = array(
                                "boardId"=>$n->boardId,
                                "message"=>$n->message
                            );
                            array_push($arrMessage,$arr);
                        }
                    }
                }  
                if($alert == true)
                {
                    $arr = array(
                        "boardId"=>$boardId,
                        "boardTitle"=>$boardTitle,
                        "arrStartDate"=>$arrStartDate,
                        "arrDueDate"=>$arrDueDate,
                        "arrMessage"=>$arrMessage
                    );
                    array_push($datas,$arr);
                    $send_email = true;
                }
                if($send_email == true)
                {
                    $string = "";
                    //print_r($datas);
                    foreach($datas as $d)
                    {
                        if($d["arrStartDate"] != null || $d["arrDueDate"] != null || $d["arrMessage"] != null)
                        {
                            $string .= "<hr>";
                            $link = 'http://www.taff.top/board?id='.$d["boardId"]; 
                            $string .= " - <a href='".$link."'>".$d["boardTitle"]."</a>(<a href='".$link."'>".$link."</a>)<br>";
                            if($d["arrStartDate"] != null)
                            {
                                $string .= '<b>Start Date :</b><br>';
                                $temp = 0;
                                foreach($d["arrStartDate"] as $sd)
                                {
                                    if($temp < 5)
                                    {
                                        $string .= $sd["cardTitle"]." on ".date_format(new DateTime($sd["startDate"]),"d M Y")."<br>";
                                        $temp++;
                                    }
                                }
                                if($temp >= 5)
                                {
                                    $string .= "and many more start date."."<br>";
                                }
                                $string .= "<br>";
                            }
                            if($d["arrDueDate"] != null)
                            {
                                $temp = 0;
                                $string .= '<b>Due Date :</b><br>';
                                foreach($d["arrDueDate"] as $dd)
                                {
                                    if($temp < 5)
                                    {
                                        $string .= $dd["cardTitle"]." on ".date_format(new DateTime($dd["dueDate"]),"d M Y")."<br>";
                                        $temp++;
                                    }
                                }
                                if($temp >= 5)
                                {
                                    $string .= "and many more due date."."<br>";
                                }
                                $string .= "<br>";
                            }
                            if($d["arrMessage"] != null)
                            {
                                $temp = 0;
                                $string .= '<b>Activity :</b><br>';
                                foreach($d["arrMessage"] as $dm)
                                {
                                    if($temp < 5)
                                    {
                                        $string .= $dm["message"]."<br>";
                                        $temp++;
                                    }
                                }
                                if($temp >= 5)
                                {
                                    $string .= "and many more activities."."<br>";
                                }
                            }
                            $string .= "<br>";
                        }
                        //$link = 'localhost/trello/board?id='.$d["boardId"];
                        //$string .= "- <a href='".$link."'>".$d["boardTitle"]."</a><br>";
                        //$string = $string.$d["boardTitle"];
                    }
                    $email = $user->userEmail;
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
                    $mail->Subject = 'Notification from Taff.top';
                    $mail->isHTML(true);
                    $mail->Body = 'You are receiving a notification from a board that has you subscribed at taff.top.<br>
                                    Please check out the board on taff.top<br>
                                    '.$string;
                    if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        echo "Message sent!";
                    }
                    /*
                        You have a start date and due date on several boards in the upcoming days.
                        Please check out the board on taff.top
                        - Tes (localhost/board?id=BO00000)
                    */
                    
                }
            }
            
        }
        $notification = Boardnotification::find(
            [
                "conditions"=>"notificationStatus='1'"
            ]
        );
        foreach($notification as $n)
        {
            $n->notificationStatus = "0";
            $n->save();
            $n->delete();
        }  
    }

}


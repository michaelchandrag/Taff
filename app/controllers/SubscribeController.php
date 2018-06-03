<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class SubscribeController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        $user = User::find(
            [
                "userStatus='1'"
            ]
        );
        foreach($user as $user)
        {    
            $datas = array();
            $temp = 0;
            $send_email = false;
            $userId = $user->userId;
            $subscribe = Boardsubscribe::find(
                [
                    "conditions"=>"userId='".$userId."' AND subscribeStatus='1'"
                ]
            );
            foreach($subscribe as $subscribe)
            {
                $alert = false;
                $boardId = $subscribe->boardId;
                $boardTitle = "";
                $member = Boardmember::findFirst(
                    [
                        "conditions"=>"boardId='".$boardId."' AND userId='".$userId."'"
                    ]
                );
                if($member != null && $member->memberStatus == "1")
                {
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
                            if($start != null)
                            {
                                $startDate = $start->startDate;
                                $date = new DateTime($date); //hari ini
                                $start = new DateTime($startDate);
                                //$date2 = new DateTime('06/3/2018');
                                //kalau tanggal start date lebih kecil dari hari ini maka invert 1
                                $diff = $date->diff($start);
                                if($diff->invert == 0 && $diff->d <= 4)
                                {
                                    $alert = true;
                                }
                            }
                            if($due != null)
                            {
                                $dueDate = $due->dueDate;
                                $date = new DateTime($date); //hari ini
                                $due = new DateTime($dueDate);
                                //$date2 = new DateTime('06/3/2018');
                                //kalau tanggal start date lebih kecil dari hari ini maka invert 1
                                $diff = $date->diff($dueDate);
                                if($diff->invert == 1 && $diff->d <= 3)
                                {
                                    $alert = true;
                                }
                            }
                        }
                    }    
                }
                if($alert == true)
                {
                    $arr = array(
                        "boardId"=>$boardId,
                        "boardTitle"=>$boardTitle
                    );
                    array_push($datas,$arr);
                    $send_email = true;
                    $temp++;
                }          
            }
            if($send_email == true)
            {
                $string = "";
                foreach($datas as $d)
                {
                    $link = 'localhost/trello/board?id='.$d["boardId"];
                    $string .= "- <a href='".$link."'>".$d["boardTitle"]."</a><br>";
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

                $mail->Host     = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'canzinzzide@gmail.com';                 // SMTP username
                $mail->Password = 'cancan110796';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port     = 587;
                
                $mail->setFrom('canzinzzide@gmail.com', 'Michael Chandra');
                $mail->addAddress($email);
                $mail->Subject = 'Notification from Taff.top';
                $mail->isHTML(true);
                $mail->Body = 'You have a start date or due date on several boards in the upcoming days.<br>
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

}


<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
class RepadminController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        if($this->session->get("adminId") == false)
        {
            $this->response->redirect("admlogin");
        }
    }

    public function createPDFAction($boardId)
    {
        set_time_limit(0);
        $boardId = $boardId;
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );

        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        function getBoardMember($boardId)
        {
            $bm = Boardmember::find(
                [
                    "conditions" => "boardId='".$boardId."' AND memberStatus='1'"
                ]
            );
            return $bm;
        }
        function getBoardList($boardId)
        {
            $list = Boardlist::find(
                [
                    "conditions" => "listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'",
                    "order" => "listPosition ASC"
                ]
            );
            return $list;
        }
        function getBoardCard($listId)
        {
            $card = Boardcard::find(
                [
                    "conditions" => "cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1'",
                    "order" => "cardPosition ASC"
                ]
            );
            return $card;
        }
        function getStartDate($cardId)
        {
            $date = Boardstartdate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND startDateStatus='1'"
                ]
            );
            return $date;
        }
        function getDueDate($cardId)
        {
            $date = Boardduedate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND dueDateStatus='1'"
                ]
            );
            return $date;
        }
        function getChecklist($cardId)
        {
            $checklist = Boardchecklist::find(
                [
                    "conditions" => "cardId='".$cardId."' AND checklistStatus='1'"
                ]
            );
            return $checklist;
        }
        function getChecklistItem($checklistId)
        {
            $item = Boardchecklistitem::find(
                [
                    "conditions" => "checklistId='".$checklistId."' AND itemStatus = '1'"
                ]
            );
            return $item;
        }
        $this->view->disable();
        $creator = getUser($board->boardOwner);
        $creator_name = $creator->userName;
        $pd = getProgressDate($boardId);
        if($pd == null)
            $pd = "";
        else
            $pd = date_format(new DateTime($pd->date),"d M Y");
        $pi = getProgressItem($boardId);
        $pi_string = "";
        $pi_count = 0;
        if($pi != null)
        {
            $pi_total = 0;
            $pi_checked = 0;
            foreach($pi as $item)
            {
                if($item->itemChecked == "1")
                {
                    $pi_string .= '<input type="checkbox" checked="checked"> '.$item->itemTitle."<br>";
                    $pi_checked++;
                }
                else
                    $pi_string .= '<input type="checkbox"> '.$item->itemTitle."<br>";

                $pi_total++;
            }
            $pi_count = $pi_checked*100/$pi_total;
        }
        $bm = getBoardMember($boardId);
        $bm_string = "";
        if($bm != null)
        {
            foreach($bm as $member)
            {
                $userId = $member->userId;
                $user = getUser($userId);
                $bm_string .= "- ".$user->userName." (".$member->memberRole.")<br>";
            }
        }
        $list = getBoardList($boardId);
        $list_string = "";
        $list_count = 0;
        if($list != null)
        {
            $list_string .='<div class="row">';
            foreach($list as $l)
            {
                $listId = $l->listId;
                $list_string .= '
                    <div class="list">
                        <p class="center-align" style="margin:auto;"><b>'.$l->listTitle.'</b></p>
                        <hr style="margin-top:-1px;">';
                $card = getBoardCard($listId);
                if($card != null)
                {
                    
                    foreach($card as $c)
                    {
                        $list_string .="<div class='card'>";
                        $list_string .= "<b>".$c->cardTitle.'</b><br>';
                        if($c->cardDescription != null)
                        {
                            $list_string .= $c->cardDescription.'<br>';
                        }
                        $sd = getStartDate($c->cardId);
                        $dd = getDueDate($c->cardId);
                        if($sd!= null)
                        {
                            if($sd->startDateChecked == '1')
                                $list_string .= "Start date : <input type='checkbox' checked='checked'>".date_format(new DateTime($sd->startDate),"d M Y")."<br>";
                            else
                                $list_string .= "Start date : <input type='checkbox'>".date_format(new DateTime($sd->startDate),"d M Y")."<br>";
                        }
                        if($dd!= null)
                        {
                            if($dd->dueDateChecked == '1')
                                $list_string .= "Due date : <input type='checkbox' checked='checked'>".date_format(new DateTime($dd->dueDate),"d M Y")."<br>";
                            else
                                $list_string .= "Due date : <input type='checkbox'>".date_format(new DateTime($dd->dueDate),"d M Y")."<br>";
                        }
                        $checklist = getChecklist($c->cardId);
                        if($checklist != null)
                        {
                            foreach($checklist as $check)
                            {
                                $checklist_string = "";
                                //$list_string .= $check->checklistTitle." - "."0%"."<br>";
                                $item = getChecklistItem($check->checklistId);
                                $itemCount = 0;
                                if($item != null)
                                {
                                    $itemTotal = 0;
                                    $itemChecked = 0;
                                    $item_string = "";
                                    foreach($item as $i)
                                    {
                                        if($i->itemChecked == '1')
                                        {
                                            $item_string .= "<input type='checkbox' checked='checked'>".$i->itemTitle."<br>";
                                            $itemChecked++;
                                        }
                                        else
                                        {
                                            $item_string .= "<input type='checkbox'>".$i->itemTitle."<br>";
                                        }
                                        $itemTotal++;
                                    }
                                    $itemCount = $itemChecked*100/$itemTotal;
                                }
                                $checklist_string .= $check->checklistTitle." - ".$itemCount."%"."<br>";
                                $checklist_string .= $item_string;
                                $list_string .= $checklist_string; 
                            }
                        }
                        $list_string .="</div>";
                        //$list_string .= "<p class='left-align' style='margin:auto;font-size:10px;'>".$c->cardTitle."</p>";
                    }
                }



                $list_string.='</div>';
                $list_count++;
                if($list_count > 0 && $list_count%4==0)
                {
                    $list_string .= '</div>';
                    $list_string .='<div class="row">';
                }
            }
            $list_string .= '</div>';
        }
        $mpdf = new \Mpdf\Mpdf();
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        $stylesheet = '';
        $stylesheet .= '
            @page
            {
                margin:20px;
            }
            .title{
                font-weight:bold;
                font-size:24px;
                text-align:center;
            }
            .divTitle
            {
                width:100%;
                float:left;
            }
            .row
            {
                width:100%;
                float:left;
            }
            p
            {
                font-size:12px;
            }
            .col
            {
                width:50%;
                float:left;
            }
            ul.b 
            {
                list-style-type: square;
                padding:0;
                margin:0;
            }
            li
            {
                font-size:12px;
            }
            .list
            {
                width:23%;
                float:left;
                margin-left:5px;
                margin-bottom:5px;
                border:1px solid black;
                height:90px;
            }
            .center-align
            {
                text-align:center;
            }
            .left-align
            {
                text-align:left;
            }
            .card
            {
                width:95%;
                height:75px;
                margin-bottom:5px;
                margin-left:auto;
                margin-right:auto;
                border: 1px solid black;
                float:left;
                font-size:10px;
                padding:2px;
            }
        ';
        $html = '';
        $html .= '<div class="divTitle"><h1 class="title">'.'Taff.top'.'</h1></div>';
        $html .= '<hr>';
        $html .= '  <div class="row" style="margin-top:-15px;">
                        <div class="col">
                            <p><b>Board details</b><br>
                            Title : '.$board->boardTitle.'<br>
                            Creator : '.$creator_name.'<br>
                            Created : '.date_format(new DateTime($b->boardCreated),"d M Y").'<br>
                            Deadline : '.$pd.'<br>
                            Progress : '.$pi_count.'%'.'<br>'
                            .$pi_string.'</p>'.
                        '</div>
                        <div class="col">
                            <p><b>Members</b><br>
                            '.$bm_string.'
                            </p>
                        </div>'. 
                    '</div>';
        $html .= '<hr>';
        if($list_count != 0)
        {
            $html .= $list_string;
        }

        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html,2);
        $filename = $board->boardTitle.".pdf";
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    }

    public function createExcelAction($boardId)
    {
        set_time_limit(0);
        $boardId = $boardId;
        $board = Board::findFirst(
            [
                "boardId='".$boardId."'"
            ]
        );

        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        function getBoardMember($boardId)
        {
            $bm = Boardmember::find(
                [
                    "conditions" => "boardId='".$boardId."' AND memberStatus='1'"
                ]
            );
            return $bm;
        }
        function getBoardList($boardId)
        {
            $list = Boardlist::find(
                [
                    "conditions" => "listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'",
                    "order" => "listPosition ASC"
                ]
            );
            return $list;
        }
        function getBoardCard($listId)
        {
            $card = Boardcard::find(
                [
                    "conditions" => "cardListId='".$listId."' AND cardArchive='0' AND cardStatus='1'",
                    "order" => "cardPosition ASC"
                ]
            );
            return $card;
        }
        function getStartDate($cardId)
        {
            $date = Boardstartdate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND startDateStatus='1'"
                ]
            );
            return $date;
        }
        function getDueDate($cardId)
        {
            $date = Boardduedate::findFirst(
                [
                    "conditions" => "cardId='".$cardId."' AND dueDateStatus='1'"
                ]
            );
            return $date;
        }
        function getChecklist($cardId)
        {
            $checklist = Boardchecklist::find(
                [
                    "conditions" => "cardId='".$cardId."' AND checklistStatus='1'"
                ]
            );
            return $checklist;
        }
        function getChecklistItem($checklistId)
        {
            $item = Boardchecklistitem::find(
                [
                    "conditions" => "checklistId='".$checklistId."' AND itemStatus = '1'"
                ]
            );
            return $item;
        }
        $creator = getUser($board->boardOwner);
        $creator_name = $creator->userName;
        $pd = getProgressDate($boardId);
        if($pd == null)
            $pd = "";
        else
            $pd = date_format(new DateTime($pd->date),"d M Y");
        $pi = getProgressItem($boardId);
        $pi_string = "";
        $pi_count = 0;
        if($pi != null)
        {
            $pi_total = 0;
            $pi_checked = 0;
            foreach($pi as $item)
            {
                if($item->itemChecked == "1")
                {
                    $pi_checked++;
                }
                
                $pi_total++;
            }
            $pi_count = $pi_checked*100/$pi_total;
        }
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Taff.top')
            ->setLastModifiedBy('Taff.top')
            ->setTitle('Office Taff')
            ->setSubject('Office Taff')
            ->setDescription('Taff.top report.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Report');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Taff.top')
            ->setCellValue('A2', 'Title : '.$board->boardTitle)
            ->setCellValue('A3', 'Creator :'.$creator_name)
            ->setCellValue('A4', 'Created :'.date_format(new DateTime($board->boardCreated),"d M Y"))
            ->setCellValue('A5', 'Deadline :'.$pd)
            ->setCellValue('A6', 'Progress : '.$pi_count.'%');

        $ctr = 7;
        foreach($pi as $item)
        {
            if($item->itemChecked == "1")
            {
                $spreadsheet->setActiveSheetIndex(0)->getCell('A'.$ctr)->setValue('[X]'.$item->itemTitle);
            }
            else
            {
                $spreadsheet->setActiveSheetIndex(0)->getCell('A'.$ctr)->setValue('[ ]'.$item->itemTitle);
            }
            $ctr++;
        }
        $temp = 3;
        $huruf = ["E","G","I"];
        $spreadsheet->setActiveSheetIndex(0)->getCell('E2')->setValue('Members');
        $bm = getBoardMember($boardId);
        if($bm != null)
        {
            $indeks = 0;
            foreach($bm as $member)
            {
                $userId = $member->userId;
                $user = getUser($userId);
                $bm_string = $user->userName." (".$member->memberRole.")";
                $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[$indeks].$temp)->setValue($bm_string);
                if($temp <= $ctr)
                {
                    $temp++;
                }
                else
                {
                    $temp = 3;
                    $indeks++;
                }
            }
        }

        $ctr+=1;
        $ctrawal = $ctr;
        $huruf2 = ["A","E","J","M","Q","U","Y","AC","AG","AK","AO","AS","AW","BA","BE","BI","BM","BQ","BU","BY","CC","CG","CK","CO","CS","CW","DA","DE","DI","DM","DQ","DU","DY","EC","EG","EK"];
        $list = getBoardList($boardId);
        $indeks = 0;
        $temp = $ctrawal;
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );
        foreach($list as $l)
        {
            //$sheet ->getStyle('B2:G8')->applyFromArray($styleArray);
            $list_id = $l->listId;
            $list_title = $l->listTitle;
            $card = getBoardCard($list_id);
            foreach($card as $card)
            {
                $ctr++;
                $start = $temp;
                $cardId = $card->cardId;
                $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue($card->cardTitle." (in list ".$list_title.")");
                if($card->cardDescription != null || $card->cardDescription != "")
                {
                    $temp++;
                    $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue($card->cardDescription);
                }

                $sd = getStartDate($cardId);
                $dd = getDueDate($cardId);
                if($sd != null)
                {
                    $temp++;
                    $checked = " ";
                    if($sd->startDateChecked == "1")
                        $checked = "X";
                    $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue("Start Date : [".$checked."]".date_format(new DateTime($sd->startDate),"d M Y"));
                }
                if($dd != null)
                {
                    $temp++;
                    $checked = " ";
                    if($dd->dueDateChecked == "1")
                        $checked = "X";
                    $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue("Due Date : [".$checked."]".date_format(new DateTime($dd->dueDate),"d M Y"));
                }
                $checklist = getChecklist($cardId);
                if($checklist != null)
                {
                    foreach($checklist as $check)
                    {
                        $checklist_string = "";
                        //$list_string .= $check->checklistTitle." - "."0%"."<br>";
                        $item = getChecklistItem($check->checklistId);
                        $temp++;
                        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue($check->checklistTitle);
                        $itemCount = 0;
                        if($item != null)
                        {
                            $itemTotal = 0;
                            $itemChecked = 0;
                            //$item_string = "";
                            foreach($item as $i)
                            {
                                $checked = " ";
                                if($i->itemChecked =="1")
                                {
                                    $checked = "X";
                                }
                                $temp++;
                                $spreadsheet->setActiveSheetIndex(0)->getCell($huruf2[$indeks].$temp)->setValue("[".$checked."]".$i->itemTitle);
                                /*if($i->itemChecked == '1')
                                {
                                    //$item_string .= "<input type='checkbox' checked='checked'>".$i->itemTitle."<br>";
                                    $itemChecked++;
                                }
                                else
                                {
                                    //$item_string .= "<input type='checkbox'>".$i->itemTitle."<br>";
                                }
                                $itemTotal++;*/
                            }
                            //$itemCount = $itemChecked*100/$itemTotal;
                        }
                        //$checklist_string .= $check->checklistTitle." - ".$itemCount."%"."<br>";
                        //$checklist_string .= $item_string;
                        //$list_string .= $checklist_string; 
                    }
                }
                $akhir = $temp;
                $styleArray = [
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];
                //$spreadsheet->getStyle('A'.$start.':A'.$akhir)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A'.$start.':E'.$akhir)->applyFromArray($styleArray);
                $temp+=2;
            }
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="taff.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }

    public function websitePDFAction($from,$until)
    {
        set_time_limit(0);
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        $from = date('Y-m-d', strtotime($from)); // Modify according to your date format
        $until = date('Y-m-d', strtotime($until));
        $board = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $incoming = Boardprogressdate::query()
            ->where('date >= :from:')
            ->andWhere('date <= :until:')
            ->andWhere('dateStatus="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->execute();
        $board_closed = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->andWhere('boardClosed="1"')
            ->andWhere('boardStatus="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $board_active = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->andWhere('boardClosed="0"')
            ->andWhere('boardStatus="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $board_deleted = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->andWhere('boardStatus="0"')
            ->andWhere('boardClosed="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $group = Groupuser::query()
            ->where('groupCreated >= :from:')
            ->andWhere('groupCreated <= :until:')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("groupCreated ASC")
            ->execute();
        $from = date_format(new DateTime($from),"Y-m-d");
        $until = date_format(new DateTime($until),"Y-m-d");
        $list_string = "";
        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        $this->view->disable();
        
        $mpdf = new \Mpdf\Mpdf();
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        $stylesheet = '';
        $stylesheet .= '
            @page
            {
                margin:20px;
            }
            .title{
                font-weight:bold;
                font-size:24px;
                text-align:center;
            }
            .divTitle
            {
                width:100%;
                float:left;
            }
            .row
            {
                width:100%;
                float:left;
            }
            p
            {
                font-size:12px;
            }
            .col
            {
                width:50%;
                float:left;
            }
            ul.b 
            {
                list-style-type: square;
                padding:0;
                margin:0;
            }
            li
            {
                font-size:12px;
            }
            .list
            {
                width:23%;
                float:left;
                margin-left:5px;
                margin-bottom:5px;
                border:1px solid black;
                height:90px;
            }
            .center-align
            {
                text-align:center;
            }
            .left-align
            {
                text-align:left;
            }
            .card
            {
                width:95%;
                height:75px;
                margin-bottom:5px;
                margin-left:auto;
                margin-right:auto;
                border: 1px solid black;
                float:left;
                font-size:10px;
                padding:2px;
            }
            .col2
            {
                width :30%;
                float:left;
                margin-left:5px;
            }
        ';
        $html = '';
        $html .= '<div class="divTitle"><h1 class="title">'.'Taff.top'.'</h1></div>';
        $html .= '<hr>';
        $html .= '  <div class="row" style="margin-top:-15px;">
                        <div class="col">
                            <p><b>Website Report</b><br>
                            From : '.$from.'<br>
                            Until : '.$until.'<br>'.
                        '</div>'.
                    '</div>';
        $html .= '<hr>';
        $html .= '<div class="row">';
        $html .= '<p>Board created : '.count($board)."<br>";
        $html .= '- Active : '.count($board_active).'<br>';
        $html .= '- Closed : '.count($board_closed).'<br>';
        $html .= '- Deleted : '.count($board_deleted).'<br></p>';
        $html .= '</div>';
        foreach($board_active as $b) 
        {
            $html .= '<div class="row">';
            $boardId = $b->boardId;
            $pd = getProgressDate($boardId);
            if($pd == null)
                $pd = "";
            else
                $pd = date_format(new DateTime($pd->date),"d M Y");
            $pi = getProgressItem($boardId);
            $pi_string = "";
            $pi_count = 0;
            if($pi != null)
            {
                $pi_total = 0;
                $pi_checked = 0;
                foreach($pi as $item)
                {
                    if($item->itemChecked == "1")
                        $pi_checked++;

                    $pi_total++;
                }
                $pi_count = $pi_checked*100/$pi_total;
            }
            $status = "Active";
            if($b->boardClosed == "0" && $b->boardStatus=="1")
            {
                $status = "Active";
            }
            else if($b->boardClosed=="1" && $b->boardStatus == "1")
            {
                $status = "Closed";
            }
            else
            {
                $status = "Deleted";
            }

            $html .= '<div class="col2">';
            $html .= '<p>Board title : '.$b->boardTitle."<br>";
            $html .= 'Board ID : '.$boardId."<br>";
            $html .= 'Created : '.date_format(new DateTime($b->boardCreated),"d M Y")."<br>";
            $html .= 'Status : '.$status."<br>";
            $html .= 'Deadline : '.$pd."<br>";
            $html .= 'Progress : '.$pi_count."%<br>";
            $html .= '</div>';
            $html .= '<div class="col2">';
            $html .= '<div class="col">';
            //list dan card
            $total_list = Boardlist::count(
                [
                    "listBoardId='".$boardId."'"
                ]
            );
            $list_active = Boardlist::count(
                [
                    "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'"
                ]
            );
            $list_archive = Boardlist::count(
                [
                    "conditions"=>"listBoardId='".$boardId."' AND listArchive='1' AND listStatus='1'"
                ]
            );
            $list_deleted = Boardlist::count(
                [
                    "conditions"=>"listBoardId='".$boardId."' AND listArchive='1' AND listStatus='0'"
                ]
            );
            $html .= '<p>Total list : '.$total_list."<br>";
            $html .= '- Active : '.$list_active."<br>";
            $html .= '- Archived : '.$list_archive."<br>";
            $html .= '- Deleted : '.$list_deleted."<br>";
            $html .= '</p></div>';
            $html .= '<div class="col">';
            $total_card = Boardcard::count(
                [
                    "cardBoardId='".$boardId."'"
                ]
            );
            $card_active = Boardcard::count(
                [
                    "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='0' and cardStatus='1'"
                ]
            );
            $card_archived = Boardcard::count(
                [
                    "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='1' and cardStatus='1'"
                ]
            );
            $card_deleted = Boardcard::count(
                [
                    "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='1' and cardStatus='0'"
                ]
            );
            $html .= '<p>Total card : '.$total_card."<br>";
            $html .= '- Active : '.$card_active."<br>";
            $html .= '- Archived : '.$card_archived."<br>";
            $html .= '- Deleted : '.$card_deleted."<br></p>";
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="col2"><p>';
            $member = Boardmember::find(
                [
                    "conditions"=>"boardId='".$boardId."' AND memberStatus='1'"
                ]
            );
            $ctr = 1;
            foreach($member as $m)
            {
                $user = getUser($m->userId);
                $userName = $user->userName;
                $html .= $ctr.". ".$userName."(".$m->memberRole.")<br>";
                $ctr++;
            }
            $html .= '</p></div>';
            $html .= '</p></div>';
            $html .= '<hr>';
            
        }
        $html .= "Board with incoming deadline: "."<br>";
            foreach($incoming as $i)
            {
                $boardId = $i->boardId;
                $board = Board::findFirst(
                    [
                        "boardId='".$boardId."'"
                    ]
                );
                $pd = getProgressDate($boardId);
                if($pd == null)
                    $pd = "";
                else
                    $pd = date_format(new DateTime($pd->date),"d M Y");
                $html .= "<p>";
                $html .= "Board title : ".$board->boardTitle."<br>";
                $html .= "Board ID : ".$board->boardId."<br>";
                $user = getUser($board->boardOwner);
                $creator = $user->userName;
                $html .= "Creator : ".$creator."<br>";
                $html .= 'Created : '.date_format(new DateTime($board->boardCreated),"d M Y")."<br>";
                $html .= 'Deadline : '.$pd."<br>";
                $html .= "</p>";
                $html .= "<hr>";
            }
                $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html,2);
        $filename = "report.pdf";
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    }

    public function userPDFAction($from,$until)
    {
        set_time_limit(0);
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        $from = date('Y-m-d', strtotime($from)); // Modify according to your date format
        $until = date('Y-m-d', strtotime($until));
        $user_created = Userprofile::query()
            ->where('userJoined >= :from:')
            ->andWhere('userJoined <= :until:')
            ->bind(["from" => $from,"until"=>$until])
            ->execute();
        $user = User::count();
        $user_active = User::find(
            [
                "conditions"=>"userStatus='1'"
            ]
        );
        $user_deactive = User::find(
            [
                "conditions"=>"userStatus='0'"
            ]
        );
        $from = date_format(new DateTime($from),"Y-m-d");
        $until = date_format(new DateTime($until),"Y-m-d");
        $list_string = "";
        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        $this->view->disable();
        
        $mpdf = new \Mpdf\Mpdf();
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        $stylesheet = '';
        $stylesheet .= '
            @page
            {
                margin:20px;
            }
            .title{
                font-weight:bold;
                font-size:24px;
                text-align:center;
            }
            .divTitle
            {
                width:100%;
                float:left;
            }
            .row
            {
                width:100%;
                float:left;
            }
            p
            {
                font-size:12px;
            }
            .col
            {
                width:50%;
                float:left;
            }
            ul.b 
            {
                list-style-type: square;
                padding:0;
                margin:0;
            }
            li
            {
                font-size:12px;
            }
            .list
            {
                width:23%;
                float:left;
                margin-left:5px;
                margin-bottom:5px;
                border:1px solid black;
                height:90px;
            }
            .center-align
            {
                text-align:center;
            }
            .left-align
            {
                text-align:left;
            }
            .card
            {
                width:95%;
                height:75px;
                margin-bottom:5px;
                margin-left:auto;
                margin-right:auto;
                border: 1px solid black;
                float:left;
                font-size:10px;
                padding:2px;
            }
            .col2
            {
                width :30%;
                float:left;
                margin-left:5px;
            }
        ';
        $html = '';
        $html .= '<div class="divTitle"><h1 class="title">'.'Taff.top'.'</h1></div>';
        $html .= '<hr>';
        $html .= '  <div class="row" style="margin-top:-15px;">
                        <div class="col">
                            <p><b>Website Report</b><br>
                            From : '.$from.'<br>
                            Until : '.$until.'<br>'.
                        '</div>'.
                    '</div>';
        $html .= '<hr>';
        $html .= '<div class="row">';
        $html .= '<p>Total user : '.$user."<br>";
        $html .= 'User created : '.count($user_created)."<br>";
        $html .= '- Active : '.count($user_active).'<br>';
        $html .= '- Deactive : '.count($user_deactive).'<br></p>';
        $html .= '</div>';
        $html .= '<div class="row">';
        $html .= 'List of user created<br>';
        foreach($user_created as $u)
        {
            $html .= '<p>';
            $html .= 'User Id : '.$u->userId.'<br>';
            $html .= 'User Name : '.$u->userName.'<br>';
            $html .= 'User Email : '.$u->userEmail.'<br>';
            $html .= 'User Joined : '.date_format(new DateTime($u->userJoined),"d M Y").'<br>';
            $html .= 'User Status : '.$u->userStatus.'<br>';
            $html .= '</p>';
        }
        $html .= '</div>';
        $html .= '<hr>';
        $html .= 'Detail user';
        foreach($user_active as $u)
        {
            $userId = $u->userId;
            $gmAdmin = Groupmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Admin' and memberStatus ='1'"
                ]
            );
            $gmMember = Groupmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Member' and memberStatus ='1'"
                ]
            );
            $boardCreator = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Creator' and memberStatus='1'"
                ]
            );
            $boardCollaborator = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Collaborator' and memberStatus='1'"
                ]
            );
            $boardClient = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Client' and memberStatus='1'"
                ]
            );
            $html .= '<div class="row"><p>';
            $html .= '<div class="col2">';
            $html .= "<p>User Id : ".$u->userId."<br>";
            $html .= "User Name : ".$u->userName."<br>";
            $html .= "User Email : ".$u->userEmail."<br>";
            $html .= '</p></div>';
            $html .= '<div class="col2"><p>';
            $html .= "Group as Admin : ".count($gmAdmin)."<br>";
            foreach($gmAdmin as $admin)
            {
                $groupId = $admin->groupUserId;
                $group = Groupuser::findFirst(
                    [
                        "groupId='".$groupId."'"
                    ]
                );
                $html .= "- ".$group->groupName."<br>";
            }
            $html .= "Group as Member : ".count($gmMember)."<br>";
            foreach($gmMember as $admin)
            {
                $groupId = $admin->groupUserId;
                $group = Groupuser::findFirst(
                    [
                        "groupId='".$groupId."'"
                    ]
                );
                $html .= "- ".$group->groupName."<br>";
            }
            $html .= "</p></div>";
            $html .= "<div class='col2'><p>";
            $html .= "Board as Creator : ".count($boardCreator)."<br>";
            foreach($boardCreator as $b)
            {
                $boardId = $b->boardId;
                $board = Board::findFirst(
                    [
                        "boardId='".$boardId."'"
                    ]
                );
                $html .= "- ".$board->boardTitle."<br>";
            }
            $html .= "Board as Collaborator : ".count($boardCollaborator)."<br>";
            foreach($boardCollaborator as $b)
            {
                $boardId = $b->boardId;
                $board = Board::findFirst(
                    [
                        "boardId='".$boardId."'"
                    ]
                );
                $html .= "- ".$board->boardTitle."<br>";
            }
            $html .= "Board as Client : ".count($boardClient)."<br>";
            foreach($boardClient as $b)
            {
                $boardId = $b->boardId;
                $board = Board::findFirst(
                    [
                        "boardId='".$boardId."'"
                    ]
                );
                $html .= "- ".$board->boardTitle."<br>";
            }
            $html .= '<p></div>';
            $html .= '</p></div>';
            $html .= "<hr>";
        }
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($html,2);
        $filename = "report.pdf";
        $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
        exit();
    }

    public function websiteExcelAction($from,$until)
    {
        set_time_limit(0);
        $from = date('Y-m-d', strtotime($from)); // Modify according to your date format
        $until = date('Y-m-d', strtotime($until));
        $board = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $incoming = Boardprogressdate::query()
            ->where('date >= :from:')
            ->andWhere('date <= :until:')
            ->andWhere('dateStatus="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->execute();
        $board_closed = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->andWhere('boardClosed="1"')
            ->andWhere('boardStatus="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $board_active = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->andWhere('boardClosed="0"')
            ->andWhere('boardStatus="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $board_deleted = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->andWhere('boardStatus="0"')
            ->andWhere('boardClosed="1"')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $from = date_format(new DateTime($from),"Y-m-d");
        $until = date_format(new DateTime($until),"Y-m-d");
        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Taff.top')
            ->setLastModifiedBy('Taff.top')
            ->setTitle('Office Taff')
            ->setSubject('Office Taff')
            ->setDescription('Taff.top report.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Report');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Taff.top')
            ->setCellValue('A2', 'From : '.$from)
            ->setCellValue('A3', 'Until :'.$until)
            ->setCellValue('D1','Board created : '.count($board))
            ->setCellValue('D2','- Active : '.count($board_active))
            ->setCellValue('D3','- Closed : '.count($board_closed))
            ->setCellValue('D4','- Deleted : '.count($board_deleted));

        $ctr = 6;
        $huruf2 = ["A","F"];
        foreach($board as $b)
        {
            $awal_list = $ctr;
            $awal_card = $ctr;
            $awal_member = $ctr;
            $boardId = $b->boardId;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Board Title : ".$b->boardTitle);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Board ID : ".$b->boardId);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Created at : ".date_format(new DateTime($b->boardCreated),"d M Y"));
            $ctr++;
            $status = "Active";
            if($b->boardClosed == "0" && $b->boardStatus == "1")
            {
                $status = "Active";
            }
            else if($b->boardClosed == "1" && $b->boardStatus == "1")
            {
                $status = "Closed";
            }
            else if($b->boardClosed == "1" && $b->boardStatus == "0")
            {
                $status = "Deleted";
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Status : ".$status);
            $ctr++;
            $pd = getProgressDate($boardId);
            if($pd == null)
                $pd = "";
            else
                $pd = date_format(new DateTime($pd->date),"d M Y");
            $pi = getProgressItem($boardId);
            $pi_string = "";
            $pi_count = 0;
            if($pi != null)
            {
                $pi_total = 0;
                $pi_checked = 0;
                foreach($pi as $item)
                {
                    if($item->itemChecked == "1")
                        $pi_checked++;

                    $pi_total++;
                }
                if($pi_total != 0)
                $pi_count = $pi_checked*100/$pi_total;
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Deadline : ".$pd);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Progress : ".$pi_count."%");
            $ctr++;
            $list_count = Boardlist::count(
                "listBoardId='".$b->boardId."'"
            );
            $list_active = Boardlist::count(
                [
                    "conditions"=>"listBoardId='".$boardId."' AND listArchive='0' AND listStatus='1'"
                ]
            );
            $list_archive = Boardlist::count(
                [
                    "conditions"=>"listBoardId='".$boardId."' AND listArchive='1' AND listStatus='1'"
                ]
            );
            $list_deleted = Boardlist::count(
                [
                    "conditions"=>"listBoardId='".$boardId."' AND listArchive='1' AND listStatus='0'"
                ]
            );
            $total_card = Boardcard::count(
                [
                    "cardBoardId='".$boardId."'"
                ]
            );
            $card_active = Boardcard::count(
                [
                    "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='0' and cardStatus='1'"
                ]
            );
            $card_archived = Boardcard::count(
                [
                    "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='1' and cardStatus='1'"
                ]
            );
            $card_deleted = Boardcard::count(
                [
                    "conditions"=>"cardBoardId='".$boardId."' AND cardArchive='1' and cardStatus='0'"
                ]
            );
            $spreadsheet->setActiveSheetIndex(0)->getCell("D".$awal_list)->setValue("Total list : ".$list_count);
            $awal_list++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("D".$awal_list)->setValue("- Active : ".$list_active);
            $awal_list++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("D".$awal_list)->setValue("- Archive : ".$list_archive);
            $awal_list++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("D".$awal_list)->setValue("- Deleted : ".$list_deleted);
            $awal_list++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_card)->setValue("Total card : ".$total_card);
            $awal_card++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_card)->setValue("- Active : ".$card_active);
            $awal_card++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_card)->setValue("- Archive : ".$card_archived);
            $awal_card++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_card)->setValue("- Deleted : ".$card_deleted);
            $awal_card++;
            $member = Boardmember::find(
                [
                    "conditions"=>"boardId='".$b->boardId."' and memberStatus='1'"
                ]
            );
            $int = 0;
            foreach($member as $m)
            {
                $int++;
                $user = getUser($m->userId);
                $spreadsheet->setActiveSheetIndex(0)->getCell("H".$awal_member)->setValue($int.". ".$user->userName."(".$m->memberRole.")");
                $awal_member++;
            }
            //$ctr++;
            if($ctr < $awal_list)
            {
                $ctr = $awal_list;
            }
            if($ctr < $awal_card)
            {
                $ctr = $awal_card;
            }
            if($ctr < $awal_member)
            {
                $ctr = $awal_member;
            }
            $ctr++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="taff.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;
    }

    public function userExcelAction($from,$until)
    {
        set_time_limit(0);
        $from = date('Y-m-d', strtotime($from)); // Modify according to your date format
        $until = date('Y-m-d', strtotime($until));
        $user_created = Userprofile::query()
            ->where('userJoined >= :from:')
            ->andWhere('userJoined <= :until:')
            ->bind(["from" => $from,"until"=>$until])
            ->execute();
        $user = User::count();
        $user_active = User::find(
            [
                "conditions"=>"userStatus='1'"
            ]
        );
        $user_deactive = User::find(
            [
                "conditions"=>"userStatus='0'"
            ]
        );
        $from = date_format(new DateTime($from),"Y-m-d");
        $until = date_format(new DateTime($until),"Y-m-d");
        function getUser($userId)
        {
            $user = User::findFirst(
                [
                    "userId='".$userId."'"
                ]
            );
            return $user;
        }
        function getProgressDate($boardId)
        {
            $pd = Boardprogressdate::findFirst(
                [
                    "boardId='".$boardId."'"
                ]
            );
            return $pd;
        }
        function getProgressItem($boardId)
        {
            $pi = Boardprogressitem::find(
                [
                    "conditions" => "boardId='".$boardId."' AND itemStatus='1'"
                ]
            );
            return $pi;

        }
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Taff.top')
            ->setLastModifiedBy('Taff.top')
            ->setTitle('Office Taff')
            ->setSubject('Office Taff')
            ->setDescription('Taff.top report.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Report');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Taff.top')
            ->setCellValue('A2', 'From : '.$from)
            ->setCellValue('A3', 'Until :'.$until)
            ->setCellValue('D1','Total user : '.count($user))
            ->setCellValue('D2','User created : '.count($user_created))
            ->setCellValue('D3','- Active : '.count($user_active))
            ->setCellValue('D4','- Deactive : '.count($user_deactive));

        $ctr = 6;
        $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("List of user created ");
        $ctr++;
        foreach($user_created as $user)
        {
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User ID : ".$user->userId);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User Name : ".$user->userName);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User Email : ".$user->userEmail);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User Joined : ".date_format(new DateTime($user->userJoined),"d M Y"));
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User Status : ".$user->userStatus);
            $ctr++;
            $ctr++;
        }
        $ctr++;
        $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Detail User ");
        $ctr++;
        foreach($user_active as $u)
        {
            $awal_group = $ctr;
            $awal_board = $ctr;
            $userId = $u->userId;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User ID : ".$u->userId);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User Name : ".$u->userName);
            $ctr++;
            $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("User Email : ".$u->userEmail);
            $ctr++;
            $gmAdmin = Groupmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Admin' and memberStatus ='1'"
                ]
            );
            $gmMember = Groupmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Member' and memberStatus ='1'"
                ]
            );
            $boardCreator = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Creator' and memberStatus='1'"
                ]
            );
            $boardCollaborator = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Collaborator' and memberStatus='1'"
                ]
            );
            $boardClient = Boardmember::find(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Client' and memberStatus='1'"
                ]
            );
            $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_group)->setValue("Group as Admin : ".count($gmAdmin));
            $awal_group++;
            foreach($gmAdmin as $gm)
            {
                $groupId = $gm->groupUserId;
                $group = Groupuser::findFirst(
                    [
                        "groupId='".$groupId."'"
                    ]
                );
                $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_group)->setValue("- ".$group->groupName);
                $awal_group++;
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_group)->setValue("Group as Member : ".count($gmMember));
            $awal_group++;
            foreach($gmMember as $gm)
            {
                $groupId = $gm->groupUserId;
                $group = Groupuser::findFirst(
                    [
                        "groupId='".$groupId."'"
                    ]
                );
                $spreadsheet->setActiveSheetIndex(0)->getCell("F".$awal_group)->setValue("- ".$group->groupName);
                $awal_group++;
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell("I".$awal_board)->setValue("Board as Creator : ".count($boardCreator));
            $awal_board++;
            foreach($boardCreator as $b)
            {
                $board = Board::findFirst(
                    [
                        "boardId='".$b->boardId."'"
                    ]
                );
                $spreadsheet->setActiveSheetIndex(0)->getCell("I".$awal_board)->setValue("- ".$board->boardTitle);
                $awal_board++; 
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell("I".$awal_board)->setValue("Board as Collaborator : ".count($boardCollaborator));
            $awal_board++;
            foreach($boardCollaborator as $b)
            {
                $board = Board::findFirst(
                    [
                        "boardId='".$b->boardId."'"
                    ]
                );
                $spreadsheet->setActiveSheetIndex(0)->getCell("I".$awal_board)->setValue("- ".$board->boardTitle);
                $awal_board++; 
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell("I".$awal_board)->setValue("Board as Client : ".count($boardClient));
            $awal_board++;
            foreach($boardClient as $b)
            {
                $board = Board::findFirst(
                    [
                        "boardId='".$b->boardId."'"
                    ]
                );
                $spreadsheet->setActiveSheetIndex(0)->getCell("I".$awal_board)->setValue("- ".$board->boardTitle);
                $awal_board++; 
            }

            if($ctr < $awal_group)
            {
                $ctr = $awal_group;
            }
            if($ctr < $awal_board)
            {
                $ctr = $awal_board;
            }
            $ctr++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="taff.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;    }

}


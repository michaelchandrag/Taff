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
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 65,
            'margin_bottom' => 25,
            'margin_header' => 5,
            'margin_footer' => 10
        ]);
        $stylesheet = '';
        $stylesheet .= '
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
        $html = '<htmlpageheader name="MyHeader1">
                    <div style="text-align: center;font-size:24px;"><b>Taff.top</b></div><br><hr>';
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
        $html .='</htmlpageheader>';
        $html .='<htmlpagefooter name="MyFooter1">
            <table width="100%">
                <tr>
                    <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right; ">Taff.top 2018</td>
                </tr>
            </table>
        </htmlpagefooter>
        <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />
        <sethtmlpagefooter name="MyFooter1" value="on" />
        ';
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
        $today = date('Y-m-d');
        $incoming = Boardprogressdate::query()
            ->where('date >= :today:')
            ->andWhere('dateStatus="1"')
            ->bind(["today" => $today])
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
        
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 40,
            'margin_bottom' => 25,
            'margin_header' => 5,
            'margin_footer' => 10
        ]);
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        $stylesheet = '';
        $stylesheet .= '
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
        $html = '<htmlpageheader name="MyHeader1">
                    <div style="text-align: center;font-size:24px;"><b>Taff.top</b></div><br>';
        $html .= '  <div class="row" style="margin-top:-15px;">
                        <div class="col">
                            <p><b>Website Report</b><br>
                            From : '.$from.'<br>
                            Until : '.$until.'<br>'.
                        '</div>'.
                    '</div>';
        $html .= '<hr>';
        $html .='</htmlpageheader>';
        $html .='<htmlpagefooter name="MyFooter1">
            <table width="100%">
                <tr>
                    <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right; ">Taff.top 2018</td>
                </tr>
            </table>
        </htmlpagefooter>
        <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />
        <sethtmlpagefooter name="MyFooter1" value="on" />
        ';
        $html .= "<div>List of board created</div><br>";
        $html .= ' <table width="100%">
                        <colgroup>
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                        </colgroup>
                        <tr width="100%">
                            <td colspan=19 style="text-align:center;border: 1px solid #ddd;"><b>Board</b></td>
                            <td colspan=1 style="text-align:center;border: 1px solid #ddd;"><b>List</b></td>
                            <td colspan=1 style="text-align:center;border: 1px solid #ddd;"><b>Card</b></td>
                        </tr>
                        <tr>
                            <td colspan=3 style="text-align:center;font-size:12px;border: 1px solid #ddd;">ID</td>
                            <td colspan=4 style="text-align:center;font-size:12px;border: 1px solid #ddd;">Title</td>
                            <td colspan=4 style="text-align:center;font-size:12px;border: 1px solid #ddd;">Creator</td>
                            <td colspan=2 style="text-align:center;font-size:12px;border: 1px solid #ddd;">Created</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Status</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Deadline</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Progress</td>
                            <td colspan=1 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Total</td>
                            <td colspan=1 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Total</td>
                        </tr>';
        foreach($board as $b)
        {
            $boardId = $b->boardId;
            $pd = getProgressDate($boardId);
            if($pd == null)
                $pd = "";
            else
                $pd = date_format(new DateTime($pd->date),"d M Y");
            $pi = getProgressItem($boardId);
            $pi_count = 0;
            if($pi != null )
            {
                $pi_total = 0;
                $pi_checked = 0;
                foreach($pi as $item)
                {
                    if($item->itemChecked == "1")
                        $pi_checked++;

                    $pi_total++;
                }
                if($pi_total > 0)
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
            //list dan card
            $total_list = Boardlist::count(
                [
                    "listBoardId='".$boardId."'"
                ]
            );
            $total_card = Boardcard::count(
                [
                    "cardBoardId='".$boardId."'"
                ]
            );
            $html .= '<tr>
                            <td colspan=3 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.$b->boardId.'</td>
                            <td colspan=4 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.$b->boardTitle.'</td>
                            <td colspan=4 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.$b->boardOwner.'</td>
                            <td colspan=2 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.date_format(new DateTime($b->boardCreated),"d M Y").'</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$status.'</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$pd.'</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$pi_count.'%</td>
                            <td colspan=1 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$total_list.'</td>
                            <td colspan=1 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$total_card.'</td>
                        </tr>';
        }
        $html .= '</table>';
        $html .= '<br><div>Board with incoming deadline</div><br>';
        $html .= ' <table width="100%">
                        <tr>
                            <td width="18%" style="text-align:center;border: 1px solid #ddd;"><b>Board ID</b></td>
                            <td width="18%" style="text-align:center;border: 1px solid #ddd;"><b>Board Title</b></td>
                            <td width="18%" style="text-align:center;border: 1px solid #ddd;"><b>Board Creator</b></td>
                            <td width="18%" style="text-align:center;border: 1px solid #ddd;"><b>Board Created</b></td>
                            <td width="18%" style="text-align:center;border: 1px solid #ddd;"><b>Deadline</b></td>
                            <td width="10%" style="text-align:center;border: 1px solid #ddd;"><b>Board Status</b></td>
                        </tr>';
        foreach($incoming as $i)
        {
            $pd = $i->date;
            $boardId = $i->boardId;
            $boardIncoming = Board::findFirstByBoardId($boardId);
            $status = "Active";
            if($boardIncoming->boardClosed == "0" && $boardIncoming->boardStatus == "1")
            {
                $status = "Active";
            }
            else if($boardIncoming->boardClosed == "1" && $boardIncoming->boardStatus == "1")
            {
                $status = "Closed";
            }
            else if($boardIncoming->boardClosed == "1" && $boardIncoming->boardStatus == "0")
            {
                $status = "Deleted";
            }
            $html .= '<tr>
                <td width="19%" style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.$b->boardId.'</td>
                <td width="19%" style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.$b->boardTitle.'</td>
                <td width="19%" style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.$b->boardOwner.'</td>
                <td width="19%" style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.date_format(new DateTime($b->boardCreated),"d M Y").'</td>
                <td width="19%" style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.date_format(new DateTime($pd),"d M Y").'</td>
                <td width="19%" style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$status.'</td>
            </tr>';    
        }
        
        $html .= '</table>';
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
        
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 40,
            'margin_bottom' => 25,
            'margin_header' => 5,
            'margin_footer' => 10
        ]);
        //$mpdf->WriteHTML('<h1>Hello world!</h1>');
        $stylesheet = '';
        $stylesheet .= '
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
            th, td {
                border-bottom: 1px solid #ddd;
            }
        ';
        $html = '';
        $html = '<htmlpageheader name="MyHeader1">
                    <div style="text-align: center;font-size:24px;"><b>Taff.top</b></div><br>';
        $html .= '  <div class="row" style="margin-top:-15px;">
                        <div class="col">
                            <p><b>Website Report</b><br>
                            From : '.$from.'<br>
                            Until : '.$until.'<br>'.
                        '</div>'.
                    '</div>';
        $html .= '<hr>';
        $html .='</htmlpageheader>';
        $html .='<htmlpagefooter name="MyFooter1">
            <table width="100%">
                <tr>
                    <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right; ">Taff.top 2018</td>
                </tr>
            </table>
        </htmlpagefooter>
        <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />
        <sethtmlpagefooter name="MyFooter1" value="on" />
        ';
        $html .= "<div>List of user created</div><br>";
        $html .= ' <table width="100%">
                        <tr>
                            <td width="20%"><b>User ID</b></td>
                            <td width="20%"><b>User Name</b></td>
                            <td width="25%"><b>User Email</b></td>
                            <td width="20%"><b>User Joined</b></td>
                            <td width="15%"><b>User Status</b></td>
                        </tr>';
        foreach($user_created as $u)
        {
            $html .= '<tr>';
            $html .= '<td width="20%">'.$u->userId.'</td>';
            $html .= '<td width="20%">'.$u->userName.'</td>';
            $html .= '<td width="25%">'.$u->userEmail.'</td>';
            $html .= '<td width="20%">'.date_format(new DateTime($u->userJoined),"d M Y").'</td>';
            $html .= '<td width="15%" style="text-align:center;">'.$u->userStatus.'</td>';
            $html .= '</tr>';
        }          
        $html .= '</table><br> ';
        $html .= '<div>Detail all user</div><br>';
        $html .= ' <table width="100%">
                        <colgroup>
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                            <col width="5%"><col width="5%">
                        </colgroup>
                        <tr width="100%">
                            <td colspan=9 style="text-align:center;border: 1px solid #ddd;"><b>User</b></td>
                            <td colspan=4 style="text-align:center;border: 1px solid #ddd;"><b>Groups</b></td>
                            <td colspan=7 style="text-align:center;border: 1px solid #ddd;"><b>Boards</b></td>
                        </tr>
                        <tr>
                            <td colspan=3 style="text-align:center;font-size:12px;border: 1px solid #ddd;">User ID</td>
                            <td colspan=3 style="text-align:center;font-size:12px;border: 1px solid #ddd;">User Name</td>
                            <td colspan=3 style="text-align:center;font-size:12px;border: 1px solid #ddd;">User Email</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Admin</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Member</td>
                            <td colspan=3 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Creator</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Collabrator</td>
                            <td colspan=2 style="text-align:center;font-size:10px;border: 1px solid #ddd;">Client</td>
                        </tr>';
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
            $html .= '<tr>';
            $html .= '<td colspan=3 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$u->userId.'</td>';
            $html .= '<td colspan=3 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$u->userName.'</td>';
            $html .= '<td colspan=3 style="text-align:center;font-size:10px;border: 1px solid #ddd;">'.$u->userName.'</td>';
            $html .= '<td colspan=2 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.count($gmAdmin).'</td>';
            $html .= '<td colspan=2 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.count($gmMember).'</td>';
            $html .= '<td colspan=3 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.count($boardCreator).'</td>';
            $html .= '<td colspan=2 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.count($boardCollaborator).'</td>';
            $html .= '<td colspan=2 style="text-align:center;font-size:12px;border: 1px solid #ddd;">'.count($boardClient).'</td>';
            $html .= '<tr>';
        }
        $html .= '</table>';
        

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
        $today = date('Y-m-d');
        $board = Board::query()
            ->where('boardCreated >= :from:')
            ->andWhere('boardCreated <= :until:')
            ->bind(["from" => $from,"until"=>$until])
            ->orderBy("boardCreated ASC")
            ->execute();
        $incoming = Boardprogressdate::query()
            ->where('date >= :today:')
            ->andWhere('dateStatus="1"')
            ->bind(["today" => $today])
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
        $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
            ];
        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Taff.top')
            ->setCellValue('A2', 'From : '.$from)
            ->setCellValue('A3', 'Until :'.$until);

        $ctr = 6;
        $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("List of board created");
        $huruf = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y"];
        $detail_awal = $ctr;
        $detail_awal++;
        $ctr++;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_awal)->setValue("Board");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[16].$detail_awal)->setValue("List");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[19].$detail_awal)->setValue("Card");
        $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_awal.':'.$huruf[15].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[16].$detail_awal.':'.$huruf[18].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[19].$detail_awal.':'.$huruf[21].$detail_awal);
        $detail_awal++;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_awal)->setValue("ID");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_awal)->setValue("Title");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[6].$detail_awal)->setValue("Creator");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_awal)->setValue("Created");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_awal)->setValue("Status");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[12].$detail_awal)->setValue("Deadline");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[14].$detail_awal)->setValue("Progress");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[16].$detail_awal)->setValue("Active");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[17].$detail_awal)->setValue("Archived");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[18].$detail_awal)->setValue("Deleted");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[19].$detail_awal)->setValue("Active");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[20].$detail_awal)->setValue("Archived");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[21].$detail_awal)->setValue("Deleted");
        $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_awal.':'.$huruf[1].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_awal.':'.$huruf[5].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[6].$detail_awal.':'.$huruf[7].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[10].$detail_awal.':'.$huruf[11].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[12].$detail_awal.':'.$huruf[13].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[14].$detail_awal.':'.$huruf[15].$detail_awal);
        foreach($board as $b)
        {
            $detail_awal++;
            $boardId = $b->boardId;
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

            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_awal)->setValue($boardId);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_awal)->setValue($b->boardTitle);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[6].$detail_awal)->setValue($b->boardOwner);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_awal)->setValue($b->boardCreated);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_awal)->setValue($status);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[12].$detail_awal)->setValue($pd);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[14].$detail_awal)->setValue($pi_count."%");
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[16].$detail_awal)->setValue($list_active);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[17].$detail_awal)->setValue($list_archive);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[18].$detail_awal)->setValue($list_deleted);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[19].$detail_awal)->setValue($card_active);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[20].$detail_awal)->setValue($card_archived);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[21].$detail_awal)->setValue($card_deleted);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_awal.':'.$huruf[1].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_awal.':'.$huruf[5].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[6].$detail_awal.':'.$huruf[7].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_awal.':'.$huruf[9].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[10].$detail_awal.':'.$huruf[11].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[12].$detail_awal.':'.$huruf[13].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[14].$detail_awal.':'.$huruf[15].$detail_awal);
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.$ctr.':V'.$detail_awal)->applyFromArray($styleArray);
        $ctr = $detail_awal;
        $ctr++;
        $ctr++;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$ctr)->setValue("Board with incoming deadline");
        $ctr++;
        $detail_awal = $ctr;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_awal)->setValue("Board ID");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_awal)->setValue("Board Title");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[6].$detail_awal)->setValue("Board Creator");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_awal)->setValue("Board Created");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_awal)->setValue("Deadline");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[12].$detail_awal)->setValue("Board Status");
        $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_awal.':'.$huruf[1].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_awal.':'.$huruf[5].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[6].$detail_awal.':'.$huruf[7].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_awal.':'.$huruf[9].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[10].$detail_awal.':'.$huruf[11].$detail_awal);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[12].$detail_awal.':'.$huruf[13].$detail_awal);
        foreach($incoming as $i)
        {
            $detail_awal++;
            $pd = $i->date;
            $boardId = $i->boardId;
            $boardIncoming = Board::findFirstByBoardId($boardId);
            $status = "Active";
            if($boardIncoming->boardClosed == "0" && $boardIncoming->boardStatus == "1")
            {
                $status = "Active";
            }
            else if($boardIncoming->boardClosed == "1" && $boardIncoming->boardStatus == "1")
            {
                $status = "Closed";
            }
            else if($boardIncoming->boardClosed == "1" && $boardIncoming->boardStatus == "0")
            {
                $status = "Deleted";
            }
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_awal)->setValue($boardId);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_awal)->setValue($b->boardTitle);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[6].$detail_awal)->setValue($b->boardOwner);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_awal)->setValue($b->boardCreated);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_awal)->setValue(date_format(new DateTime($pd),"d M Y"));
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[12].$detail_awal)->setValue($status);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_awal.':'.$huruf[1].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_awal.':'.$huruf[5].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[6].$detail_awal.':'.$huruf[7].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_awal.':'.$huruf[9].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[10].$detail_awal.':'.$huruf[11].$detail_awal);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[12].$detail_awal.':'.$huruf[13].$detail_awal);
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.($ctr).':N'.$detail_awal)->applyFromArray($styleArray);
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
        
        $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
            ];
        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Taff.top')
            ->setCellValue('A2', 'From : '.$from)
            ->setCellValue('A3', 'Until :'.$until);
        $huruf = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q"];
        $ctr = 6;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$ctr)->setValue("List of user created ");
        $detail_start = 7;
        $ctr = $detail_start;
        $ctr_huruf = 0;
        $ctr++;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_start)->setValue("User ID");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_start)->setValue("User Name");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[4].$detail_start)->setValue("User Email");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[6].$detail_start)->setValue("User Joined");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_start)->setValue("User Status");

        $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_start.':'.$huruf[1].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_start.':'.$huruf[3].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[4].$detail_start.':'.$huruf[5].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[6].$detail_start.':'.$huruf[7].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_start.':'.$huruf[9].$detail_start);
        foreach($user_created as $user)
        {
            $detail_start++;
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_start)->setValue($user->userId);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_start)->setValue($user->userName);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[4].$detail_start)->setValue($user->userEmail);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[6].$detail_start)->setValue(date_format(new DateTime($user->userJoined),"d M Y"));
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_start)->setValue($user->userStatus);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_start.':'.$huruf[1].$detail_start);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_start.':'.$huruf[3].$detail_start);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[4].$detail_start.':'.$huruf[5].$detail_start);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[6].$detail_start.':'.$huruf[7].$detail_start);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_start.':'.$huruf[9].$detail_start);
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.($ctr-1).':J'.$detail_start)->applyFromArray($styleArray);
        $detail_start++;
        $detail_start++;
        $ctr = $detail_start;
        $spreadsheet->setActiveSheetIndex(0)->getCell("A".$ctr)->setValue("Detail All User ");
        $detail_start++;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_start)->setValue("User");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_start)->setValue("Groups");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_start)->setValue("Boards");
        $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_start.':'.$huruf[7].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_start.':'.$huruf[9].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[10].$detail_start.':'.$huruf[12].$detail_start);

        $detail_start++;
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_start)->setValue("User ID");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_start)->setValue("User Name");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[4].$detail_start)->setValue("User Email");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_start)->setValue("Admin");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[9].$detail_start)->setValue("Member");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_start)->setValue("Creator");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[11].$detail_start)->setValue("Collaborator");
        $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[12].$detail_start)->setValue("Client");

        $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_start.':'.$huruf[1].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_start.':'.$huruf[3].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[4].$detail_start.':'.$huruf[7].$detail_start);
        $spreadsheet->getActiveSheet()->mergeCells($huruf[8].$detail_start.':'.$huruf[9].$detail_start);
        $ctr++;
        foreach($user_active as $u)
        {
            $userId = $u->userId;
            $detail_start++;
            $gmAdmin = Groupmember::count(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Admin' and memberStatus ='1'"
                ]
            );
            $gmMember = Groupmember::count(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Member' and memberStatus ='1'"
                ]
            );
            $boardCreator = Boardmember::count(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Creator' and memberStatus='1'"
                ]
            );
            $boardCollaborator = Boardmember::count(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Collaborator' and memberStatus='1'"
                ]
            );
            $boardClient = Boardmember::count(
                [
                    "conditions"=>"userId='".$userId."' and memberRole='Client' and memberStatus='1'"
                ]
            );
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[0].$detail_start)->setValue($u->userId);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[2].$detail_start)->setValue($u->userName);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[4].$detail_start)->setValue($u->userEmail);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[8].$detail_start)->setValue($gmAdmin);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[9].$detail_start)->setValue($gmMember);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[10].$detail_start)->setValue($boardCreator);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[11].$detail_start)->setValue($boardCollaborator);
            $spreadsheet->setActiveSheetIndex(0)->getCell($huruf[12].$detail_start)->setValue($boardClient);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[0].$detail_start.':'.$huruf[1].$detail_start);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[2].$detail_start.':'.$huruf[3].$detail_start);
            $spreadsheet->getActiveSheet()->mergeCells($huruf[4].$detail_start.':'.$huruf[7].$detail_start);
            
        }
        $spreadsheet->getActiveSheet()->getStyle('A'.($ctr).':M'.$detail_start)->applyFromArray($styleArray);
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

}


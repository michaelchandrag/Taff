<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



namespace ScorpWebs\Tools;

require_once 'fpdf.php';
    class pdfG extends FPDF
    {
      function __construct()
       {
          parent::FPDF();
       }
    }
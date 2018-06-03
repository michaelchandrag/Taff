#Use FPDF with Phalcon Framework
==============================

Create pdf files using FPDF in phalcon

Setup
-----

In 'composer.json' file add the following lines:

        {
            "repositories":[
                {
                    "type":"vcs",
                    "url":"git@github.com:ScorpWebs/fpdf-phalcon.git" 
                }
            ],
            "require": {
                        "scorpwebs/fpdf-phalcon": "dev-master"
            }
        }


Now execute 
`php composer.phar install` or `composer install`.
or
`php composer.phar update` or `composer update`.


Usage
---------

// app/loader.php

        $loader->registerNamespaces(array(
            'ScorpWebs\Tools' => __DIR__ . '/../../vendor/scorpwebs/fpdf-phalcon/',
        ));

// app/controllers/PruebaController.php

        use ScorpWebs\Tools as Tool;
        require_once __DIR__ . '/../../vendor/scorpwebs/fpdf-phalcon/fpdf.php';

        class PruebaController extends BaseController
        {
            public function index()
            {
                    $pdf = new Tool\FPDF();
                    $pdf->AddPage();
                    $pdf->SetFont('Arial','B',16);
                    $pdf->Cell(40,10,'¡Hola, Mundo!');
                    $pdf->Output();


            }
        }
Sources
---------
[FPDF](http://www.fpdf.org/)
Uses FPDF 1.7

Developed by
---------
[ScorpWebs](http://www.scorpwebs.com/)

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="google-signin-client_id" content="1072527821213-ptf6v9avkb6hs1osqduk69bd9i5elmqd.apps.googleusercontent.com">
        <title>Taff</title>

        <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
        <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
        <meta name="msapplication-TileColor" content="#00bcd4">
        <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
        <?php
            $url = new Phalcon\Mvc\Url();
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'css/materialize.min.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'css/style.min.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'css/layouts/style-horizontal.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'css/custom/custom.min.css','media'=>'screen,projection'));
            if(isset($sessUser))
            {
                echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'css/layouts/page-center.css','media'=>'screen,projection'));
            }
            $this->assets->outputCss();
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'js/plugins/prism/prism.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'js/plugins/perfect-scrollbar/perfect-scrollbar.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'js/plugins/jvectormap/jquery-jvectormap.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'js/plugins/sweetalert/sweetalert.css','media'=>'screen,projection'));
            echo $this->tag->stylesheetLink(array('href'=>$url->getBaseUri().'js/jquery-ui.css','media'=>'screen,projection'));
        ?>
        <!--<link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <?php
            /*if(isset($sessUser))
            {
              echo '<link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">';
            }
            $this->assets->outputCss();*/
        ?>
        <!--<link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="js/plugins/jvectormap/jquery-jvectormap.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!-- ga pake <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!-- ga pake <link href="js/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="js/plugins/sweetalert/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <!--<link href="js/jquery-ui.css" type="text/css" rel="stylesheet" media="screen,projection">-->
        <style>
        .view1
        {
            background: url("view1.jpg");
        }
        .view2
        {
            background: url("view2.jpg");
        }
        </style>
    </head>

    <!--<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>-->
    <!--<script type="text/javascript" src="js/jquery-ui.min.js"></script>-->
    <!--<script type="text/javascript" src="js/plugins/sweetalert/sweetalert.min.js"></script> -->
    <?php 
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/plugins/jquery-1.11.2.min.js'));
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/jquery-ui.min.js'));
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/plugins/sweetalert/sweetalert.min.js'));
        echo $this->getContent(); 
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/plugins/jquery.ui.touch-punch.min.js'));
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/materialize.min.js'));
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/plugins/perfect-scrollbar/perfect-scrollbar.min.js'));
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/plugins/prism/prism.js'));
        echo $this->tag->javascriptInclude(array('src'=>$url->getBaseUri().'js/plugins.min.js'));
    ?>
    
    <!--<script type="text/javascript" src="js/plugins/jquery.ui.touch-punch.min.js"></script>-->
    <!--<script type="text/javascript" src="js/materialize.min.js"></script>-->
    <!--<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>-->
    <!--<script type="text/javascript" src="js/plugins/prism/prism.js"></script>-->
    <!--<script type="text/javascript" src="js/plugins.min.js"></script>-->
    <!-- ga pake <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>-->
    <!-- ga pake <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>-->
</html>

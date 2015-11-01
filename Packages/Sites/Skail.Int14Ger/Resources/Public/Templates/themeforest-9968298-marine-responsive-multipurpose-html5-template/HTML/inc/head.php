<!DOCTYPE html>

<!--[if IE 8 ]><html lang="en" class="isie ie8 oldie no-js"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="isie ie9 no-js"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->

    <head>
        
        <!-- Meta Tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo $marine['description']; ?>">
        <meta name="keywords" content="<?php echo $marine['keywords']; ?>">
        
        <!-- Title -->
        <title><?php echo $marine['title']; ?></title>
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="img/favicon.jpg" type="image/x-icon"/>
        
        <!-- Google Fonts -->
        <link rel='stylesheet' id='tp-open-sans-css'  href='http://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C600%2C700%2C800&#038;ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='tp-raleway-css'  href='http://fonts.googleapis.com/css?family=Raleway%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900&#038;ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='tp-droid-serif-css'  href='http://fonts.googleapis.com/css?family=Droid+Serif%3A400%2C700&#038;ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='tp-lato-css'  href='http://fonts.googleapis.com/css?family=Lato%3A100%2C300&#038;ver=4.0' type='text/css' media='all' />
        <link rel='stylesheet' id='google-fonts-css'  href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' type='text/css' media='all' />
        <link rel='stylesheet' id='orbit-montserrat-font-css'  href='//fonts.googleapis.com/css?family=Montserrat%3A400%2C500%2C700' type='text/css' media='all' />
        
        <!-- Stylesheets -->
        <link rel='stylesheet' id='twitter-bootstrap-css'  href='css/bootstrap.min.css' type='text/css' media='all' />
        <link rel='stylesheet' id='fontello-css'  href='css/fontello.css' type='text/css' media='all' />
        <link rel='stylesheet' id='prettyphoto-css-css'  href='js/prettyphoto/css/prettyPhoto.css' type='text/css' media='all' />
        <link rel='stylesheet' id='animation-css'  href='css/animation.css' type='text/css' media='all' />
        <link rel='stylesheet' id='flexSlider-css'  href='css/flexslider.css' type='text/css' media='all' />
        <link rel='stylesheet' id='perfectscrollbar-css'  href='css/perfect-scrollbar-0.4.10.min.css' type='text/css' media='all' />
        <link rel='stylesheet' id='nouislider-css'  href='css/jquery.nouislider.css' type='text/css' media='all' />
        <link rel='stylesheet' id='jquery-validity-css'  href='css/jquery.validity.css' type='text/css' media='all' />
        <link rel='stylesheet' id='jquery-ui-css'  href='css/jquery-ui.min.css' type='text/css' media='all' />
        <link rel='stylesheet' id='style-css'  href='css/style.css' type='text/css' media='all' />
                
        <!-- jQuery -->
        <script src="js/jquery-1.11.1.min.js"></script>
        
        <!-- Google Maps -->
        <script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false&#038;ver=4.0'></script>
       
        <!--[if lt IE 9]>
            <script>
                document.createElement("header");
                document.createElement("nav");
                document.createElement("section");
                document.createElement("article");
                document.createElement("aside");
                document.createElement("footer");
                document.createElement("hgroup");
            </script>
        <![endif]-->
        
        <!--[if lt IE 9]>
            <script src="js/html5.js"></script>
        <![endif]-->
        
        <!--[if lt IE 7]>
            <script src="js/icomoon.js"></script>
        <![endif]-->
        
        <!--[if lt IE 9]>
            <link href="css/ie.css" rel="stylesheet">
        <![endif]-->
        
        <!--[if lt IE 9]>
            <script src="js/jquery.placeholder.js"></script>
            <script src="js/script_ie.js"></script>
        <![endif]-->
        
        <!-- Preventing FOUC -->
        <style>
          .no-fouc{
            display:none;
          }
        </style>

        <script>
          
        // Prevent FOUC(flash of unstyled content)
        jQuery("html").addClass("no-fouc");
          
        jQuery(document).ready(function($) {
            $("html").show();
            setFullWidthFirst();
          
            // Set Full Width on Resize & Load
            $(window).bind("load", function(){
            
                setFullWidthFirst();
                setTimeout(function(){
                    setFullWidthFirst();
                }, 500);
            
            });
          
            // Set Full Width Function
            function setFullWidthFirst(){

                if(!$("body").hasClass("b960") && !$("body").hasClass("b1170")){
                    $(".full-width").each(function(){
                        var element = $(this);

                        // Reset Styles
                        element.css("margin-left", "");
                        element.css("padding-left", "0!important");
                        element.css("width", "");

                        var element_x = element.offset().left;

                        // Set New Styles
                        element.css("margin-left", -element_x+"px");
                        element.css("width", $(window).width()+"px");
                        element.css("padding-left", "");
                    });
                }

            }

        });
          
        var mobilenav_screen_size = 820;
          
        </script>

        
    </head>
    
    <body class="<?php echo $body_class; ?>">
        
        <!-- Marine Content Wrapper -->
        <div id="marine-content-wrapper">

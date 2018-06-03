<?php

?>

<head>
    <meta charset="UTF-8">
    <title>MONOPOLE</title>
    <link rel="stylesheet" href="css/reset.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="icon" type="image/png" href="img/logo.png" sizes="16x16">
    <link rel="icon" type="image/png" href="img/logo.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/logo.png" sizes="96x96">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.1.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<header>

    <nav>
        <!--
        <ul id="social">
            <li>
                <a href="https://www.youtube.com/channel/UCcdV8dJjj9DUeFIGakOKTjg"><img src="img/youtube.png" alt="Youtube logo"></a>
            </li>
            <li>
                <a href="https://www.facebook.com/monopole.theband"><img src="img/facebook.png" alt="Facebook logo"></a>
            </li>
        </ul>
        -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="media.php">Music/Video</a></li>
            <li><a href="tourdates.php">Tour dates</a></li>
            <li><?php include 'userinfo.php';?></li>
        </ul>
    </nav>
</header>
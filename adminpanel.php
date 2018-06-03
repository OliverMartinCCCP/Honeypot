<?php

require_once 'core/init.php';


$user = new User();

if($user->hasPermission()->first()->id == 3){
    $users = DB::getInstance()->getAllUsers();
    if ( Session::exists("home") ){
        echo Session::flash("home");
    }
    ?>

    <html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/adminpanel.css">


    </head>
    <body>

    <div class="jumbotron text-center">
        <h1>ADMIN PANEL</h1>
    </div><div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-list"></span>Userlist
                    </div>
                    <div class="panel-footer">
                        <a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">

                            <?php
                            $res = "";
                            $users = $results = DB::getInstance()->getAllUsers();
                            foreach($users->results() as $user){

                                echo "<li class=\"list-group-item\">
                            <div class=\"checkbox\">
                                <label for=\"checkbox\">
                                    ".$user->name."
                                </label>
                            </div>
                            <div class=\"pull-right action-buttons\">
                                <a href=\"edit.php?id=".$user->id."\"><span class=\"glyphicon glyphicon-pencil green\"></span></a>
                                <a id='$user->id' class='remove red'  href=\"\"><span class=\"glyphicon glyphicon-trash\"></span></a>
                            </div>
                        </li>";
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

        <script src="js/adminpanel.js"></script>
    </body>
    </html>
    <?php
} else {
    Redirect::to('index.php');
}

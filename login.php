<?php
require_once 'core/init.php';

if (Input::exists()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'username' => array('require' => true),
        'password' => array('required' => true)
    ));

    if($validation->passed()) {
        $user = new User();

        $remember = (Input::get('remember') === 'on')? true : false;
        $login = $user->login(Input::get('username'), Input::get('password'), $remember);

        if($login) {
            Redirect::to('index.php');
        } else {
            Session::flash('home', 'Login failed, username or password don\'t match our database');
            Redirect::to('index.php');
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo $error, '<br>';
        }
    }
}



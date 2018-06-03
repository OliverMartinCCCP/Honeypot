<?php
require_once 'core/init.php';

$user = new User();

$hash = Cookie::get(Config::get('remember/cookie_name'));
$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));


if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    /*if(Token::check(Input::get('token'))){*/
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'password_current' => array(
            'required' => true,
            'min' => 6,
            'matches' => $user->data()->password
        ),
        'password_new' => array(
            'required' => true,
            'min' => 6
        ),
        'password_new_again' => array(
            'required' => true,
            'matches' => 'password_new'
        )
    ));

    if($validation->passed()){

        $salt = $user->data()->salt;
        try{
            $user->update(array(
                'password' => Hash::make(Input::get('password_new_again'), $salt),

            ));

            Session::flash('home', 'your password has been changed');
            Redirect::to('index.php');

        } catch(Exception $e){
            die($e->getMessage());
        }

    }
    else{
        foreach($validation->errors() as $error){
            echo $error, '<br>';
        }
    }
    /*}*/
}

include 'header.php';
?>

    <div id="page">
        <div id="updateProfile">
            <form action="" method="post">
                <div class="form-group field">
                    <label for="password_current">Current password</label>
                    <input type="password" name="password_current" id="password_current">
                </div>

                <div class="form-group field">
                    <label for="password_new">New password</label>
                    <input type="password" name="password_new" id="password_new">
                </div>

                <div class="form-group field">
                    <label for="password_new_again">New password again</label>
                    <input type="password" name="password_new_again" id="password_new_again">
                </div>

                <input type="submit" value="Change">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            </form>
        </div>
    </div>

<?php
include 'footer.php';
?>
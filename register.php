<html>
<head>
    <meta charset="UTF-8">
    <title>HONEYPOT</title>
    <link rel="stylesheet" href="css/reset.css" type="text/css"/>
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="icon" type="image/png" href="img/logo.png" sizes="16x16">
    <link rel="icon" type="image/png" href="img/logo.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/logo.png" sizes="96x96">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.1.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<?php
require_once 'core/init.php';

$user = new User();
if(isset($_POST['g-recaptcha-response'])&&$_POST['g-recaptcha-response']){

    $secret = "6LccPQ4UAAAAAGdBzq3DwteaI9RCLIFFGiDydfuJ";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $rsp  = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
    $arr = json_decode($rsp,TRUE);
    if($arr['success']){
        if (Input::exists()) {

            $validate = new Validate();

            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6

                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'

                ),
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                )
            ));
            if ($validation->passed()) {
                $user = new User();

                $salt = "saltNpepper";
                try {
                    $user->create(array(
                        'username' => escape(Input::get('username')),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'name' => escape(Input::get('name')),
                        'joined' => date('Y-m-d H:i:s'),
                        'group' => 1,
                        'profile' => 'images/standard.gif'
                    ));
                    Session::flash('home', 'You have been registered and can now log in!');
                    Redirect::to('index.php');

                } catch (Exception $e) {

                }
            } else {
                foreach ($validation->errors() as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";

                }
            }

        }
    }else{
        echo 'You are not human or very bad at typing/reading, try again';
    }
}

?>

<body>

<?php
include 'header.php';
?>


<div id="page">
    <div id="register">
        <form action="" method="post">
            <div class="form-group field">
                <h1>Register</h1>

                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username"
                       value="<?php echo escape(Input::get('username')); ?>">

                <label for="password">Choose a password</label>
                <input type="password" name="password" id="password">

                <label for="password_again">Enter your password again</label>
                <input type="password" name="password_again" id="password_again">

                <label for="name">Enter your name</label>
                <input type="text" name="name" id="name"
                       value="<?php echo escape(Input::get('name')); ?>">
                <div class="g-recaptcha" data-sitekey="6LccPQ4UAAAAADp8jIOAKVZsha2PKi5aCT-AW_6f"></div>

                <input type="hidden" name="token" value"<?php echo Token::generate(); ?>">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</div>

<?php
include 'footer.php';
?>

</body>
<script src="js/script.js"></script>
</html>
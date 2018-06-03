<?php
require_once 'core/init.php';

$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

echo Input::exists();
if (Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if($validation->passed()){

            try{
                $user->update(array(
                    'name' => escape(Input::get('name')),
                    'email' => escape(Input::get('email')),
                    'country' => escape(Input::get('country')),
                    'city' => escape(Input::get('city'))

                ));

                Session::flash('home', 'your details have been updated');
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

    }
}
if(isset($_POST['g-recaptcha-response'])&&$_POST['g-recaptcha-response']){
    var_dump($_POST);
    $secret = "6LfQPA4UAAAAAFsCy-8BIzkjQfqEYzz8B5PFTnFP";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $rsp  = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
    $arr = json_decode($rsp,TRUE);
    if($arr['success']){
        if (isset ($_FILES['image'])){
            $errors = array();
            $allowed_ext = array('jpg','jpeg','png');

            $file_size = $_FILES['image']['size'];
            $file_name= $_FILES['image']['name'];
            $tmp = explode(".",$file_name);
            $file_ext = strtolower(end($tmp));
            $file_tmp= $_FILES['image']['tmp_name'];

            if(in_array($file_ext, $allowed_ext)=== false){
                $errors[] = 'Extensie niet toegestaan';
            }
            if ($file_size>2097152){
                $errors[]= 'File grote moet onder 2mb zijn';
            }
            if (empty($errors)){
                //upload file
                if(move_uploaded_file($file_tmp, 'images/'.$file_name)){
                    // update
                    // $file_tmp, 'images/profile'.$file_name into profile users tabel
                    $user->update(array(
                        'profile' => "images/".$file_name
                    ));

                    Session::flash('home', 'Upload was succesful');
                    Redirect::to('index.php');

                };
            }else{
                Session::flash('home', 'Incorrect extension, you can only use jpg, jpeg and png');
                Redirect::to('index.php');
            }
        }
    }else{
        Session::flash('home', 'You are not human or very bad at picking pictures, try again');
        Redirect::to('index.php');
    }
}

//HEADER KOMT BOVEN INPUT FIELDS !FIX!
// require_once 'header.php'
?>

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

<body>

<?php
include 'header.php';
?>

<div id="page">
    <div id="updateProfile">

        <div class="form-group field">

            <form method="post" action="" enctype="multipart/form-data">
                <h1>Profiel foto wijzigen</h1>
                <input type="hidden" name="size" value="100000">
                <div>
                    <input type="file" name="image">
                </div>
                <div class="g-recaptcha" data-sitekey="6LfQPA4UAAAAAI-Z4LRBXz30T1KZ5o5ce3yx3dCQ"></div>
                <input type="submit" name="upload image">

            </form>

        </div>
        <form action="" method="post">
            <div class="form-group field">
                <h1>Update profile</h1>

                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">


                <label for="email">email</label>
                <input type="email" name="email" value="<?php echo escape($user->data()->email); ?>">

                <label for="country">country</label>
                <input type="text" name="country" value="<?php echo escape($user->data()->country);?>">


                <label for="city">City</label>
                <input type="text" name="city" value="<?php echo escape($user->data()->city); ?>">

                <input type="submit" value="Update">
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            </div>
        </form>
    </div>
</div>
<?php
include 'footer.php';
?>
</body>
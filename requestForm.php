<?php

require_once 'core/init.php';
$user = new User();




if(isset($_POST['g-recaptcha-response'])&&$_POST['g-recaptcha-response']){
    var_dump($_POST);
    $secret = "6LfCPQ4UAAAAALpvfuRVygugKsAqSLrXAIOuB9oh";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $rsp  = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
    $arr = json_decode($rsp,TRUE);
    if($arr['success']){
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                ),
                'firstname' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                ),
                'email' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                ),
                'content' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                )
            ));

            if ($validation->passed()) {

                try {
                    DB::getInstance()->insert("questions", array(
                        'name' => escape(Input::get('name')),
                        'firstname' => escape(Input::get('firstname')),
                        'email' => escape(Input::get('email')),
                        'content' => escape(Input::get('content'))

                    ));

                    Session::flash('home', 'your question has been send');
                    Redirect::to('index.php');

                } catch (Exception $e) {
                    die($e->getMessage());
                }

            } else {
                foreach ($validation->errors() as $error) {
                    echo $error, '<br>';
                }
            }
        }
    }else{
        echo 'You are not human or very bad at typing/reading, try again';
    }
}




include 'header.php';
?>

    <div id="page">
        <div id="requestForm">
            <h1>Support</h1>
            <form method="post" action="#">


                <label for="firstname">voornaam *</label>
                <input  type="text" name="firstname" maxlength="50" size="30" required="required">

                <label for="name">Achternaam *</label>
                <input  type="text" name="name" maxlength="50" size="30" required="required">

                <label for="email">Email *</label>
                <input  type="text" name="email" maxlength="80" size="30" required="required">

                <label for="tele">Telefoon nummer</label>
                <input  type="text" name="tele" maxlength="30" size="30">

                <label for="content">bericht *</label>
                <textarea  name="content" maxlength="1000" cols="25" rows="6" required="required"></textarea>

                <div class="g-recaptcha" data-sitekey="6LfCPQ4UAAAAAFWntnxR_9YMXA1EJUTFtNvuHVfo"></div>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>

<?php

include 'footer.php';

?>
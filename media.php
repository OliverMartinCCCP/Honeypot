<?php
require_once 'core/init.php';
$user = new User();

if(isset($_POST['g-recaptcha-response'])&&$_POST['g-recaptcha-response']){
    var_dump($_POST);
    $secret = "6LefPA4UAAAAACsSGYni14qVVDL1fQokNWZnvQGM";
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $rsp  = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
    $arr = json_decode($rsp,TRUE);
    if($arr['success']){
        if (Input::exists()){
            if(Token::check(Input::get('token'))){

                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'title' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20
                    ),
                    'content' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 124
                    )
                ));

                if($validation->passed()){

                    try{
                        DB::getInstance()->insert("reviews", array(
                            'userid' => $user->data()->id,
                            'productid' => 1,
                            'content' => escape(Input::get('content')),
                            'title' => escape(Input::get('title'))

                        ));

                        Session::flash('home', 'your review has been posted');
                        Redirect::to('index.php');

                    } catch(Exception $e){
                        if(!$user->isLoggedIn()){
                            Session::flash('home', 'You are not logged in');
                            Redirect::to('index.php');
                        }else{
                            Session::flash('home', 'Something went wrong');
                            Redirect::to('index.php');
                        }
                    }

                } else{
                    Session::flash('home', 'Oops... Something went wrong. Highly trained monkeys are working on the problem');
                    Redirect::to('index.php');
                }
            }
        }
    }
}




include 'header.php';

?>
<div id="page">
    <div id="detail">

        <iframe width="780" height="400" src="https://www.youtube.com/embed/t0v-nUsHG6U" frameborder="0" allowfullscreen></iframe>

    </div>


    <div id="reviewsummary">
        <h1>Reviews</h1>

        <form action="#" method="post">
            <div class="form-group field">
                <?php
                if(!$user->isLoggedIn()){
                    echo '<p><a href="register.php">Register</a> or login to post a review</p>';
                }else {
                    ?>
                    <input class="addReview" type="button" onclick="$('.addReview').css({'display': 'none'});$('.hidden').css({'display': 'inline'});" value="Add a review">

                    <div class="hidden">
                        <label for="title">Title</label>
                        <input type="text" name="title" placeholder="Put in a title">


                        <label for="content">Content</label>
                        <input type="text" name="content" placeholder="Write your review">

                        <div class="g-recaptcha" data-sitekey="6LefPA4UAAAAALQKKOmKrx2yo_kIQRSJuOL2_6U4"></div>
                        <input type="submit" value="Post">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    </div>
                    <?php
                }
                ?>
            </div>
        </form>

        <div id="reviews">
            <?php

            $reviews = DB::getInstance()->get("reviews", array('productid', '=', 1));
            foreach($reviews->results() as $review){
                $user = DB::getInstance()->get("users", array('id', '=', $review->userid));
                echo "<div id='review'><h4><div id='username'>" . $user->first()->username . "</div>" . $review->title . "</h4>";
                echo "<p>" . $review->content . "</p></div>";
            }

            ?>
        </div>
    </div>

</div>

<?php
include 'footer.php';
?>

</body>
<?php
require_once 'core/init.php';


if (!$username = Input::get('user')) {
    Redirect::to('index.php');
} else {
    $user = new User();
    if (!$user->exists()) {
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
}

if (Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();

        $validation = $validate->check($_POST, array(
            'event' => array(
                'required' => true,
            ),
            'city' => array(
                'required' => true,
            ),
            'date' => array(
                'required' => true,
            ),
            'time' => array(
                'required' => true,
            )
        ));
        if ($validation->passed()) {

            try {
                DB::getInstance()->insert("tourdates", array(
                    'city' => Input::get('city'),
                    'event' => Input::get('event'),
                    'date' => Input::get('date'),
                    'time' => Input::get('time')
                ));

                Session::flash('home', 'The gig is inserted in the database');
                Redirect::to('index.php');

            } catch (Exception $e) {
                Session::flash('home', 'Something went wrong');
                Redirect::to('index.php');
            }

        } else {
            foreach ($validation->errors() as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
    }
}

if (Session::exists('profile')) {
    echo '<p style="background-color: darkgray;">' . Session::flash('profile') . '</p>';
}
?>
<?php
include 'header.php';
?>


<div id="page">

    <div id="userinfo">



        <?php

        /* SHOW PROFILE PIC */
        ?>
        <img src="<?php echo escape($user->data()->profile) ?>" style="width: 125px; height: 125px;">
        <?php


        ?>

        <ul>
            <li><?php if (isset($data->name)) echo escape($data->name);
                else echo 'unknown'; ?></li>

            <li>City: <?php if (isset($data->city)) echo escape($data->city);
                else echo 'unknown'; ?></li>

            <li>Country: <?php if (isset($data->country)) echo escape($data->country);
                else echo 'unknown'; ?></li>

            <li>Email: <?php if (isset($data->email)) echo escape($data->email);
                else echo 'unknown'; ?></li>

        </ul>

    </div>

    <?php
    if($user->hasPermission()->first()->id == 3){
    ?>
        <div id="allUsers">
            <a href="adminpanel.php"><h4 style="color:red;">Click here for <b>adminpanel</b></h4></a></br>



            <h1>Add a new gig</h1>
            <form action="#" method="post">
                <label for="event">Event</label>
                <input type="text" name="event" id="event" required="required">
                <label for="city">City</label>
                <input type="text" name="city" id="city" required="required">
                <label for="date">Date (Format: dd/mm/yyyy if you do it wrong the world will explode)</label>
                <input type="text" name="date" id="date" required="required">
                <label for="time">Time</label>
                <input type="number" name="time" id="time" min="1" max="24" placeholder="o\'clock" required="required">
                <input type="submit" value="Add date">
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            </form>
        </div>

    <?php
    }?>

    <div id="reviewsummary">
        <h1>Reviews</h1>
        <p>
            <?php
            $reviews = DB::getInstance()->get('reviews', array('userid', '=', $data->id));
            foreach ($reviews->results() as $rev){
                echo "<h4>".$rev->title."</h4>";
                echo "<p>".$rev->content."</p>";
            }

            ?>
        </p>
    </div>
</div>


<?php
include 'footer.php';
?>

</body>

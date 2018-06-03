<?php
if ($user->isLoggedIn()) {
    ?>
    <div id="personal" class="dropdown">
        <a href="#" class="dropbtn"><?php echo escape($user->data()->name) ?></a>
        <div class="dropdown-content">
            <a href="profile.php?user=<?php echo escape($user->data()->username); ?>">My Profile</a>
            <a href="update.php">Update</a>
            <a href="changepassword.php">Change pw</a>
            <a class="logout" href="logout.php">Logout</a>
        </div>
        <?php
        if ( !(empty($user->data()->profile)) ) {
            /* SHOW PROFILE PIC */
            ?>
            <img src="<?php echo escape($user->data()->profile) ?>" style="width: 25px; height: 25px;">
            <?php
        } else {
            /* show standard */
            ?> <img src="images/standard.gif"> <?php
        }

        ?>
    </div>

<?php }

    else { ?>

    <div id="personal" class="login">
        <form method="post" action="login.php" accept-charset="utf-8">
            <div>
                <input type="text" class="form-control" id="username" placeholder="username" value=""
                       name="username">
            </div>
            <div>
                <input type="password" class="form-control" placeholder="password" id="password" name="password"
                       value="">
            </div>
            <input type="hidden" name="<?php echo Token::generate(); ?>">
            <button type="submit" class="btn btn-primary">Log in</button>
        </form>
        <p><a href="register.php">or register!</a></p>
    </div>
    <?php
}
?>

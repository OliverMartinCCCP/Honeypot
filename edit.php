<?php

require_once 'core/init.php';


$user = new User();


if($user->hasPermission()->first()->id == 3){
    $id = $_GET["id"];
    $profile = DB::getInstance()->get("users", array("id", "=", $id));
    $data = $profile->first();




    // Edit profile pic
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
                echo 'Upload geslaagd';
                // update
                // $file_tmp, 'images/profile'.$file_name into profile users tabel
                $profile->update("users", $data->id, array(
                    'profile' => "images/".$file_name
                ));
            };
        }else{
            foreach($errors as $error){
                echo $error, '<br />';
            }
        }

    } else {
        if (!empty($_POST) ){
            try{
                $db = DB::getInstance();
                $db->update( 'users', $data->id, array(
                    "id" => $_POST['id'],
                    "name" => $_POST['name'],
                    "username" => $_POST['username'],
                    "email" => $_POST['email'],
                    "country" => $_POST['country'],
                    "city" => $_POST['city']
                ));

                Session::flash('home', 'user profile updated');
                Redirect::to('adminpanel.php');

            } catch(Exception $e){
                die($e->getMessage());

            }
        }
    }
    // Edit user data

} else {
    Redirect::to('index.php');
}
?>



<div class="container">
    <div class="row">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="size" value="100000">
            <div>
                <input type="file" name="image">
            </div>

            <button type="submit" name="upload image" >change</button>

        </form>
        <form class="form-horizontal" action="" method="post">

            <!-- Address form -->

            <h2>User Profile</h2>
            <img src="<?php echo escape($data->profile) ?>" style="width: 125px; height: 125px;">
            <div class="form-group field">



            </div>
            <!-- first-name input-->
            <div class="control-group">
                <label class="control-label">id</label>
                <div class="controls">
                    <input name="id" type="text" value="<?php echo escape($data->id) ?>"
                           class="input-xlarge">
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input  name="name" type="text" value="<?php echo escape($data->name) ?>"
                            class="input-xlarge">
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                    <input name="username" type="text" value="<?php echo escape($data->username) ?>"
                           class="input-xlarge">
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input name="email" type="text" value="<?php echo escape($data->email) ?>"
                           class="input-xlarge">
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    <input name="country" type="text" value="<?php echo escape($data->country) ?>"
                           class="input-xlarge">
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <input name="city" type="text" value="<?php echo escape($data->city) ?>"
                           class="input-xlarge">
                    <p class="help-block"></p>
                </div>
            </div>

            <button>update</button>
            <button><a href="adminpanel.php">Adminpanel</a></button>

        </form>
    </div>
</div>

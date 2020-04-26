<?php

include_once '../bootstrap.php';

$id = null;
$name = '';
$details = '';
$message = '';
$error = false;
try{
        $User = new User();

    if(@$_POST['save']) {
        if(
                !empty($_POST['name'])
                && !empty($_POST['email'])
                && !empty($_POST['password'])
                && !empty($_POST['confirm_password'])
        ) {
            // update
            $name = $_POST['name'];
            $email = $_POST['email'];
            $details = $_POST['details'];
            $type = $_POST['type'];
            $password = md5($_POST['password']);
            $confirm_password = md5($_POST['confirm_password']);
            if($password != $confirm_password) {
                $error = true;
                $message = "Passwords do not match!";
            }

        }else {
            $error = true;
            $message = "Empty fields!";

        }
        if(!$error && User::where(compact('email'))->exists()) {
            $message = 'Record already exists with same email';
            $error = true;
        }
        if(!$error){
            $User->name = $name;
            $User->email = $email;
            $User->type = $type;
            $User->password = $password;
            $User->save();
            $message = "Registered please login ";

        }
    }

}catch (Exception $exception){
    throw $exception;
}


?>
<?php
    if(!empty($message)) {
        ?>
        <p><?php echo $message; ?></p>
        <?php
    }
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
    <?php if($User->id) { ?>
        <input type="hidden" name="record_id" value="<?php echo $User->id; ?>" placeholder="User Name" required>
    <?php } ?>
    Name:
    <input type="text" name="name" value="<?php echo $User->name; ?>" placeholder="User Name" required>
    email:
    <input type="text" name="email" value="<?php echo $User->email; ?>" placeholder="Email" required>
    Password:
    <input type="password" name="password" placeholder="Password" required>
    <div>
        confirm password:
        <input type="password" name="confirm_password" placeholder="Password" required>

    </div>

    Type:
    <input type="hidden" value="user" name="type" />
    Address
    <textarea required name="details"><?php echo $User->address; ?></textarea>
    <input type="submit" name="save" value="Save" />
</form>
<?php

include_once '../../bootstrap.php';

$id = null;
$name = '';
$details = '';
$message = '';
$error = false;
try{
    if(isset($_GET['id']) || isset($_POST['record_id'])) {
        $id = isset($_POST['record_id']) ? $_POST['record_id'] : $_GET['id'];
        $User = User::findOrFail($id);
    }else {
        $User = new User();
    }

    if(@$_POST['save']) {
        if(!empty($_POST['name']) && !empty($_POST['details'])) {
            // update
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $details = $_POST['details'];
            $type = $_POST['type'];
            $password = md5($_POST['password']);
            if(isset($User->id)) {
                $id = $_POST['record_id'];
                if(User::where(compact('email'))
                    ->where('id','!=', $User->id)->exists()) {
                    $message = 'Record already exists with same email';
                    $error = true;
                }else{
                    $User->name = $name;
                    $User->email = $email;
                    $User->type = $type;
                    $User->password = $password;

                    $User->save();
                }
                $status = 'updated';
            }else {
                $status = 'added';
                if(User::where(compact('email'))->exists()) {
                    $message = 'Record already exists with same email';
                    $error = true;
                }else{

                    $User->name = $name;
                    $User->email = $email;
                    $User->type = $type;
                    $User->password = $password;

                    $User->save();
                }
            }
            if(!$error)
            $message = "Record " . $status;
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
    <input type="text" name="password" placeholder="Password" required>
    Type:
    <select name="type">
        <option value="user" <?php if($User->type == 'user') echo 'selected'; ?>>User</option>
        <option value="admin"  <?php if($User->type == 'admin') echo 'selected'; ?>>Admin</option>
    </select>
    Address
    <textarea required name="details"><?php echo $User->address; ?></textarea>
    <input type="submit" name="save" value="Save" />
</form>
<?php
include 'list.php';
?>
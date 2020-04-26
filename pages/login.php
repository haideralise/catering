<?php

include_once '../bootstrap.php';

session_start();
print_r($_SESSION);
$message = '';
$error = false;
if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $error = true;
        $message = 'email is invalid';
    }
    if(!User::where('email', $_POST['email'])->exists()) {
        $error = true;
        $message = 'User does not exists';
    }
    $user = User::where([
        'email' => $_POST['email'],
        'password' => md5($_POST['password'])
    ])->first();
    if(!$user) {
        $error = true;
        $message = 'Invalid credentials';
    }
    $_SESSION['user'] = $user->toArray();
    header('Location:home.php');

}else{
    $error = true;
    $message = 'Empty fields';
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <p><input type="email" required name="email" placeholder="email" /></p>
    <p><input type="password" required name="password" placeholder="password" /></p>
    <input type="submit" value="Login" name="submit" />
</form>

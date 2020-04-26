<?php
include_once '../../../bootstrap.php';

    $category = Category::findOrFail($_POST['id']);
    if(isset($_POST['YES'])) {
        Category::where('id', $_POST['record_id'])->delete();
        header('Location: form.php');
        exit();
    }
    if(isset($_POST['NO'])) {
        header('Location: form.php');
        exit();
    }
?>
<form action="<?php  echo $_SERVER['PHP_SELF'];?>" method="post">
    <h1>Do you really want to delete this <b><?php echo $category->name; ?></b> category?</h1>
    <input type="hidden" name="id" value="<?php echo $category->id; ?>" />
    <input type="hidden" name="record_id" value="<?php echo $category->id; ?>" />
    <input type="submit" name="YES" value="YES"/>
    <input type="submit" name="NO" value="NO"/>
</form>

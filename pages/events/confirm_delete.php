<?php
include_once '../../bootstrap.php';

    $product = Product::findOrFail($_POST['id']);
    if(isset($_POST['YES'])) {
        Product::where('id', $_POST['record_id'])->delete();
        header('Location: form.php');
        exit();
    }
    if(isset($_POST['NO'])) {
        header('Location: form.php');
        exit();
    }
?>
<form action="<?php  echo $_SERVER['PHP_SELF'];?>" method="post">
    <h1>Do you really want to delete this <b><?php echo $product->name; ?></b> Product?</h1>
    <input type="hidden" name="id" value="<?php echo $product->id; ?>" />
    <input type="hidden" name="record_id" value="<?php echo $product->id; ?>" />
    <input type="submit" name="YES" value="YES"/>
    <input type="submit" name="NO" value="NO"/>
</form>

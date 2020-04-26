<?php

include_once '../../../bootstrap.php';

$id = null;
$name = '';
$details = '';
$message = '';
$error = false;
try{
    if(isset($_GET['id']) || isset($_POST['record_id'])) {
        $id = isset($_POST['record_id']) ? $_POST['record_id'] : $_GET['id'];
        $category = Category::findOrFail($id);
    }else {
        $category = new Category();
    }

    if(@$_POST['save']) {
        if(!empty($_POST['name']) && !empty($_POST['details'])) {
            // update
            $name = $_POST['name'];
            $details = $_POST['details'];
            if(isset($category->id)) {
                $id = $_POST['record_id'];
                if(Category::where(compact('name'))->where('id','!=', $category->id)->exists()) {
                    $message = 'Record already exists with same name';
                    $error = true;
                }else{
                    $category->name = $name;
                    $category->details = $details;
                    $category->save();
                }
                $status = 'updated';
            }else {
                $status = 'added';
                if(Category::where(compact('name'))->exists()) {
                    $message = 'Record already exists with same name';
                    $error = true;
                }else{
                    $category->save(compact('name','details'));
                }
            }
            if(!$error)
            $message = "Record " . $status;
        }
    }

}catch (Exception $exception){
    dd($exception->getMessage());
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
    <?php if($category->id) { ?>
        <input type="hidden" name="record_id" value="<?php echo $category->id; ?>" placeholder="Category Name" required>
    <?php } ?>
    Name:
    <input type="text" name="name" value="<?php echo $category->name; ?>" placeholder="Category Name" required>
    Details
    <textarea required name="details"><?php echo $category->details; ?></textarea>
    <input type="submit" name="save" value="Save" />
</form>
<?php
include 'list.php';
?>
<?php

include_once '../../bootstrap.php';

$id = null;
$name = '';
$details = '';
$message = '';
$error = false;
$errors = [];
$categories = Category::get();
try{
    if(isset($_GET['id']) || isset($_POST['record_id'])) {
        $id = isset($_POST['record_id']) ? $_POST['record_id'] : $_GET['id'];
        $Product = Product::findOrFail($id);
    }else {
        $Product = new Product();
    }

    if(@$_POST['save']) {

        if(!empty($_POST['name']) && !empty($_POST['details']) && isset($_FILES['image'])) {
            // update
            $name = $_POST['name'];
            $details = $_POST['details'];
            $category_id= $_POST['category_id'];
            $price = $_POST['price'];
            $data = compact('name','details', 'category_id');
            if(isset($_FILES['image'])){
                $errors= array();
                $file_name = $_FILES['image']['name'];
                $file_size =$_FILES['image']['size'];
                $file_tmp =$_FILES['image']['tmp_name'];
                $file_type=$_FILES['image']['type'];
                $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

                $extensions= array("jpeg","jpg","png");

                if(in_array($file_ext,$extensions)=== false){
                    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                }

                if($file_size > 2097152){
                    $errors[]='File size must be excately 2 MB';
                }

                if(empty($errors)==true){
                    move_uploaded_file($file_tmp,"uploads/".$file_name);
                    $Product->image = $file_name;
                }else{
                    $errors[]='file could not uploaded';
                }
            }
            if(isset($Product->id)) {
                $id = $_POST['record_id'];
                if(Product::where(compact('name'))
                    ->where('id','!=', $Product->id)
                    ->where('category_id','!=', $category_id)
                    ->exists()) {
                    $message = 'Record already exists with same name';
                    $error = true;
                }else{
                    $Product->name = $name;
                    $Product->details = $details;
                    $Product->price = $price;
                    $Product->category_id = $category_id;
                    $Product->save();
                }
                $status = 'updated';
            }else {
                $status = 'added';
                if(Product::where(compact('name', 'category_id'))->exists()) {
                    $message = 'Record already exists with same name';
                    $error = true;
                }else{
                    $Product->name = $name;
                    $Product->price = $price;
                    $Product->details = $details;
                    $Product->category_id = $category_id;
                    $Product->save();
                }
            }
            if(!$error) {
                $message = "Record " . $status;
                $target_dir = "uploads/";
            }
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
    <?php if($Product->id) { ?>
        <input type="hidden" name="record_id" value="<?php echo $Product->id; ?>" placeholder="Product Name" required>
    <?php } ?>
    <div>
        Name:
        <input type="text" name="name" value="<?php echo $Product->name; ?>" placeholder="Product Name" required>
    </div>
    <div>
        Price:

        <input type="number" name="price" value="<?php echo $Product->price; ?>" placeholder="Product Price" required>
    </div>
  <div>
      Select image to upload:
      <input type="file" name="image" id="fileToUpload">
      <?php if($Product->id) { ?>
            <img src="uploads/<?php echo $Product->image;?>" height="200" width="200">
      <?php } ?>

  </div>
    <div>
        <select name="category_id">
            <?php foreach ($categories as $category) {
                ?>
                <option value="<?php echo $category->id; ?>" <?php if($category->id == $Product->category_id) echo 'selected'; ?>><?php echo $category->name; ?></option>
                <?php
            }?>
        </select>
    </div>

  <div>
      Details
      <textarea required name="details"><?php echo $Product->details; ?></textarea>
  </div>
    <input type="submit" name="save" value="Save" />
</form>
<?php
include 'list.php';
?>
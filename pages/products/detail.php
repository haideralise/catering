<?php
include_once '../../bootstrap.php';
$product = Product::findOrFail($_GET['id']);
?>
<h1><?php echo $product->name; ?></h1>
<img src="uploads/<?php echo $product->image; ?>">
<h3><?php echo Category::findOrFail($product->category_id)->name; ?></h3>
<h4>Price : <?php echo $product->price; ?></h4>
<div><?php echo $product->details; ?></div>
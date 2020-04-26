<?php
include_once '../bootstrap.php';

$categories = Category::all();
$products = Product::all();
try {
    ?>
    <h1>Provide Food Types</h1>
    <ul>
        <?php
        foreach ($categories as $category) {
            ?>
            <li><?php echo $category->name;?> (<?php echo $products->where('category_id', $category->id)->count(); ?>)</li>
        <?php
        }
        ?>
    </ul>
    <?php
    foreach ($products as $product) {
        ?>
        <div> <img src="products/uploads/<?php echo $product->image; ?>" height="200px" width="200px">
            <h4><?php echo $product->name; ?></h4>
            <p><?php echo $product->price; ?></p>
            <div><?php str_pad($product->details, 200, '...') ?></div>
        </div>
<?php
    }
}catch (Exception $exception) {
    throw $exception;
}
?>

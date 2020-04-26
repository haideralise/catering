<?php
include_once '../../bootstrap.php';
$categories = User::get()->toArray();
?>
<table>
    <?php
 foreach($categories as $row) {
    ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email'];?></td>
        <td>
            <form method="post" action="confirm_delete.php">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                <input type="submit" value="Delete" />
            </form>
        </td>
        <td><a href="?id=<?php echo $row['id'];?>">Edit</a></td>
    </tr>
    <?php
}
?>
</table>

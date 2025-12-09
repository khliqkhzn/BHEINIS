<?php
include("../db.php");

if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);

    $sql = "SELECT sizes.size_name 
            FROM sizes 
            JOIN category_sizes ON sizes.size_id = category_sizes.size_id
            WHERE category_sizes.category_id = $category_id";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<label>Size & Quantity:</label><div class="size-group">';
        while ($row = mysqli_fetch_assoc($result)) {
            $size = $row['size_name'];
            echo "<div>
                    <label>$size</label>
                    <input type='number' name='size_qty[$size]' min='0' value='0'>
                  </div>";
        }
        echo '</div>';
    } else {
        echo '<p><i>No sizes for this category.</i></p>';
    }
}
?>

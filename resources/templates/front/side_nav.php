<div class="col-md-3">
    <p class="lead">Shop Name</p>
    <div class="list-group">
        <?php 
            // ask for something from database
            $query = "SELECT (cat_title) FROM categories";
            $send_query = mysqli_query($connection, $query);
            
            // see if something is wrong with the query or the connection
            if(!$send_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            };

            // extract the values from each row (best to have 1 column/field for each table in db)
            while($row = mysqli_fetch_array($send_query)) {
                echo "<a href='' class='list-group-item'>{$row['cat_title']}</a>";

            };
        ?>
    </div>
</div>
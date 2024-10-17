<div class="row">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Most Viewed Today</b></h3>
        </div>
        <div class="box-body">
            <ul id="trending">
            <?php
                // Ensure PDO is initialized
                if (isset($pdo)) {
                    $now = date('Y-m-d');
                    $conn = $pdo->open(); // Use the global PDO connection

                    try {
                        $stmt = $conn->prepare("SELECT * FROM products WHERE date_view = :now ORDER BY counter DESC LIMIT 10");
                        $stmt->execute(['now' => $now]);

                        // Loop through products and display them
                        foreach ($stmt as $row) {
                            echo "<li><a href='product.php?product=" . htmlspecialchars($row['slug']) . "'>" . htmlspecialchars($row['name']) . "</a></li>";
                        }
                    } catch (PDOException $e) {
                        // Handle any errors that occur while querying the database
                        echo "<p>Error fetching most viewed products: " . $e->getMessage() . "</p>";
                    } finally {
                        // Always close the connection when done
                        $pdo->close();
                    }
                } else {
                    // If the PDO connection is not established
                    echo "<p>Database connection not established.</p>";
                }
            ?>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Become a Subscriber</b></h3>
        </div>
        <div class="box-body">
            <p>Get free updates on the latest products and discounts, straight to your inbox.</p>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat"><i class="fa fa-envelope"></i> </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class='box box-solid'>
        <div class='box-header with-border'>
            <h3 class='box-title'><b>Follow us on Social Media</b></h3>
        </div>
        <div class='box-body'>
            <a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
            <a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
            <a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
            <a class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
            <a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
        </div>
    </div>
</div>

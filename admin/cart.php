<?php 
include 'includes/session.php';

// Redirect if user is not specified
if(!isset($_GET['user'])){
    header('location: users.php');
    exit();
}

// Fetch user details
$conn = $pdo->open();

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id'=>$_GET['user']]);
    $user = $stmt->fetch();
} catch(PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
} finally {
    $pdo->close();
}

include 'includes/header.php'; 
?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/menubar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1><?php echo $user['firstname'].' '.$user['lastname'].'`s Cart' ?></h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Users</li>
                    <li class="active">Cart</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php
                // Display error/success messages
                include 'includes/messages.php';
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <a href="#addnew" data-toggle="modal" id="add" data-id="<?php echo $user['id']; ?>" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
                                <a href="users.php" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Users</a>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Tools</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch and display cart items
                                        $conn = $pdo->open();

                                        try {
                                            $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
                                            $stmt->execute(['user_id'=>$user['id']]);
                                            foreach($stmt as $row){
                                                echo "
                                                <tr>
                                                    <td>".$row['name']."</td>
                                                    <td>".$row['quantity']."</td>
                                                    <td>
                                                        <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['cartid']."'><i class='fa fa-edit'></i> Edit Quantity</button>
                                                        <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['cartid']."'><i class='fa fa-trash'></i> Delete</button>
                                                    </td>
                                                </tr>
                                                ";
                                            }
                                        } catch(PDOException $e) {
                                            echo $e->getMessage();
                                        } finally {
                                            $pdo->close();
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/cart_modal.php'; ?>

    </div>
    <!-- ./wrapper -->

    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function(){
            // Edit and delete buttons functionality
            $(document).on('click', '.edit', function(e){
                e.preventDefault();
                $('#edit').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $(document).on('click', '.delete', function(e){
                e.preventDefault();
                $('#delete').modal('show');
                var id = $(this).data('id');
                getRow(id);
            });

            $('#add').click(function(e){
                e.preventDefault();
                var id = $(this).data('id');
                getProducts(id);
            });

            $("#addnew").on("hidden.bs.modal", function () {
                $('.append_items').remove();
            });

        });

        function getProducts(id){
            // Fetch products via AJAX
            $.ajax({
                type: 'POST',
                url: 'products_all.php',
                dataType: 'json',
                success: function(response){
                    $('#product').append(response);
                    $('.userid').val(id);
                }
            });
        }

        function getRow(id){
            // Fetch row details via AJAX
            $.ajax({
                type: 'POST',
                url: 'cart_row.php',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    $('.cartid').val(response.cartid);
                    $('.userid').val(response.user_id);
                    $('.productname').html(response.name);
                    $('#edit_quantity').val(response.quantity);
                }
            });
        }
    </script>
</body>
</html>

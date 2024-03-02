<?php
include 'includes/session.php';

// Retrieve the sales ID from the POST data
$id = $_POST['id'];

// Establish database connection
$conn = $pdo->open();

// Initialize output array
$output = array('list'=>'');

// Prepare and execute SQL query to fetch details of a specific sale
$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales ON sales.id=details.sales_id WHERE details.sales_id=:id");
$stmt->execute(['id'=>$id]);

// Initialize total sales amount
$total = 0;

// Iterate through each row of the result set
foreach($stmt as $row){
    // Store transaction details in the output array
    $output['transaction'] = $row['pay_id'];
    $output['date'] = date('M d, Y', strtotime($row['sales_date']));
    
    // Calculate subtotal for each item and update total sales amount
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    
    // Append HTML for each item to the list in the output array
    $output['list'] .= "
        <tr class='prepend_items'>
            <td>".$row['name']."</td>
            <td>&#36; ".number_format($row['price'], 2)."</td>
            <td>".$row['quantity']."</td>
            <td>&#36; ".number_format($subtotal, 2)."</td>
        </tr>
    ";
}

// Add total sales amount to the output array
$output['total'] = '<b>&#36; '.number_format($total, 2).'<b>';

// Close database connection
$pdo->close();

// Output JSON-encoded data
echo json_encode($output);
?>

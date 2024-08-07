<?php
session_start();
include_once('connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['cusToken'])){
  // Get the values from the AJAX request
  $cus_token = $_POST['cusToken'];
  $tempId = $_POST['tempId'];
  $quantity = $_POST['quantity'];

  $stmt0 = $conn->prepare('SELECT temporary_orders.*, menu_options.cost 
                            FROM temporary_orders 
                            INNER JOIN menu_options 
                            ON temporary_orders.menu_option_id = menu_options.id 
                            WHERE temporary_orders.id = ?');
  $stmt0->bind_param('s', $tempId);
  $stmt0->execute();
  $result0 = $stmt0->get_result();
  
  if ($result0->num_rows == 1) {
    $row = $result0->fetch_assoc();
    $cost = $row['cost'];

    $total_cost = $quantity * $cost;

    // Update the quantity and total_cost in the database
    $stmt = $conn->prepare('UPDATE temporary_orders SET quantity = ?, total_cost = ? WHERE id = ? AND users_token = ?');
    $stmt->bind_param('diss', $quantity, $total_cost, $tempId, $cus_token);
  
    if ($stmt->execute()) {
        // Quantity updated successfully
        $response = array('status' => 'success', 'message' => 'Quantity updated');
        echo json_encode($response);
    } else {
        // Error updating quantity
        $response = array('status' => 'error', 'message' => 'Failed to update quantity');
        echo json_encode($response);
    }
  } else {
    // No matching record found
    $response = array('status' => 'error', 'message' => 'Invalid temporary order ID');
    echo json_encode($response);
  }
  // Close the prepared statement
  $stmt0->close();
  $stmt->close();
  }
  
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['remove'])) {
    // Remove button was clicked
    $tempId = $_POST['tempId'];

    // Check if the tempId is valid and not empty
    if (!empty($tempId)) {
      // Prepare the SQL statement to delete the record
      $sql = "DELETE FROM temporary_orders WHERE id = ?";

      // Create a prepared statement
      $stmt = $conn->prepare($sql);

      // Bind the tempId value to the prepared statement
      $stmt->bind_param('i', $tempId);

      // Execute the prepared statement
      if ($stmt->execute()) {
          // Return a success response
          echo 'Content removed successfully';
      } else {
          // Return an error response
          echo 'Error removing content';
      }

      // Close the prepared statement
      $stmt->close();
    } else {
      // Return an error response for invalid tempId
      echo 'Invalid tempId';
    }
  }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['customer_token']) && isset($_POST['staff_id'])){
  $customer_token = $_POST['customer_token'];
  $staff_id = $_POST['staff_id'];

  $stmt = $conn->prepare('SELECT SUM(total_cost) AS totalCost FROM temporary_orders WHERE user_id = ? AND users_token = ?');
  $stmt->bind_param('is', $staff_id, $customer_token);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $totalCost = $row['totalCost'];

      if (!is_numeric($totalCost)) {
          echo "Error: total cost is not a number";
      } else {
          echo $totalCost;
      }
  } else {
      echo "0";
  }

  $stmt->close();  // Close the statement
} else {
  echo "0";
}
}


?>

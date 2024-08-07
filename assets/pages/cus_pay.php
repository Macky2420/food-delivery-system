<?php 
include_once('head.php');
include_once('../php/connection.php');?>
<div class="col-span-9 lg:col-span-2 w-full relative">
                        <div class="bg-gray-300 lg:bg-gray-200 py-10 px-5 h-full lg:fixed overflow-auto myOrder ">
                            <p class="font-bold text-3xl">My Orders</p>
                            <div class="flex flex-row items-center gap-x-2 mt-2 font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                <?php 
                                    if (isset($_GET['token'])){
                                    $cus_token = $_GET['token'];
                                    $stmt1 = $conn->prepare('SELECT name FROM users WHERE token = ?'); 
                                    $stmt1->bind_param('s', $cus_token);
                                    $stmt1->execute();
                                    $result1 = $stmt1->get_result();
                                    if ($result1->num_rows > 0) {
                                        $row = $result1->fetch_assoc();
                                        $cus_name = $row['name'];
                                        ?>
                                        <p><?php echo $cus_name; ?></p>
                                    <?php
                                    }

                                }
                                    ?>

                            </div>
                            <!-- Filter Buttons -->
                            <div class="flex gap-y-4 flex-col xl:flex-row items-center gap-x-5 my-5 select-none text-sm">
                                <div id="newButton" class="flex flex-row items-center justify-center gap-x-3 border-3 font-bold py-1.5 px-4 rounded-full w-full xl:w-40 cursor-pointer bg-green-800 text-white hover:bg-green-800 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <p>New Order</p>
                                </div>

                                <div id="submitButton" class="flex flex-row items-center justify-center gap-x-3 border-3 border-green-800 text-center font-bold py-1.5 px-4 rounded-full w-full xl:w-52 cursor-pointer text-green-800 hover:bg-green-800 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <p>Submitted Order</p>
                                </div>
                            </div>
                            <div class="mt-8 min-h-screen" wire:poll>

                           
                                <form id="newContent" class="my-10 visible" action="../php/action.php" method="post">
                                <?php 
                                    if (isset($_GET['token'])){
                                    $stmt2 = $conn->prepare('SELECT t.*, m.name AS menu_name, m.thumbnail AS menus_image, mo.name AS option_name, t.quantity AS order_quantity, t.id AS temp_id, mo.cost AS option_cost FROM temporary_orders t JOIN menus m ON t.menu_id = m.id JOIN menu_options mo ON t.menu_option_id = mo.id WHERE t.user_id = ? AND t.users_token = ? ORDER BY t.id DESC'); 
                                    $stmt2->bind_param('ss', $_SESSION['staff_id'], $cus_token);
                                    $stmt2->execute();
                                    $result2 = $stmt2->get_result();

                                    if ($result2->num_rows > 0) {
                                        $rows = $result2->fetch_all(MYSQLI_ASSOC);
                                        $rows = array_reverse($rows);
                                        foreach ($rows as $row2) {
                                            $data[] = $row2;
                                        }
                                        $data = array_reverse($data);
                                        foreach ($data as $row2) {
                                            ?>
                                        <div class="flex flex-col gap-y-4 mb-10 text-sm">
                                            <div id="myDiv-<?php echo $row2['temp_id']; ?>" class="bg-white p-4 grid grid-cols-6 gap-x-4 rounded-lg group">
                                                <div class="col-span-6 xl:col-span-2 shadow-lg relative w-auto h-full rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                                    <img class="h-full w-auto object-cover" src="../images/<?php echo $row2['menus_image']; ?>">
                                                </div>

                                                <!-- Desktop -->
                                                <div class="hidden col-span-6 xl:col-span-2 xl:flex flex-col justify-between gap-y-3">
                                                    <div class="">
                                                        <p class="font-bold whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"><?php echo $row2['menu_name']; ?></p>
                                                        <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Option: <?php echo $row2['option_name']; ?></p>
                                                    </div>
                                                    <div class="flex flex-row items-center">
                                                        <button type="button" id="decrement-<?php echo $row2['temp_id']; ?>" wire:dirty.class="text-red-500" class="decrement-button px-3 py-0.5 bg-green-800 hover:bg-green-600 text-white font-bold text-xl rounded-l-full transition-all duration-500">-</button>
                                                        <input type="hidden" id="cus_token" name="token" value="<?php echo $_GET['token']; ?>">
                                                        <input type="hidden" id="temp_id" value="<?php echo $row2['temp_id']; ?>">
                                                        <p id="current_quant-<?php echo $row2['temp_id']; ?>" class="px-4 py-1 text-md font-bold w-10 text-center border-2 border-green-800"><?php echo $row2['order_quantity']; ?></p>
                                                        <button type="button" id="increment-<?php echo $row2['temp_id']; ?>" class="increment-button px-3 py-0.5 bg-green-800 hover:bg-green-600 text-white font-bold text-xl rounded-r-full transition-all duration-500">+</button>
                                                    </div>
                                                </div>
                                                <div class="hidden col-span-6 xl:col-span-2 xl:flex flex-col items-end justify-between">
                                                    <p id="totalCost-<?php echo $row2['temp_id']; ?>" class="font-extrabold">PHP <?php echo number_format($row2['option_cost'], 2); ?></p>
                                                    <button id="remove-<?php echo $row2['temp_id']; ?>" type="button" class="remove-button bg-red-800 text-white rounded-full px-3 py-1.5 hover:bg-red-600 transition-all duration-500"> Remove </button>
                                                </div>

                                                <!-- Smarthphone -->
                                        
                                                <div class="xl:hidden col-span-6 flex flex-col justify-between gap-y-3">

                                                    <div class="mt-4">
                                                        <p class="font-bold whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"><?php echo $row2['menu_name']; ?></p>
                                                        <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Option: <?php echo $row2['option_name']; ?></p>
                                                    </div>
                                                    
                                                    <div class="flex flex-row items-center gap-x-2 w-full">
                                                        <div class="flex flex-row items-center">
                                                            <button type="button" wire:dirty.class="text-red-500" id="decrement-<?php echo $row2['temp_id']; ?>" class="decrement-button px-3 py-0.5 bg-green-800 hover:bg-green-600 text-white font-bold text-xl rounded-l-full transition-all duration-500">-</button>
                                                                <input type="hidden" id="cus_token" name="token" value="<?php echo $_GET['token']; ?>">
                                                                <input type="hidden" id="temp_id" value="<?php echo $row2['temp_id']; ?>">
                                                                <p id="current_quant-<?php echo $row2['temp_id']; ?>" class="px-4 py-1 text-md font-bold w-10 text-center border-2 border-green-800"><?php echo $row2['order_quantity']; ?></p>
                                                            <button type="button" id="increment-<?php echo $row2['temp_id']; ?>" class="increment-button px-3 py-0.5 bg-green-800 hover:bg-green-600 text-white font-bold text-xl rounded-r-full transition-all duration-500">+</button>
                                                        </div>
                                                        <button id="remove-<?php echo $row2['temp_id']; ?>" type="button" class="remove-button bg-red-800 text-white rounded-full px-4 py-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                </div>

                                                <div class="xl:hidden col-span-6 mt-4">
                                                    <p class="font-extrabold">PHP <?php echo number_format($row2['option_cost'], 2); ?></p>
                                                </div>
                                            </div>
                                            <?php }
                                                
                                            } if (isset($_GET['token'])){
                                                $token = $_GET['token'];
                                                $stmt2 = $conn->prepare('SELECT users_token FROM temporary_orders WHERE users_token = ?'); 
                                                $stmt2->bind_param('s', $token);
                                                $stmt2->execute();
                                                $result2 = $stmt2->get_result();
                                                
                                                if ($result2->num_rows == 0){ ?>
                                      
                                                <div class="my-20 w-full">
                                                    <img src="../img/tree.svg" class="w-1/2 mx-auto">
                                                    <p class="text-center font-bold mt-2">No orders yet.</p>
                                                </div>
                                                <?php }
                                                }?>
                                            
                                        
                                                
                                              
                                    <div>
                                        <p class="font-bold mb-2">Additional Requests</p>
                                        <textarea name="request" class="rounded-lg mb-4 w-full h-32 p-3" wire:model="remark" placeholder="Enter your request here"></textarea>
                                    </div>
                                        <div>
                                            <p class="font-bold mb-2">Meal Time</p>
                                            <select name="meal_time" class="rounded-lg mb-4 w-full p-3" wire:model="mealTime" required>
                                          <option value="">--SELECT--</option>
                                          <option value="Breakfast (6:00 am - 9:00 am)">Breakfast (6:00 am - 9:00 am)</option>
                                          <option value="Lunch (10:00 pm - 2:00 pm)">Lunch (10:00 am - 2:00 pm)</option>
                                          <option value="Snack/Merienda (3:00 pm - 5:00 pm)">Snack/Merienda (3:00 pm - 5:00 pm)</option>
                                          <option value="Dinner (6:00 pm - 8:00 pm)">Dinner (6:00 pm - 8:00 pm)</option>
                                        </select>
                                      </div>

                                      <div>
                                        <p class="font-bold mb-2">Order Type</p>
                                        <select name="order_type" class="rounded-lg mb-4 w-full p-3" wire:model="paymentMethod" required>
                                          <option value="">--SELECT--</option>
                                          <option value="Dine-in">Dine-in</option>
                                          <option value="Take-out">Take-out</option>
                                        </select>
                                      </div>

                                      <div>
                                        <p class="font-bold mb-2">Payment Method</p>
                                        <select name="payment" class="rounded-lg mb-4 w-full p-3" wire:model="paymentMethod" required>
                                          <option value="">--SELECT--</option>
                                          <option value="Cash only">Cash only</option>
                                          <option value="Gcash" disabled class="bg-gray-300">Gcash</option>
                                          <option value="Paypal" disabled class="bg-gray-300">Paypal</option>
                                        </select>
                                      </div>

                                      <div class="bg-green-800 w-full h-1 mt-5"></div>
                                            <?php 
                                          $stmt4 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                                          $stmt4->bind_param('s', $_SESSION['staff']);
                                          $stmt4->execute();
                                          if ($result = $stmt4->get_result()){
                                            $row = $result->fetch_assoc();
                                            $id = $row['id'];?>
                                        <div class="flex flex-row items-center justify-between text-lg font-extrabold my-5">
                                            <input type="hidden" id="cus_token" name="cus_token" value="<?php echo $_GET['token'];?>">
                                            <input type="hidden" id="staff_id" name="staff_id" value="<?php echo $id;?>">
                                            <input type="hidden" name="total" id="total_prize_input">
                                            <?php }?>
                                            <p>Total</p>
                                            <p class="tracking-widest" id="total_prize"></p>
                                        </div>
                                        <button type="submit" name="submit" class="bg-green-800 text-white py-4 w-full rounded-lg transform hover:scale-105 transition-all duration-500">Submit</button>
                                        <?php }?>
                                    
                                </form>
                                
                            

                                
                                <div id="submittedContent" class="my-10 hidden ">

                                <?php
if (isset($_GET['token'])) {
    $cust_token = $_GET['token'];
    
    $stmt2 = $conn->prepare('SELECT * FROM reserve_orders WHERE cus_token = ? AND user_id = ? ORDER BY id DESC');
    $stmt2->bind_param('ss', $cust_token, $_SESSION['staff_id']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        while ($row1 = $result2->fetch_assoc()) {
            $order_id = $row1['id'];

            $stmt3 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
            $stmt3->bind_param('s', $order_id);
            $stmt3->execute();
            $result3 = $stmt3->get_result();

            // Check if there are multiple occurrences of the same order_id
            if ($result3->num_rows >= 1) {
                // Handle the case when there are multiple occurrences
                while ($row3 = $result3->fetch_assoc()) {
                    // Access the transaction details using $row3
                    $stmt4 = $conn->prepare('SELECT * FROM menus WHERE id = ?');
                    $stmt4->bind_param('s', $row3['menu_id']);
                    $stmt4->execute();
                    $result4 = $stmt4->get_result();

                    if ($result4->num_rows > 0) {
                        while ($row4 = $result4->fetch_assoc()) {

                           

                                
                            ?>




                                <div class="flex flex-col gap-y-4 mb-10 text-sm">


                                    <div class="bg-white p-4 grid grid-cols-6 gap-x-4 rounded-lg group">



                                        <div class="col-span-2 shadow-lg relative w-auto h-full rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">

                                            <img class="h-full w-auto object-cover" src="../images/<?php echo $row4['thumbnail'];?>">

                                        </div>


                               
                                        <div class="col-span-2 flex flex-col justify-between gap-y-3">

                                            <div>
                                                <p class="font-bold whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"><?php echo $row4['name'];?></p>

                                                <?php $stmt5 = $conn->prepare('SELECT * FROM menu_options WHERE id = ?');
                                                    $stmt5->bind_param('s', $row3['menu_option_id']);
                                                    $stmt5->execute();
                                                    $result5 = $stmt5->get_result();

                                                    if ($result5->num_rows > 0) {
                                                        while ($row5 = $result5->fetch_assoc()){ ?>

                                                <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Option: <span class="font-bold"><?php echo $row5['name'];?></span></p>
                                                            
                                               
                                                <p class="text-gray-500 text-xs whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500">Quantity: <span class="font-bold"><?php echo $row3['quantity'];?></span></p>
                                            </div>

                                            <?php if ($row3['completion_status'] == 'yes' && $row3['payment_status'] == 'yes'){?>
                                            <div class="bg-green-800 text-white text-xs w-20 text-center py-1 rounded-full">
                                                <p>Completed</p>
                                            </div>
                                            <?php } else if ($row3['completion_status'] == 'no' && $row3['payment_status'] == 'no'){?>
                                            <div class="bg-gray-800 text-white text-xs w-25 text-center py-1 rounded-full">
                                                <p>Not available</p>
                                            </div>
                                            <?php } else if ($row3['completion_status'] == null && $row3['payment_status'] == null){?>
                                            <div class="bg-red-800 text-white text-xs w-20 text-center py-1 rounded-full">
                                                <p>Pending</p>
                                            </div>
                                                <?php } else {?>
                                            <div class="bg-red-800 text-white text-xs w-20 text-center py-1 rounded-full">
                                                <p>Not paid</p>
                                            </div>
                                            <?php }?>
                                                                    
                                        </div>

                                        <div class="col-span-2 flex flex-col items-end justify-between">
                                            <p class="font-extrabold">PHP <?php echo number_format((double)$row5['cost'], 2);?></p>

                                        </div>

                                    </div>


                                </div>
                                <?php  
                                                        }
                                                    } 
                                  }
                            }
                            }
                                                                                                   
                                                           }                                   ?>
                                
                                <div class="bg-green-800 w-full h-1 mt-5"></div>


                                <div class="flex flex-row items-center justify-between text-lg font-extrabold my-5">

                                    <p>Total</p>



                                    <p class="tracking-widest">PHP <?php echo number_format((double)$row1['total'], 2); ?></p>

                                </div>


                                <div class="bg-green-800 w-full h-1 mt-5"></div>
                               
                                <?php 
                                                           
                                                                                           
                                                                                    }
                                                                                    }
                                                                                }
                                ?>

                            </div>
                            

                            </div>
                        </div>
                        </div>
                        <!-- Livewire Component wire-end:UaTqiYTvqIwelxM5W4cb -->
                    </div>


<script>

$(document).ready(function() {
  // Function to fetch the total cost
  function fetchTotalCost() {
    var customerToken = $('#cus_token').val();
    var staffId = $('#staff_id').val();

    $.ajax({
      url: '../php/ajax.php',
      method: 'POST',
      data: { customer_token: customerToken, staff_id: staffId },
      success: function(response) {
        var totalCostElement = $("#total_prize");
        var totalCost = parseFloat(response);

        if (isNaN(totalCost) || totalCost === null) {
          totalCost = 0;
        }
        totalCostElement.text("PHP " + totalCost.toFixed(2));

        // Set the value of the hidden input field
        $("#total_prize_input").val(totalCost);
      },
      error: function(xhr, status, error) {
        console.log('Error:', error);
      }
    });
  }

  // Fetch the total cost initially
  fetchTotalCost();

  // Periodically fetch the total cost every 5 seconds (adjust the interval as needed)
  setInterval(fetchTotalCost, 500);
});


$(document).ready(function() {  
  // Decrement button click event
$(document).on('click', '.decrement-button', function(event) {
    event.stopPropagation();
    var cusToken = $(this).siblings('#cus_token').val();
    var tempId = $(this).siblings('#temp_id').val();
    var currentQuant = $(this).siblings('#current_quant-' + tempId);
    var quantity = parseInt(currentQuant.text());

    if (quantity > 1) {
        quantity--;
        currentQuant.text(quantity);
        // Perform AJAX request to update the quantity in the database
        $.ajax({
            url: '../php/ajax.php',
            method: 'POST',
            data: {
                cusToken: cusToken,
                tempId: tempId,
                quantity: quantity
            },
            success: function(response) {
              
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                // Handle error response
            }
        });
    }
});

// Increment button click event
$(document).on('click', '.increment-button', function(event) {
    event.stopPropagation();
    var cusToken = $(this).siblings('#cus_token').val();
    var tempId = $(this).siblings('#temp_id').val();
    var currentQuant = $(this).siblings('#current_quant-' + tempId);
    var quantity = parseInt(currentQuant.text());

    quantity++;
    currentQuant.text(quantity);
    // Perform AJAX request to update the quantity in the database
    $.ajax({
        url: '../php/ajax.php',
        method: 'POST',
        data: {
            cusToken: cusToken,
            tempId: tempId,
            quantity: quantity
        },
        success: function(response) {
           
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            // Handle error response
        }
    });
});


  $(document).on('click', '.remove-button', function(event) {
  
  var tempId = $(this).attr('id').split('-')[1];
  var divId = '#myDiv-' + tempId;

  // Perform AJAX request to remove the content from the database
  $.ajax({
    url: '../php/ajax.php',
    method: 'POST',
    data: {
      tempId: tempId,
      remove: true
    },
    success: function(response) {
      // Handle success response
      $(divId).remove();  // Remove the entire div from the DOM
    },
    error: function(xhr, status, error) {
      // Handle error response
    }
  });
});

});

// Get the form and div elements by their IDs
const newContentElement = document.getElementById('newContent');
const submittedContentElement = document.getElementById('submittedContent');
const newButton = document.getElementById('newButton');
const submitButton = document.getElementById('submitButton');

// Function to switch to newContent
function switchToNewContent() {
    newContentElement.classList.remove('hidden');
    newContentElement.classList.add('visible');
    submittedContentElement.classList.remove('visible');
    submittedContentElement.classList.add('hidden');

    // Modify newButton styles
    newButton.classList.add('bg-green-800');
    newButton.classList.add('text-white');
    newButton.classList.remove('border-green-800');
    newButton.classList.remove('text-green-800');
    
    // Reset submitButton styles
    submitButton.classList.remove('bg-green-800');
    submitButton.classList.remove('text-white');
    submitButton.classList.add('border-green-800');
    submitButton.classList.add('text-green-800');
}

// Function to switch to submittedContent
function switchToSubmittedContent() {
    submittedContentElement.classList.remove('hidden');
    submittedContentElement.classList.add('visible');
    newContentElement.classList.remove('visible');
    newContentElement.classList.add('hidden');

    // Modify submitButton styles
    submitButton.classList.add('bg-green-800');
    submitButton.classList.add('text-white');
    submitButton.classList.remove('border-green-800');
    submitButton.classList.remove('text-green-800');
    
    // Modify newButton styles
    newButton.classList.remove('bg-green-800');
    newButton.classList.remove('text-white');
    newButton.classList.add('border-green-800');
    newButton.classList.add('text-green-800');
}


// Add click event listeners to the buttons
newButton.addEventListener('click', switchToNewContent);
submitButton.addEventListener('click', switchToSubmittedContent);


</script>
<?php include_once('foot.php');?>
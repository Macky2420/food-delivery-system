<?php 
session_start();
include_once('../php/connection.php');


if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];

    $stmt1 = $conn->prepare('SELECT cus_token FROM reserve_orders WHERE id = ?');
    $stmt1->bind_param('s', $order_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $cus_token = $result1->fetch_assoc()['cus_token'];

        $stmt2 = $conn->prepare('SELECT name FROM users WHERE token = ?');
        $stmt2->bind_param('s', $cus_token);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            $name = $result2->fetch_assoc()['name'];
           
$title = $name . ' - Order';
include_once('head.php');
include_once('../php/message.php');
?> <div class="h-full flex flex-row bg-white overflow-x-auto"> <?php include_once('cus_nav.php');?> <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="p-10">
            <p class="text-3xl font-bold"> <?php echo $name; ?>'s Order </p>
            <div class="flex flex-row items-center text-sm my-10">
                <a href="staff_home.php?token=
					<?php echo $_GET['token'];?>" class="font-bold hover:text-blue-800">Home </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <p> <?php echo $name; ?> </p>
            </div> <?php
        } else {
            echo "Name not found";
        }
    } else {
        echo "Customer token not found";
    }
}
?> <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons mb-10">
                <div id="allButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-900 bg-green-800 text-white hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p>All</p>
                </div> <!--
                <div id="uncompletedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-56 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    <p>Uncompleted</p>
                </div>
                <div id="completedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-56 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Completed</p>
                </div> -->
            </div>
            <div class="my-10">
                    <?php 
                    if (isset($_SESSION['order_id'])) {
                        $order_id = $_SESSION['order_id'];

                        $stmt3 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                        $stmt3->bind_param('s', $order_id);
                        $stmt3->execute();
                        $result3 = $stmt3->get_result();

                        if ($result3->num_rows > 0) {
                            $row3 = $result3->fetch_assoc();
                    ?>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="font-bold">Customer Request</p>
                            <?php if ($row3['remarks'] == null) { ?>
                                <p>No additional request available.</p>
                            <?php } else { ?>
                                <p><?php echo $row3['remarks']; ?></p>
                            <?php } ?>
                        </div>
                        
                        <div>
                            <p class="font-bold">Meal Time</p>
                            <p><?php echo $row3['meal_time']; ?></p>
                        </div>

                        <div>
                            <p class="font-bold">Order Type</p>
                            <p><?php echo $row3['order_type']; ?></p>
                        </div>

                        <div>
                            <p class="font-bold">Payment Method</p>
                            <p><?php echo $row3['payment_method']; ?></p>
                        </div>
                    </div>

                    <?php
                        }
                    }
                    ?>
                </div>

            <!-- All Orders -->
            <div id="allContent">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">


                        <div class="flex flex-col gap-y-5">

                            <p class="text-3xl font-bold">Drinks</p>

                            <?php

                                if (isset($_SESSION['order_id'])) {

                                $order_id = $_SESSION['order_id'];
                                $stmt5 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                                $stmt5->bind_param('s', $order_id);
                                $stmt5->execute();
                                $result5 = $stmt5->get_result();
                                
                                if ($result5->num_rows > 0){
                                    while ($row5 = $result5->fetch_assoc()) {
                                        $trans_id = $row5['id'];

                                    $stmt4 = $conn->prepare('SELECT * FROM menus WHERE id = ?');
                                    $stmt4->bind_param('s', $row5['menu_id']);
                                    $stmt4->execute();
                                    $result4 = $stmt4->get_result();

                                    if ($result4->num_rows > 0) {
                                        while ($row4 = $result4->fetch_assoc()) { 
                                            if ($row4['category_id'] == 2){ ?> 





                            <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">



                                <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="../images/<?php echo $row4['thumbnail'];?>">
                                <div class="col-span-2">
                                    <p class="font-bold text-lg mb-2"><?php echo $row4['name']; ?></p>

                                    <?php $stmt6 = $conn->prepare('SELECT * FROM menu_options WHERE id = ?');
                                                $stmt6->bind_param('s', $row5['menu_option_id']);
                                                $stmt6->execute();
                                                $result6 = $stmt6->get_result();

                                                if ($result6->num_rows > 0) { 
                                                    $row6 = $result6->fetch_assoc();
                                                    ?> <p class="text-gray-600 text-sm">Option: <span class="font-bold"> <?php echo $row6['name'];?> </span>
                                    </p> <?php 
                                            }   
                                            $stmt7 = $conn->prepare('SELECT * FROM transactions WHERE id = ? AND order_id = ?');
                                            $stmt7->bind_param('ss', $trans_id, $order_id);
                                            $stmt7->execute();
                                            $result7 = $stmt7->get_result();
                                            
                                            if ($result7->num_rows > 0){
                                                $row7 = $result7->fetch_assoc(); ?> <p class="text-sm">Quantity: <span class="font-bold"> <?php echo $row7['quantity']; ?> </span>
                                    </p>

                                            <?php if ($row7['completion_status'] == null) {?> <div class="text-sm mt-4">
                                            <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Uncompleted</div>
                                        </div> <?php } elseif ($row7['completion_status'] == 'no'){ ?> <div class="text-sm mt-4">
                                            <div class="text-white bg-gray-500 px-1 py-1 rounded-full text-center w-32">Not available</div>
                                        </div> <?php } else { ?> <div class="text-sm mt-4">
                                            <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Completed</div>
                                        </div> <?php } ?>

                                </div>


                                

                                <div class="col-span-2 flex flex-row items-center">
                                
                                    <form action="../php/action.php" method="post">
                                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                        <input type="hidden" name="trans_id" value="<?php echo $row7['id']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $row7['order_id']; ?>">
                                        
                                        <button name="check" class="font-bold <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'text-gray-500' : 'text-green-800 hover:text-green-600'; ?> transition-all duration-500" <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'disabled' : ''; ?> type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-40" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="../php/action.php" method="post">
                                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                        <input type="hidden" name="trans_id" value="<?php echo $row7['id']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $row7['order_id']; ?>">
                                        <button name="uncheck" class="font-bold <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'text-gray-500' : 'text-red-800 hover:text-red-700'; ?> transition-all duration-500" <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'disabled' : ''; ?> type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-40" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        
                                    </form>
                                </div>


                            </div>
                            

                                        <?php
                                        }
                                    }
                                }
                                
                            }
                                            
                                }
                            }
                            }?>




                        </div>


                        <div class="flex flex-col gap-y-5 mt-16 lg:mt-0">

                            <p class="text-3xl font-bold">Foods</p>

                            <?php

                                if (isset($_SESSION['order_id'])) {

                                $order_id = $_SESSION['order_id'];
                                $stmt5 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                                $stmt5->bind_param('s', $order_id);
                                $stmt5->execute();
                                $result5 = $stmt5->get_result();
                                
                                if ($result5->num_rows > 0){
                                    while ($row5 = $result5->fetch_assoc()) {
                                        $trans_id = $row5['id'];

                                    $stmt4 = $conn->prepare('SELECT * FROM menus WHERE id = ?');
                                    $stmt4->bind_param('s', $row5['menu_id']);
                                    $stmt4->execute();
                                    $result4 = $stmt4->get_result();

                                    if ($result4->num_rows > 0) {
                                        while ($row4 = $result4->fetch_assoc()) { 
                                            if ($row4['category_id'] == 1){ ?> 





                            <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">



                                <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="../images/<?php echo $row4['thumbnail'];?>">
                                <div class="col-span-2">
                                    <p class="font-bold text-lg mb-2"><?php echo $row4['name']; ?></p>

                                    <?php $stmt6 = $conn->prepare('SELECT * FROM menu_options WHERE id = ?');
                                                $stmt6->bind_param('s', $row5['menu_option_id']);
                                                $stmt6->execute();
                                                $result6 = $stmt6->get_result();

                                                if ($result6->num_rows > 0) { 
                                                    $row6 = $result6->fetch_assoc();
                                                    ?> <p class="text-gray-600 text-sm">Option: <span class="font-bold"> <?php echo $row6['name'];?> </span>
                                    </p> <?php 
                                            }   
                                            $stmt7 = $conn->prepare('SELECT * FROM transactions WHERE id = ? AND order_id = ?');
                                            $stmt7->bind_param('ss', $trans_id, $order_id);
                                            $stmt7->execute();
                                            $result7 = $stmt7->get_result();
                                            
                                            if ($result7->num_rows > 0){
                                                $row7 = $result7->fetch_assoc(); ?> <p class="text-sm">Quantity: <span class="font-bold"> <?php echo $row7['quantity']; ?> </span>
                                    </p>

                                            <?php if ($row7['completion_status'] == null) {?> <div class="text-sm mt-4">
                                            <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Uncompleted</div>
                                        </div> <?php } elseif ($row7['completion_status'] == 'no'){ ?> <div class="text-sm mt-4">
                                            <div class="text-white bg-gray-500 px-1 py-1 rounded-full text-center w-32">Not available</div>
                                        </div> <?php } else { ?> <div class="text-sm mt-4">
                                            <div class="text-white bg-green-800 px-1 py-1 rounded-full text-center w-32">Completed</div>
                                        </div> <?php } ?>

                                </div>


                                

                                <div class="col-span-2 flex flex-row items-center">
                                
                                    <form action="../php/action.php" method="post">
                                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                        <input type="hidden" name="trans_id" value="<?php echo $row7['id']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $row7['order_id']; ?>">
                                        
                                        <button name="check" class="font-bold <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'text-gray-500' : 'text-green-800 hover:text-green-600'; ?> transition-all duration-500" <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'disabled' : ''; ?> type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-40" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="../php/action.php" method="post">
                                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                        <input type="hidden" name="trans_id" value="<?php echo $row7['id']; ?>">
                                        <input type="hidden" name="order_id" value="<?php echo $row7['order_id']; ?>">
                                        <button name="uncheck" class="font-bold <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'text-gray-500' : 'text-red-800 hover:text-red-700'; ?> transition-all duration-500" <?php echo $row7['completion_status'] == 'yes' || $row7['completion_status'] == 'no' ? 'disabled' : ''; ?> type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-40" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        
                                    </form>
                                </div>


                            </div>
                            

                                        <?php
                                        }
                                    }
                                }
                                
                            }
                                            
                                }
                            }
                            }?>


                        </div>
                        

                    </div>


                    <div class="flex flex-row justify-end my-10">
                        <?php if (isset($_SESSION['order_id'])) {
                            $order_id = $_SESSION['order_id'];

                            $stmt3 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                                    $stmt3->bind_param('s', $order_id);
                                    $stmt3->execute();
                                    $result3 = $stmt3->get_result();

                                    if ($result3->num_rows > 0){

                                        $completionStatuses = [];
                                        $paymentStatuses = [];

                                        // Fetch the first row
                                        $row3 = $result3->fetch_assoc(); 

                                        // Add completion and payment statuses to arrays
                                        $completionStatuses[] = $row3['completion_status'];
                                        $paymentStatuses[] = $row3['payment_status'];

                                        // Fetch the remaining rows, if any
                                        while ($row4 = $result3->fetch_assoc()) {
                                            $completionStatuses[] = $row4['completion_status'];
                                            $paymentStatuses[] = $row4['payment_status'];
                                        }
                                        
                                        ?>

    
                        <form action="../php/action.php" method="post">
                            <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>"> 
                            <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
                            <?php if (in_array('yes', $completionStatuses)) { ?>
                            <button name="complete" class="border-2 border-gray-300 bg-gray-300 text-gray-500 px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transform hover:scale-105 transition-all duration-500" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <p>Mark All As Complete</p>
                            </button>
                            <?php }else{?>
                            <button name="complete" class="text-white bg-black px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transform hover:scale-105 transition-all duration-500" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <p>Mark All As Complete</p>
                            </button>
                        </form>
                                <?php }
                                    }
                                }?>
                    </div>

                </div> <!--
                <div id="uncompletedContent" class="hidden">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">
                                <div class="flex flex-col gap-y-5">
                                    <p class="text-3xl font-bold">Drinks</p>
                                    <p>No uncompleted drink orders.</p>
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="http://127.0.0.1:8000/images/1679809784.png">
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">Burger</p>
                                            <p class="text-gray-600 text-sm">Option: <span class="font-bold">Hamburger w/ Chesse</span>
                                            </p>
                                            <p class="text-sm">Quantity: <span class="font-bold">4</span>
                                            </p>
                                            <div class="text-sm mt-4">
                                                <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Uncompleted</div>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex flex-row items-center">
                                            <form action="http://127.0.0.1:8000/authorized/order/show/complete/12" method="POST">
                                                <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                                <input type="hidden" name="_method" value="put">
                                                <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="http://127.0.0.1:8000/authorized/order/show/cancel/12" method="POST">
                                                <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                                <input type="hidden" name="_method" value="delete">
                                                <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-y-5 mt-16 lg:mt-0">
                                    <p class="text-3xl font-bold">Foods</p>
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="http://127.0.0.1:8000/images/1679809784.png">
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">Burger</p>
                                            <p class="text-gray-600 text-sm">Option: <span class="font-bold">Hamburger w/ Chesse</span>
                                            </p>
                                            <p class="text-sm">Quantity: <span class="font-bold">4</span>
                                            </p>
                                            <div class="text-sm mt-4">
                                                <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Uncompleted</div>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex flex-row items-center">
                                            <form action="http://127.0.0.1:8000/authorized/order/show/complete/12" method="POST">
                                                <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                                <input type="hidden" name="_method" value="put">
                                                <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="http://127.0.0.1:8000/authorized/order/show/cancel/12" method="POST">
                                                <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                                <input type="hidden" name="_method" value="delete">
                                                <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-6 gap-x-4 hover:shadow-xl rounded-xl p-2 transform hover:scale-105 overflow-hidden transition-all duration-500">
                                        <img class="col-span-2 w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500" src="http://127.0.0.1:8000/images/1679809784.png">
                                        <div class="col-span-2">
                                            <p class="font-bold text-lg mb-2">Burger</p>
                                            <p class="text-gray-600 text-sm">Option: <span class="font-bold">Burger w/ Hotdog</span>
                                            </p>
                                            <p class="text-sm">Quantity: <span class="font-bold">1</span>
                                            </p>
                                            <div class="text-sm mt-4">
                                                <div class="text-white bg-red-800 px-1 py-1 rounded-full text-center w-32">Uncompleted</div>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex flex-row items-center">
                                            <form action="http://127.0.0.1:8000/authorized/order/show/complete/13" method="POST">
                                                <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                                <input type="hidden" name="_method" value="put">
                                                <button class="font-bold text-green-800 hover:text-green-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="http://127.0.0.1:8000/authorized/order/show/cancel/13" method="POST">
                                                <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                                <input type="hidden" name="_method" value="delete">
                                                <button class="font-bold text-red-800 hover:text-red-700 transition-all duration-500" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row justify-end my-10">
                                <form action="http://127.0.0.1:8000/authorized/order/complete/7" method="POST">
                                    <input type="hidden" name="_token" value="8ibvZdcELUfkcXhKoClbsEbP772KdHa2g3va0XDG">
                                    <input type="hidden" name="_method" value="put">
                                    <button class="text-white bg-black px-10 py-4 rounded-xl flex flex-row items-center space-x-3 transform hover:scale-105 transition-all duration-500" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                        <p>Mark All As Complete</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div id="completedContent" class="hidden">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">
                                <div class="flex flex-col gap-y-5">
                                    <p class="text-3xl font-bold">Drinks</p>
                                    <p>No completed drink orders. Let's wait.</p>
                                </div>
                                <div class="flex flex-col gap-y-5 mt-16 lg:mt-0">
                                    <p class="text-3xl font-bold">Foods</p>
                                    <p>No completed food orders. Let's wait.</p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <script src="../JS/order_index.js"></script>
                </div>
            </div> <?php include_once('foot.php');?> </body>
            </html>
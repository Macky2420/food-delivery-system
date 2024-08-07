<?php 
session_start();
$title = "Staff - Foodcourt";
include_once('../php/connection.php');
include_once('head.php');
include_once('../php/message.php');?> 
    <div class="h-full flex flex-row bg-white overflow-x-auto"> 
        <?php include_once('cus_nav.php');?> 
        <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="p-10">
            <p class="text-3xl font-bold"> Home </p>
            <div class="flex flex-row items-center text-sm my-10">
                <a href="staff_home.php?token=<?php echo $_GET['token']; ?>" class="font-bold hover:text-blue-800">Home 
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <p>Order</p>
            </div>
            <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons">
                <div id="allButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-900 bg-green-800 text-white hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p>All</p>
                </div>
                <div id="uncompletedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-72 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    <p>Uncompleted & Unpaid</p>
                </div>
                <div id="completedButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-72 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Completed & Paid</p>
                </div>
            </div>
            <div class="w-full my-10">
                <div id="allContent">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">
                        <?php 
                        $staff = $_GET['token'];
                        $stmt1 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                        $stmt1->bind_param('s', $staff);
                        $stmt1->execute();
                        $result1 = $stmt1->get_result();
                        if($result1->num_rows > 0){
                            $staff_id = $result1->fetch_assoc()['id'];

                            $stmt2 = $conn->prepare('SELECT * FROM reserve_orders WHERE user_id = ? ORDER BY id DESC');
                            $stmt2->bind_param('s', $staff_id);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            if($result2->num_rows > 0){
                                while($row1 = $result2->fetch_assoc()){

                                    $stmt3 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                                    $stmt3->bind_param('s', $row1['id']);
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
                                        
                            <div class="my-5 w-full">
                                <form action="../php/action.php" method="post">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row3['order_id']; ?>">

                                    <button type="submit" name="reserve_order" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
                                        <?php
                                        if (in_array('yes', $completionStatuses)) {
                                        ?>
                                        <div class="px-2 py-1 bg-green-800 text-white text-xs rounded-full">
                                            <p>Completed</p>
                                        </div>
                                        <?php
                                        } else if (in_array('no', $completionStatuses)) {
                                        ?>
                                        <div class="px-2 py-1 border-gray-300 bg-gray-400 text-gray-800 text-xs rounded-full">
                                            <p>Not available</p>
                                        </div>
                                        <?php
                                        } else {
                                        ?>
                                        <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                            <p>Uncompleted</p>
                                        </div>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if (count($paymentStatuses) > 0 && array_unique($paymentStatuses) === ['no']) {
                                            ?>
                                            <div class="hidden px-2 py-1 border-gray-300 bg-gray-300 text-gray-500 text-xs rounded-full">
                                                <p>Not available</p>
                                            </div>
                                            <?php
                                        } else if (in_array('yes', $paymentStatuses)) {
                                            ?>
                                            <div class="px-2 py-1 bg-green-800 text-white text-xs rounded-full">
                                                <p>Paid</p>
                                            </div>
                                            <?php
                                        } else{
                                            ?>
                                            <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                <p>Unpaid</p>
                                            </div>
                                            <?php
                                        }
                                        ?>


                                        </div>
                                        <?php  
                                        $stmt4 = $conn->prepare('SELECT name FROM users WHERE token = ?');
                                        $stmt4->bind_param('s', $row1['cus_token']);
                                        $stmt4->execute();
                                        $result4 = $stmt4->get_result();
                                        
                                        if ($result4->num_rows > 0){
                                            $name = $result4->fetch_assoc()['name'];
                                        ?>
                                        <div class="absolute flex flex-row items-center justify-center top-0 right-0 left-0 bottom-0">
                                            <p class="my-auto text-center text-4xl font-semibold filter drop-shadow-lg"><?php echo $name; ?></p>
                                        </div>
                                    
                                        <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                            <p class="font-semibold text-center tracking-widest">PHP <?php echo number_format((double)$row1['total'], 2)?></p>
                                        </div>
                                    </button>
                                </form>
                            <div class="w-full flex flex-row items-center justify-between space-x-2 mt-2">
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row1['id'];?>">
                                    <?php if (in_array('no', $completionStatuses)) { ?>
                                        <button type="submit" name="complete" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Complete</button>
                                        <?php } else if (in_array('yes', $completionStatuses)) { ?>
                                            <button type="submit" name="complete" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Complete</button>
                                        <?php } else { ?> 
                                            <button type="submit" name="complete" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Complete</button>
                                        <?php } ?>
                                    
                                </form>
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row1['id'];?>">
                                    <?php if (count($paymentStatuses) > 0 && array_unique($paymentStatuses) === ['no']) { ?>
                                        <button type="submit" name="payment" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Pay</button>
                                        <?php } else if (in_array('yes', $paymentStatuses)) { ?>
                                            <button type="submit" name="payment" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Pay</button>
                                        <?php }else{ ?>
                                            <button type="submit" name="payment" class="w-full border-2 border-green-800 text-green-800 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Pay</button>
                                        <?php }?>
                                    
                                </form>
                            </div>
                           
                        </div>   
                        <?php }
                                    }
                                    }
                                }
                            }
                            ?>
                    </div>
                        <?php $staff = $_GET['token'];
                            $stmt1 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                            $stmt1->bind_param('s', $staff);
                            $stmt1->execute();
                            $result1 = $stmt1->get_result();
                            if($result1->num_rows > 0){
                                $staff_id = $result1->fetch_assoc()['id'];

                                $stmt2 = $conn->prepare('SELECT user_id FROM reserve_orders WHERE user_id = ?');
                                $stmt2->bind_param('s', $staff_id);
                                $stmt2->execute();
                                $result2 = $stmt2->get_result();
                                if($result2->num_rows == 0){
                                    
                            ?> 
                            <div class="sm:w-1/2 mx-auto mt-20">
                                <img src="../img/not_found.svg" class="sm:w-2/3 mx-auto"> 
                                <p class="font-extrabold text-4xl text-center mt-4">No Reserve Found</p>
                                <p class="font-extrabold text-sm text-center mt-2">Just wait for the customer to add reservation.</p>
                            </div>
                            <?php
                                       
                                }
                            }
                            ?>
                </div>
                <div id="uncompletedContent" class="hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">
                        <?php 
                        $staff = $_GET['token'];
                        $stmt1 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                        $stmt1->bind_param('s', $staff);
                        $stmt1->execute();
                        $result1 = $stmt1->get_result();
                        if($result1->num_rows > 0){
                            $staff_id = $result1->fetch_assoc()['id'];

                            $stmt2 = $conn->prepare('SELECT * FROM reserve_orders WHERE user_id = ? ORDER BY id DESC');
                            $stmt2->bind_param('s', $staff_id);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            if($result2->num_rows > 0){
                                while($row1 = $result2->fetch_assoc()){

                                    $stmt3 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                                    $stmt3->bind_param('s', $row1['id']);
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

                                            if ((count($completionStatuses) > 0 && in_array(null, $completionStatuses)) || (count($paymentStatuses) > 0 && in_array(null, $paymentStatuses)))  {
                            ?>  
                            <div class="my-5 w-full">
                                <form action="staff_order.php" method="GET">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                    <button type="submit" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
                                        <?php
                                        if (in_array('yes', $completionStatuses)) {
                                        ?>
                                        <div class="px-2 py-1 bg-green-800 text-white text-xs rounded-full">
                                            <p>Completed</p>
                                        </div>
                                        <?php
                                        } else if (in_array('no', $completionStatuses)) {
                                        ?>
                                        <div class="px-2 py-1 border-gray-300 bg-gray-400 text-gray-800 text-xs rounded-full">
                                            <p>Not available</p>
                                        </div>
                                        <?php
                                        } else {
                                        ?>
                                        <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                            <p>Uncompleted</p>
                                        </div>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if (count($paymentStatuses) > 0 && array_unique($paymentStatuses) === ['no']) {
                                            ?>
                                            <div class="hidden px-2 py-1 border-gray-300 bg-gray-300 text-gray-500 text-xs rounded-full">
                                                <p>Not available</p>
                                            </div>
                                            <?php
                                        } else if (in_array('yes', $paymentStatuses)) {
                                            ?>
                                            <div class="px-2 py-1 bg-green-800 text-white text-xs rounded-full">
                                                <p>Paid</p>
                                            </div>
                                            <?php
                                        } else{
                                            ?>
                                            <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                <p>Unpaid</p>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        </div>
                                        <?php  
                                        $stmt4 = $conn->prepare('SELECT name FROM users WHERE token = ?');
                                        $stmt4->bind_param('s', $row1['cus_token']);
                                        $stmt4->execute();
                                        $result4 = $stmt4->get_result();
                                        
                                        if ($result4->num_rows > 0){
                                            $name = $result4->fetch_assoc()['name'];
                                        ?>
                                        <div class="absolute flex flex-row items-center justify-center top-0 right-0 left-0 bottom-0">
                                            <p class="my-auto text-center text-4xl font-semibold filter drop-shadow-lg"><?php echo $name; ?></p>
                                        </div>
                                    
                                        <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                            <p class="font-semibold text-center tracking-widest">PHP <?php echo number_format((double)$row1['total'], 2)?></p>
                                        </div>
                                    </button>
                                </form>
                            <div class="w-full flex flex-row items-center justify-between space-x-2 mt-2">
                            <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row1['id'];?>">
                                    <?php if (in_array('no', $completionStatuses)) { ?>
                                        <button type="submit" name="complete" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Complete</button>
                                        <?php } else if (in_array('yes', $completionStatuses)) { ?>
                                            <button type="submit" name="complete" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Complete</button>
                                        <?php } else { ?> 
                                            <button type="submit" name="complete" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Complete</button>
                                        <?php } ?>
                                    
                                </form>
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row1['id'];?>">
                                    <?php if (count($paymentStatuses) > 0 && array_unique($paymentStatuses) === ['no']) { ?>
                                        <button type="submit" name="payment" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Pay</button>
                                        <?php } else if (in_array('yes', $paymentStatuses)) { ?>
                                            <button type="submit" name="payment" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Pay</button>
                                        <?php }else{ ?>
                                            <button type="submit" name="payment" class="w-full border-2 border-green-800 text-green-800 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Pay</button>
                                        <?php }?>
                                    
                                </form>
                            </div>
                           
                        </div>   
                        <?php }
                         }
                                    }
                                }
                            }
                            ?>
                    </div>
                    <?php
                    $staff = $_GET['token'];
                    $stmt1 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                    $stmt1->bind_param('s', $staff);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();

                    if ($result1->num_rows > 0) {
                        $staff_id = $result1->fetch_assoc()['id'];

                        $stmt2 = $conn->prepare('SELECT user_id FROM reserve_orders WHERE user_id = ?');
                        $stmt2->bind_param('s', $staff_id);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();

                        if ($result2->num_rows == 0) {
                            $noReserveFound = true;
                            while ($row1 = $result2->fetch_assoc()) {

                                $stmt3 = $conn->prepare('SELECT completion_status, payment_status FROM transactions WHERE order_id = ?');
                                $stmt3->bind_param('s', $row1['id']);
                                $stmt3->execute();
                                $result3 = $stmt3->get_result();

                                if ($result3->num_rows > 0) {
                                    $row3 = $result3->fetch_assoc();

                                    if ($row3['completion_status'] == 'yes' || $row3['payment_status'] == 'yes') {
                                        $noReserveFound = false;
                                        break;
                                    }
                                }
                            }

                            if ($noReserveFound) {
                                ?>
                                <div class="mx-auto mt-5">
                                            <img src="../img/not_found.svg" class="sm:w-1/4 mx-auto"> 
                                            <p class="font-extrabold text-4xl text-center mt-4">No Uncompleted Orders or Unpaid Available</p>
                                            <p class="font-extrabold text-sm text-center mt-2">No worries, more customer will come.</p>
                                        </div>
                                <?php
                            }
                        }
                    }
                                            }
                    ?>

                </div>
                <div id="completedContent" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5">
                    <?php 
                        $staff = $_GET['token'];
                        $stmt1 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                        $stmt1->bind_param('s', $staff);
                        $stmt1->execute();
                        $result1 = $stmt1->get_result();
                        if($result1->num_rows > 0){
                            $staff_id = $result1->fetch_assoc()['id'];

                            $stmt2 = $conn->prepare('SELECT * FROM reserve_orders WHERE user_id = ? ORDER BY id DESC');
                            $stmt2->bind_param('s', $staff_id);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            if($result2->num_rows > 0){
                                while($row1 = $result2->fetch_assoc()){

                                    $stmt3 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
                                    $stmt3->bind_param('s', $row1['id']);
                                    $stmt3->execute();
                                    $result3 = $stmt3->get_result();

                                    if ($result3->num_rows > 0){

                                        $completionStatuses = [];
                                        $paymentStatuses = [];

                                        // Fetch the first row
                                        

                                        // Add completion and payment statuses to arrays
                                        $completionStatuses[] = $row3['completion_status'];
                                        $paymentStatuses[] = $row3['payment_status'];

                                        // Fetch the remaining rows, if any
                                        while ($row4 = $result3->fetch_assoc()) {
                                            $completionStatuses[] = $row4['completion_status'];
                                            $paymentStatuses[] = $row4['payment_status'];
                                        }

                                        if ((count($completionStatuses) > 0 && array_unique($completionStatuses) == ['yes']) || in_array('yes', $paymentStatuses))  {

                                            

                                            
                            ?>  
                            <div class="my-5 w-full">
                                <form action="staff_order.php" method="GET">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                    <button type="submit" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2">
                                        <?php
                                        if (in_array('yes', $completionStatuses)) {
                                        ?>
                                        <div class="px-2 py-1 bg-green-800 text-white text-xs rounded-full">
                                            <p>Completed</p>
                                        </div>
                                        <?php
                                        } else if (in_array('no', $completionStatuses)) {
                                        ?>
                                        <div class="px-2 py-1 border-gray-300 bg-gray-400 text-gray-800 text-xs rounded-full">
                                            <p>Not available</p>
                                        </div>
                                        <?php
                                        } else {
                                        ?>
                                        <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                            <p>Uncompleted</p>
                                        </div>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if (count($paymentStatuses) > 0 && array_unique($paymentStatuses) === ['no']) {
                                            ?>
                                            <div class="hidden px-2 py-1 border-gray-300 bg-gray-300 text-gray-500 text-xs rounded-full">
                                                <p>Not available</p>
                                            </div>
                                            <?php
                                        } else if (in_array('yes', $paymentStatuses)) {
                                            ?>
                                            <div class="px-2 py-1 bg-green-800 text-white text-xs rounded-full">
                                                <p>Paid</p>
                                            </div>
                                            <?php
                                        } else{
                                            ?>
                                            <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                                <p>Unpaid</p>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        </div>
                                        <?php  
                                        $stmt4 = $conn->prepare('SELECT name FROM users WHERE token = ?');
                                        $stmt4->bind_param('s', $row1['cus_token']);
                                        $stmt4->execute();
                                        $result4 = $stmt4->get_result();
                                        
                                        if ($result4->num_rows > 0){
                                            $name = $result4->fetch_assoc()['name'];
                                        ?>
                                        <div class="absolute flex flex-row items-center justify-center top-0 right-0 left-0 bottom-0">
                                            <p class="my-auto text-center text-4xl font-semibold filter drop-shadow-lg"><?php echo $name; ?></p>
                                        </div>
                                    
                                        <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                            <p class="font-semibold text-center tracking-widest">PHP <?php echo number_format((double)$row1['total'], 2);?></p>
                                        </div>
                                    </button>
                                </form>
                            <div class="w-full flex flex-row items-center justify-between space-x-2 mt-2">
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row1['id'];?>">
                                    <?php if (in_array('no', $completionStatuses)) { ?>
                                        <button type="submit" name="complete" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Complete</button>
                                        <?php } else if (in_array('yes', $completionStatuses)) { ?>
                                            <button type="submit" name="complete" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Complete</button>
                                        <?php } else { ?> 
                                            <button type="submit" name="complete" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Complete</button>
                                        <?php } ?>
                                    
                                </form>
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="staff_token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="order_id" value="<?php echo $row1['id'];?>">
                                    <?php if (count($paymentStatuses) > 0 && array_unique($paymentStatuses) === ['no']) { ?>
                                        <button type="submit" name="payment" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Pay</button>
                                        <?php } else if (in_array('yes', $paymentStatuses)) { ?>
                                            <button type="submit" name="payment" class="w-full border-2 border-gray-300 bg-gray-300 text-gray-500 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500" disabled>Pay</button>
                                        <?php }else{ ?>
                                            <button type="submit" name="payment" class="w-full border-2 border-green-800 text-green-800 px-5 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Pay</button>
                                        <?php }?>
                                    
                                </form>
                            </div>
                           
                        </div>   
                        <?php }
                         }
                                    }
                                }
                            }
                            ?>
                    </div>
                    <?php
                    $staff = $_GET['token'];
                    $stmt1 = $conn->prepare('SELECT id FROM users WHERE token = ?');
                    $stmt1->bind_param('s', $staff);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();

                    if ($result1->num_rows > 0) {
                        $staff_id = $result1->fetch_assoc()['id'];

                        $stmt2 = $conn->prepare('SELECT user_id FROM reserve_orders WHERE user_id = ?');
                        $stmt2->bind_param('s', $staff_id);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();

                        if ($result2->num_rows == 0) {
                            $noReserveFound = true;
                            while ($row1 = $result2->fetch_assoc()) {

                                $stmt3 = $conn->prepare('SELECT completion_status, payment_status FROM transactions WHERE order_id = ?');
                                $stmt3->bind_param('s', $row1['id']);
                                $stmt3->execute();
                                $result3 = $stmt3->get_result();

                                if ($result3->num_rows > 0) {
                                    $row3 = $result3->fetch_assoc();

                                    if ($row3['completion_status'] == null || $row3['payment_status'] == null) {
                                        $noReserveFound = false;
                                        break;
                                    }
                                }
                            }

                            if ($noReserveFound) {
                                ?>
                                <div class="mx-auto mt-5">
                                            <img src="../img/eating.svg" class="sm:w-1/4 mx-auto"> 
                                            <p class="font-extrabold text-4xl text-center mt-4">No Completed and Paid Orders Available</p>
                                            <p class="font-extrabold text-sm text-center mt-2">Please complete the customer order and make sure they are paid.</p>
                                        </div>
                                <?php
                            }
                        }
                    }
                                            }
                        ?>
                    </div>
                 </div>
            </div>
        </div>
        <script src="../JS/order_index.js"></script>
    </div>
</div> 

<?php include_once('foot.php');?>
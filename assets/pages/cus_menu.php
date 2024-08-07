<?php 
$title = 'Foodcourt - Menu';
session_start();
include_once('head.php');
include_once('../php/message.php');?> 
<div class="h-full flex flex-row bg-white overflow-x-auto"> 
  <?php include_once('cus_nav.php');?> 
  <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
         <div class="grid grid-cols-9">
             <div class="col-span-9 lg:col-span-6">
                 <div class="p-10">
                     <p class="text-3xl font-bold">Menu List</p>
                     <div class="flex flex-row items-center text-sm my-10">
                         <a href="cus_home.php?token=<?php echo $_GET['token'];?>" class="font-bold hover:text-blue-800">Home</a>
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                         </svg>
                            <?php 
                                  $staff_token = $_SESSION['staff'];
                                  $query = $conn->prepare('SELECT name FROM users WHERE token = ?');
                                  $query->bind_param('s', $staff_token);
                                  $query->execute();
                                  $result = $query->get_result();
                                  if($station = $result->fetch_assoc()){
                              ?>
                          <p><?php echo $station['name']; ?></p>
                                <?php }?>
                     </div>
                     <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons mb-10">
                         <div wire:click="food" id="foodsButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500 bg-green-800 text-white hover:bg-green-800 hover:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                             </svg>
                             <p>Foods</p>
                         </div>
                         <div wire:click="drink" id="drinksButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500 hover:bg-green-800 hover:text-white">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                             </svg>
                             <p>Drinks</p>
                         </div>                      


                     </div>
                     <div id="foodsContent" class="visible">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-7 mt-10">
                            <?php
                            $station_token = $_SESSION['staff'];
                            $query1 = $conn->prepare('SELECT * FROM menus WHERE users_token = ? ORDER BY id DESC');
                            $query1->bind_param('s', $station_token);
                            $query1->execute();
                            $result1 = $query1->get_result();

                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    if ($row1['disable'] == 'no') {
                                        if ($row1['category_id'] == 1) {
                                            ?>
                                            <div class="">
                                                <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                                    <img class="w-full h-auto" src="../images/<?php echo $row1['thumbnail']; ?>">
                                                </div>
                                                <div class="flex flex-row items-center justify-between font-bold mt-4 mx-2 space-x-2">
                                                <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"><?php echo $row1['name']; ?></p>
                                                <?php 
                                                    $menu_id = $row1['id'];
                                                    $query2 = $conn->prepare('SELECT * FROM menu_options WHERE menu_id = ?');
                                                    $query2->bind_param('s', $menu_id);
                                                    $query2->execute();
                                                    $result2 = $query2->get_result(); 
                                                ?>
                                                <p id="cost" class="whitespace-nowrap">
                                                <?php
                                                    $options = $result2->fetch_all(MYSQLI_ASSOC);
                                                    $costs = array_column($options, 'cost');
                                                    echo 'PHP ' . number_format((double)min($costs), 2); // display the minimum cost among all the menu options
                                                ?>
                                                </p>
                                            </div>
                                            <?php 
                                            $staff_token = $_SESSION['staff'];
                                            $stmt = $conn->prepare('SELECT id FROM users WHERE token = ?');
                                            $stmt->bind_param('s', $staff_token);
                                            $stmt->execute();
                                            $staff_result = $stmt->get_result();
                                            if($staff_id = $staff_result->fetch_assoc()){
                                                $_SESSION['staff_id'] =  $staff_id['id'];?>
                                            <form action="../php/action.php" method="post" class="mx-2 mt-2 flex flex-row items-center justify-between gap-x-3">
                                                <input type="hidden" name="staff_id" value="<?php echo  $_SESSION['staff_id'];?>">
                                                <?php } ?>
                                                <input type="hidden" name="cus_token" value="<?php echo $_GET['token'];?>">
                                                <input type="hidden" name="menu_id" value="<?php echo $menu_id;?>">
                                                <select name="menu_option_id" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-full capitalize" required>
                                                    <option value="" class="capitalize">-- Select Option --</option>
                                                    <?php
                                                    foreach ($options as $option) {
                                                    echo '<option value="' . $option['id'] . '" class="capitalize" data-cost="' . $option['cost'] . '">' . $option['name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <button class="text-white bg-green-800 py-2 px-4 rounded-full" name="add_to_cart" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </form>

                                          </div>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                         <?php
                            $station_token = $_SESSION['staff'];
                            $query3 = $conn->prepare('SELECT * FROM menus WHERE category_id = 1 AND users_token = ?');
                            $query3->bind_param('s', $station_token);
                            $query3->execute();
                            $result3 = $query3->get_result();

                            if ($result3->num_rows == 0) {
                                ?>
                                <div class="sm:w-1/2 mx-auto -mt-14">
                                    <img src="../img/no_food.svg" class="sm:w-2/3 mx-auto">
                                    <p class="font-extrabold text-4xl text-center mt-4">No Food Found</p>
                                    <p class="font-extrabold text-sm text-center mt-2">We apologize for the inconvenience. Our kitchen staff is currently busy cooking. Please check back later for our delicious menus!</p>'
                                </div>
                                    <?php
                                }
                                ?>

                        
                    </div>

                     <div id="drinksContent" class="hidden">
                     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-7 mt-10">
                            <?php
                            $station_token = $_SESSION['staff'];
                            $query1 = $conn->prepare('SELECT * FROM menus WHERE users_token = ? ORDER BY id DESC');
                            $query1->bind_param('s', $station_token);
                            $query1->execute();
                            $result1 = $query1->get_result();

                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    if ($row1['disable'] == 'no') {
                                        if ($row1['category_id'] == 2) {
                            ?>
                                            <div class="">
                                                <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                                    <img class="w-full h-auto" src="../images/<?php echo $row1['thumbnail']; ?>">
                                                </div>
                                                <div class="flex flex-row items-center justify-between font-bold mt-4 mx-2 space-x-2">
                                                <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"><?php echo $row1['name']; ?></p>
                                                <?php 
                                                    $menu_id = $row1['id'];
                                                    $query2 = $conn->prepare('SELECT * FROM menu_options WHERE menu_id = ?');
                                                    $query2->bind_param('s', $menu_id);
                                                    $query2->execute();
                                                    $result2 = $query2->get_result(); 
                                                ?>
                                                <p id="cost" class="whitespace-nowrap">
                                                <?php
                                                    $options = $result2->fetch_all(MYSQLI_ASSOC);
                                                    $costs = array_column($options, 'cost');
                                                    echo 'PHP ' . number_format((double)min($costs), 2); // display the minimum cost among all the menu options
                                                ?>
                                                </p>
                                            </div>
                                            <?php 
                                            $staff_token = $_SESSION['staff'];
                                            $stmt = $conn->prepare('SELECT id FROM users WHERE token = ?');
                                            $stmt->bind_param('s', $staff_token);
                                            $stmt->execute();
                                            $staff_result = $stmt->get_result();
                                            if($staff_id = $staff_result->fetch_assoc()){
                                                $_SESSION['staff_id'] =  $staff_id['id'];?>
                                            <form action="../php/action.php" method="post" class="mx-2 mt-2 flex flex-row items-center justify-between gap-x-3">
                                                <input type="hidden" name="staff_id" value="<?php echo  $_SESSION['staff_id'];?>">
                                                <?php } ?>
                                                <input type="hidden" name="cus_token" value="<?php echo $_GET['token'];?>">
                                                <input type="hidden" name="menu_id" value="<?php echo $menu_id;?>">
                                                <select name="menu_option_id" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-full capitalize" required>
                                                    <option value="" class="capitalize">-- Select Option --</option>
                                                    <?php
                                                    foreach ($options as $option) {
                                                    echo '<option value="' . $option['id'] . '" class="capitalize" data-cost="' . $option['cost'] . '">' . $option['name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <button class="text-white bg-green-800 py-2 px-4 rounded-full" name="add_to_cart" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </form>

                                          </div>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                         <?php
                            $station_token = $_SESSION['staff'];
                            $query3 = $conn->prepare('SELECT * FROM menus WHERE category_id = 2 AND users_token = ?');
                            $query3->bind_param('s', $station_token);
                            $query3->execute();
                            $result3 = $query3->get_result();

                            if ($result3->num_rows == 0) {
                                ?>
                                <div class="sm:w-1/2 mx-auto -mt-14">
                                    <img src="../img/no_drink.svg" class="sm:w-2/3 mx-auto">
                                    <p class="font-extrabold text-4xl text-center mt-4">No Drink Found</p>
                                    <p class="font-extrabold text-sm text-center mt-2">We apologize for the inconvenience. Our kitchen staff is currently busy preparing the drinks. Please check back later for our delicious menus!</p>'
                                </div>
                                    <?php
                                }
                                ?>

                     </div>
                 </div>
                 <!-- Livewire Component wire-end:OYFnGmuzHb88valxtDwD -->
             </div> 
             <?php include_once('cus_pay.php');?>
         </div>
     </div>
 </div> 
 <script>
      // Get references to all the select elements and cost display paragraphs
      const selects = document.querySelectorAll('select');
      const costParagraphs = document.querySelectorAll('#cost');

      // Loop through all the select elements and add event listeners to each one
      selects.forEach((select, index) => {
        // Add change event listener to the select element
        select.addEventListener('change', () => {
          // Get the selected option element
          const selectedOption = select.options[select.selectedIndex];

          // Get the name and cost of the selected option
          const name = selectedOption.text;
          const cost = parseFloat(selectedOption.dataset.cost);

          // Update the text content of the corresponding cost display paragraph to show the name and cost of the selected option,
          // or the default cost if no option is selected or the cost is NaN
          if (selectedOption && !isNaN(cost)) {
            costParagraphs[index].textContent = `PHP ${cost.toFixed(2)}`;
          } 
        });

        // Trigger the change event once to initialize the cost display paragraph
        select.dispatchEvent(new Event('change'));
      });

            // Foods
            const foodsButton = document.querySelector('#foodsButton');
            const foodsContent = document.querySelector('#foodsContent');
            // Drinks
            const drinksButton = document.querySelector('#drinksButton');
            const drinksContent = document.querySelector('#drinksContent');
            // Foods
            foodsButton.addEventListener('click', () => {
                if (foodsContent.classList.contains('visible')) {
                    foodsContent.classList.remove('hidden');
                    drinksContent.classList.add('hidden');
                    foodsButton.classList.add('bg-green-800');
                    foodsButton.classList.add('text-white');
                    foodsButton.classList.remove('text-green-800');
                    drinksButton.classList.remove('bg-green-800');
                    drinksButton.classList.remove('text-white');
                    drinksButton.classList.add('text-green-800');
                }
            })
            // Drinks
            drinksButton.addEventListener('click', () => {
                if (drinksContent.classList.contains('hidden')) {
                    foodsContent.classList.add('hidden');
                    drinksContent.classList.remove('hidden');
                    foodsButton.classList.remove('bg-green-800');
                    foodsButton.classList.remove('text-white');
                    foodsButton.classList.add('text-green-800');
                    drinksButton.classList.add('bg-green-800');
                    drinksButton.classList.add('text-white');
                    drinksButton.classList.remove('text-green-800');
                }
            })



  </script>
 <?php include_once('foot.php');?>
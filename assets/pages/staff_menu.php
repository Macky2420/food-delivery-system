<?php
session_start();
$title = "Menu - Delivery";
include_once('../php/connection.php');
include_once('head.php');
include_once('../php/message.php');?> <div class="h-full flex flex-row bg-white overflow-x-auto"> <?php include_once('cus_nav.php')?> <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="p-10">
            <p class="text-3xl font-bold"> Menu </p>
            <div class="flex flex-row items-center text-sm my-10">
                <a href="staff_home.php?token=
					<?php echo $_GET['token']; ?>" class="font-bold hover:text-blue-800">Home </a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <p>Menu</p>
            </div>
            <div class="space-x-3 flex flex-row text-center overflow-auto whitespace-nowrap filterButtons">
                <div id="foodsButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-900 bg-green-800 text-white hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                    </svg>
                    <p>Foods</p>
                </div>
                <div id="drinksButton" class="flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-32 rounded-full cursor-pointer transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    <p>Drinks</p>
                </div>
            </div>
            <a href="staff_create.php?token=
				
				
				<?php echo $token; ?>">
                <div class="my-10 flex flex-row items-center justify-center space-x-4 border-2 border-green-800 hover:bg-green-800 text-green-800 hover:text-white font-semibold p-2 w-40 rounded-md cursor-pointer transform hover:scale-105 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                    </svg>
                    <p>Add New</p>
                </div>
            </a>
            <div class="w-full my-10">
                <div id="foodsContent" class="visible">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5"> <?php 
                                                    $token = $_GET['token'];
                                                    $query = $conn->prepare("SELECT * FROM menus WHERE users_token = ? ORDER BY id DESC");
                                                    $query->bind_param('s', $token);
                                                    $query->execute();
                                                    $result = $query->get_result();
                                                    
                                                    if($result->num_rows > 0){

                                                            while($rows = $result->fetch_assoc()){
                                                               
                                                                if($rows['category_id'] == 1){
                                                            
                                                ?> <div class="my-5 w-full group">
                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                <img class="w-full h-auto" src="../images/
									
									<?php echo $rows['thumbnail'];?>">
                                <div class="absolute right-1 top-1 flex flex-row space-x-2"> <?php if($rows['disable'] == 'yes'){ ?> <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                        <p>Disabled</p>
                                    </div> <?php }?> </div>
                            </div>
                            <div class="flex flex-row items-center justify-between font-bold my-4 mx-2 space-x-2">
                                <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"> <?php echo $rows['name'];?> </p> <?php 
                                                                $menu_id = $rows['id'];
                                                                $query1 = $conn->prepare('SELECT name, cost FROM menu_options WHERE menu_id = ?');
                                                                $query1->bind_param('s', $menu_id);
                                                                $query1->execute();
                                                                $result1 = $query1->get_result();
                                                                if($result1->num_rows > 0){
                                                                    $rows1 = $result1->fetch_assoc();
                                                            ?> <p class="whitespace-nowrap">PHP <?php echo number_format((double)$rows1['cost'], 2)?> </p> <?php       
                                                                    
                                                                }  
                                                            ?>
                            </div>
                            <div class="w-full flex flex-row items-center justify-between gap-x-1.5 mt-2">
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="menu_id" value="<?php echo $menu_id?>">
                                    <button type="submit" name="edit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Edit</button>
                                </form>
                                <form action="../php/action.php" method="post" class="w-1/4">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="menu_id" value="<?php echo $menu_id?>">
                                    <button type="submit" name="disable" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 
															<?php echo $rows['disable'] == 'yes' ? 'border-green-800 bg-green-800' : 'border-red-700 bg-red-700'; ?> text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                        <input type="hidden" name="disabled" value="<?php echo $rows['disable'] == 'no' ? 'yes' : 'no'; ?>"> <?php if($rows['disable'] == 'yes'){?> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg> <?php }else{?> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg> <?php }?> </button>
                                </form>
                                <button onclick="delete1(<?php echo $rows['id']; ?>, '<?php echo $_GET['token']; ?>')" class="w-1/4 flex flex-row items-center justify-center font-bold p-2 border-2 border-black bg-black text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <div id="modal1" class="hidden fixed z-10 inset-0 w-full h-full overflow-auto pt-20" style="background: rgba(0,0,0,0.5);">
                                    <div id="modalBox1" class="bg-white w-3/4 lg:w-1/3 mx-auto p-10 rounded-lg text-center animate__animated animate__bounceInDown shadow-2xl">
                                        <p class="text-3xl font-bold">Confirm Deletion</p>
                                        <p class="my-10">Are you sure you want to delete this menu item?</p>
                                        <div class="flex flex-row items-center justify-center gap-5">
                                            <form action="../php/action.php" method="post">
                                                <input type="hidden" name="token" id="menuToken" value="">
                                                <input type="hidden" name="menu_id" id="menuIdInput" value="">
                                                <button type="submit" name="delete" class="bg-green-800 text-white px-10 py-3 rounded-md">Yes</button>
                                            </form>
                                            <div href="staff_menu.php?token=<?php echo $_GET['token'];?>" onclick="cancel1()" class="bg-red-800 text-white px-10 py-3 rounded-md cursor-pointer">Cancel </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <?php
                                                            }
                                                        }
                                                    }  
                                                   
                                                    $station_token = $_GET['token'];
                                                    $query3 = $conn->prepare('SELECT * FROM menus WHERE category_id = 1 AND users_token = ?');
                                                    $query3->bind_param('s', $station_token);
                                                    $query3->execute();
                                                    $result3 = $query3->get_result();
                                                    if($result3->num_rows == 0){
                                                    ?> </div>
                    <div class="sm:w-1/2 mx-auto -mt-14">
                        <img src="../img/no_food.svg" class="sm:w-2/3 mx-auto">
                        <p class="font-extrabold text-4xl text-center mt-4">No Food Found</p>
                        <p class="font-extrabold text-sm text-center mt-2">If you are an Kitchen Staff, please add a new Food Item.</p>
                    </div> <?php
                                                }
                            ?>
                </div>
            </div>
            <div class="w-full my-10">
                <div id="drinksContent" class="hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-x-5"> <?php                    
                                                    $token = $_GET['token'];
                                                    $query = $conn->prepare("SELECT * FROM menus WHERE users_token = ? ORDER BY id DESC");
                                                    $query->bind_param('s', $token);
                                                    $query->execute();
                                                    $result = $query->get_result();
                                                    
                                                    if($result->num_rows > 0){

                                                            while($rows = $result->fetch_assoc()){
                                                               
                                                                if($rows['category_id'] == 2){
                                                            
                                                ?> <div class="my-5 w-full group">
                            <div class="shadow-lg relative w-full h-auto rounded-lg transform hover:scale-105 overflow-hidden transition-all duration-500">
                                <img class="w-full h-auto" src="../images/
																		<?php echo $rows['thumbnail'];?>">
                                <div class="absolute right-1 top-1 flex flex-row space-x-2"> <?php if($rows['disable'] == 'yes'){ ?> <div class="px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                        <p>Disabled</p>
                                    </div> <?php }?> </div>
                            </div>
                            <div class="flex flex-row items-center justify-between font-bold my-4 mx-2 space-x-2">
                                <p class="whitespace-nowrap group-hover:overflow-visible overflow-hidden overflow-ellipsis transition-all duration-500"> <?php echo $rows['name'];?> </p> <?php 
                                                                $menu_id = $rows['id'];
                                                                $query1 = $conn->prepare('SELECT name, cost FROM menu_options WHERE menu_id = ?');
                                                                $query1->bind_param('s', $menu_id);
                                                                $query1->execute();
                                                                $result1 = $query1->get_result();
                                                                if($result1->num_rows > 0){
                                                                    $rows1 = $result1->fetch_assoc();
                                                            ?> <p class="whitespace-nowrap">PHP <?php echo number_format((double)$rows1['cost'], 2)?> </p> <?php       
                                                                    
                                                                }  
                                                            ?>
                            </div>
                            <div class="w-full flex flex-row items-center justify-between gap-x-1.5 mt-2">
                                <form action="../php/action.php" method="post" class="w-1/2">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="menu_id" value="<?php echo $menu_id?>">
                                    <button type="submit" name="edit" class="w-full border-2 border-green-800 bg-green-800 text-white px-4 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">Edit</button>
                                </form>
                                <form action="../php/action.php" method="post" class="w-1/4">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="menu_id" value="<?php echo $menu_id?>">
                                    <button type="submit" name="disable" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 <?php echo $rows['disable'] == 'yes' ? 'border-green-800 bg-green-800' : 'border-red-700 bg-red-700'; ?> text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                        <input type="hidden" name="disabled" value="<?php echo $rows['disable'] == 'no' ? 'yes' : 'no'; ?>"> <?php if($rows['disable'] == 'yes'){?> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg> <?php }else{?> <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg> <?php }?> </button>
                                </form>
                                <form action="../php/action.php" method="post">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                                    <input type="hidden" name="menu_id" value="<?php echo $rows['id']; ?>">
                                    <button type="submit" name="delete" class="w-full flex flex-row items-center justify-center font-bold p-2 border-2 border-black bg-black text-white px-2 py-1 text-center rounded-full transform hover:scale-105 transition-all duration-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div> <?php
                                                            }
                                                        }
                                                }
                                                
                                                $station_token = $_GET['token'];
                                                $query3 = $conn->prepare('SELECT * FROM menus WHERE category_id = 2 AND users_token = ?');
                                                $query3->bind_param('s', $station_token);
                                                $query3->execute();
                                                $result3 = $query3->get_result();
                                                if($result3->num_rows == 0){
                                                
                                                    
                                    ?> </div>
                    <div class="sm:w-1/2 mx-auto -mt-14">
                        <img src="../img/no_drink.svg" class="sm:w-2/3 mx-auto">
                        <p class="font-extrabold text-4xl text-center mt-4">No Drink Found</p>
                        <p class="font-extrabold text-sm text-center mt-2">If you are an Kitchen Staff, please add a new Drink Item.</p> <?php
                                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
        // Delete Button
        function delete1(menuId, token) {
            const modal1 = document.querySelector('#modal1');
            const modalBox1 = document.querySelector('#modalBox1');
            const menuIdInput = document.querySelector('#menuIdInput');
            const menuTokenInput = document.querySelector('#menuToken');
            if (modal1.classList.contains('hidden')) {
                modal1.classList.remove('hidden');
            }
            if (modalBox1.classList.contains('animate__bounceOutUp')) {
                modalBox1.classList.remove('animate__bounceOutUp');
                modalBox1.classList.add('animate__bounceInDown');
            }
            menuTokenInput.value = token;
            menuIdInput.value = menuId;
        }
        // Cancel Button
        function cancel1() {
            const modal1 = document.querySelector('#modal1');
            const modalBox1 = document.querySelector('#modalBox1');
            if (modalBox1.classList.contains('animate__bounceInDown')) {
                modalBox1.classList.remove('animate__bounceInDown');
                modalBox1.classList.add('animate__bounceOutUp');
            }
            setTimeout(function() {
                modal1.classList.add('hidden');
            }, 800);
        }
        const modal1 = document.querySelector('#modal1');
        const modalBox1 = document.querySelector('#modalBox1');
        window.addEventListener("click", function(event) {
            if (event.target == modal1) {
                if (modalBox1.classList.contains('animate__bounceInDown')) {
                    modalBox1.classList.remove('animate__bounceInDown');
                    modalBox1.classList.add('animate__bounceOutUp');
                }
                setTimeout(function() {
                    modal1.classList.add('hidden');
                }, 800);
            }
        });
    </script> <?php include_once('foot.php');?>
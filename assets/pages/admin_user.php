<?php 
session_start();
$title = "Users Admin - Foodcourt";
include_once('../php/connection.php');
include_once('head.php');
require_once('../php/message.php');?> 
<div class="h-full flex flex-row bg-white overflow-x-auto"> 
    <?php include_once('cus_nav.php')?> 
    <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="p-5">
            <p class="text-3xl font-bold">All Users</p>
            <div class="flex flex-row items-center text-sm my-10">
                <a href="admin_home.php?token=<?php echo $_GET['token'];?>" class="font-bold hover:text-blue-800">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <p>All Users</p>
            </div>
            <div class="flex flex-row justify-end relative">
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?token=' . urlencode($_GET['token']); ?>" method="post" class="flex hover:scale-105 transition-all duration-500">
                <input type="text" name="search_query" placeholder="Search for Users Name" class="px-10 py-2 rounded-l-lg border-2 border-green-800 focus:outline-none focus:border-green-800">
                <button type="submit" name="search" class="h-full px-4 py-2 bg-green-800 text-white rounded-r-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 22L15.5 15.5M4 11a7 7 0 1014 0a7 7 0 00-14 0z" />
                    </svg>
                </button>
            </form>

        </div>
            <div class="flex flex-row items-center lg:hidden animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <p>Please scroll left to see the whole table</p>
            </div>
            <div class="w-full xl:w-3/2 mt-10 grid max-w-max">
                <div class="w-full max-w-max mx-auto grid grid-flow-row overflow-x-auto">
                    

                        <div class="flex flex-col gap-y-2">

                            <div class="grid grid-cols-7 font-bold text-lg mb-1 px-4 py-4">
                                <p class="col-span-1">Name</p>
                                <p class="col-span-2">Email Address</p>
                                <p class="col-span-1">Role</p>
                                <p class="col-span-1">Verified</p>
                                <p class="col-span-1">Action</p>
                            </div>

                            <div class="flex flex-col gap-y-2">
                                <?php 

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $sql = $conn->prepare("SELECT * FROM users WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%'");
    $sql->execute();
    $result1 = $sql->get_result();

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) { ?>

            <div class="grid grid-cols-7 items-center min-w-max gap-x-1 border-3 border-green-800 rounded-md px-4 py-4 font-bold">
                <p class="col-span-1"><?php echo $row['name']; ?></p>
                <p class="col-span-2"><?php echo $row['email']; ?></p>
                <p class="col-span-1 capitalize"><?php echo ($row['role_id'] == 2) ? 'staff' : 'customer'; ?></p>
                <p class="col-span-1 capitalize"><?php echo ($row['verified'] == 1) ? 'yes' : 'no'; ?></p>
                <div class="col-span-2 flex flex-row gap-x-2">
                    <form action="../php/action.php" method="post">
                        <input type="hidden" name="adminToken" value="<?php echo $_GET['token']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="admin_edit" class="border-3 border-green-800 hover:border-green-600 bg-green-800 hover:bg-green-600 text-white px-8 py-1 rounded-lg font-bold transform hover:scale-105 transition-all duration-500">Edit</button>
                    </form>
                    <button onclick="delete1(<?php echo $row['id']; ?>, '<?php echo $_GET['token']; ?>')" class="border-3 border-black bg-black text-white px-8 py-1 rounded-lg font-bold transform hover:scale-105 transition-all duration-500">Delete</button>
                </div>
            </div>

    <?php
        }
       
    } else { ?>
        <div class="sm:w-1/2 mx-auto mt-20">
                                <img src="../img/working.svg" class="sm:w-2/3 mx-auto"> 
                                <p class="font-extrabold text-4xl text-center mt-4">No User Found</p>
                                <p class="font-extrabold text-sm text-center mt-2">Just wait a lot of users will coming soon.</p>
                            </div>
       
 <?php   }
}else{

                                
                                ?>
                                <?php
                                $query = $conn->prepare('SELECT * FROM users WHERE role_id = 2 OR role_id = 3 ORDER BY id DESC');
                                $query->execute();
                                $result = $query->get_result();
                                ?>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <div class="grid grid-cols-7 items-center min-w-max gap-x-1 border-3 border-green-800 rounded-md px-4 py-4 font-bold">
                                        <p class="col-span-1"><?php echo $row['name']; ?></p>
                                        <p class="col-span-2"><?php echo $row['email']; ?></p>
                                        <p class="col-span-1 capitalize"><?php echo ($row['role_id'] == 2) ? 'staff' : 'customer'; ?></p>
                                        <p class="col-span-1 capitalize"><?php echo ($row['verified'] == 1) ? 'yes' : 'no'; ?></p>
                                        <div class="col-span-2 flex flex-row gap-x-2">
                                            <form action="../php/action.php" method="post">
                                                <input type="hidden" name="adminToken" value="<?php echo $_GET['token']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="admin_edit"class="border-3 border-green-800 hover:border-green-600 bg-green-800 hover:bg-green-600 text-white px-8 py-1 rounded-lg font-bold transform hover:scale-105 transition-all duration-500">Edit</button>
                                            </form>
                                            <button onclick="delete1(<?php echo $row['id']; ?>, '<?php echo $_GET['token']; ?>')" class="border-3 border-black bg-black text-white px-8 py-1 rounded-lg font-bold transform hover:scale-105 transition-all duration-500">Delete</button>
                                        </div>
                                    </div>
                                <?php }
                                } ?>
                            </div>
                        </div>
                        <div id="modal1" class="hidden fixed z-10 inset-0 w-full h-full overflow-auto pt-20" style="background: rgba(0,0,0,0.5);">
                            <div id="modalBox1" class="bg-white w-3/4 lg:w-1/3 mx-auto p-10 rounded-lg text-center animate__animated animate__bounceInDown shadow-2xl">
                                <p class="text-3xl font-bold">Confirm Deletion</p>
                                <p class="my-10">Are you sure you want to delete this user account?</p>
                                <div class="flex flex-row items-center justify-center gap-5">
                                    <form action="../php/action.php" method="post">
                                        <input type="hidden" name="userToken" id="userToken" value="">
                                        <input type="hidden" name="userId" id="userId" value="">
                                        <button type="submit" name="user_delete" class="bg-green-800 text-white px-10 py-3 rounded-md">Yes</button>
                                    </form>
                                    <div onclick="cancel1()" class="bg-red-800 text-white px-10 py-3 rounded-md cursor-pointer">Cancel</div>
                                </div>
                            </div>
                        </div>
                        <script>
                            // Delete Button
                            function delete1(userId, token) {
                                const modal1 = document.querySelector('#modal1');
                                const modalBox1 = document.querySelector('#modalBox1');
                                const userIdInput = document.querySelector('#userId');
                                const userTokenInput = document.querySelector('#userToken');
                                if (modal1.classList.contains('hidden')) {
                                    modal1.classList.remove('hidden');
                                }
                                if (modalBox1.classList.contains('animate__bounceOutUp')) {
                                    modalBox1.classList.remove('animate__bounceOutUp');
                                    modalBox1.classList.add('animate__bounceInDown');
                                }
                                userTokenInput.value = token;
                                userIdInput.value = userId;
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
                        </script>
                        
                        <script>
                            // Delete Button
                            function delete2() {
                                const modal2 = document.querySelector('#modal2');
                                const modalBox2 = document.querySelector('#modalBox2');
                                if (modal2.classList.contains('hidden')) {
                                    modal2.classList.remove('hidden');
                                }
                                if (modalBox2.classList.contains('animate__bounceOutUp')) {
                                    modalBox2.classList.remove('animate__bounceOutUp');
                                    modalBox2.classList.add('animate__bounceInDown');
                                }
                            }
                            // Cancel Button
                            function cancel2() {
                                const modal2 = document.querySelector('#modal2');
                                const modalBox2 = document.querySelector('#modalBox2');
                                if (modalBox2.classList.contains('animate__bounceInDown')) {
                                    modalBox2.classList.remove('animate__bounceInDown');
                                    modalBox2.classList.add('animate__bounceOutUp');
                                }
                                setTimeout(function() {
                                    modal2.classList.add('hidden');
                                }, 800);
                            }
                            const modal2 = document.querySelector('#modal2');
                            const modalBox2 = document.querySelector('#modalBox2');
                            window.addEventListener("click", function(event) {
                                if (event.target == modal2) {
                                    if (modalBox2.classList.contains('animate__bounceInDown')) {
                                        modalBox2.classList.remove('animate__bounceInDown');
                                        modalBox2.classList.add('animate__bounceOutUp');
                                    }
                                    setTimeout(function() {
                                        modal2.classList.add('hidden');
                                    }, 800);
                                }
                            });
                        </script>
                        
                    </div>
                </div>
                <div class="w-full my-3 text-green-800"></div>
            </div>
        </div>
    </div>
</div> <?php include_once('foot.php');?>
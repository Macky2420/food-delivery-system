<?php 
session_start();
include_once('../php/connection.php');
$title = 'Edit - Foodcourt';
$token = $_GET['token'];
include_once('head.php');?> 
<div class="h-full flex flex-row bg-white overflow-x-auto"> 
    <?php include_once('cus_nav.php');?> 
    <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="p-10">
            <p class="text-3xl font-bold">Add New Menu Item</p>
            <div class="flex flex-row items-center text-sm my-10">
                <a href="staff_home.php?token=<?php echo $token; ?>" class="font-bold hover:text-blue-800">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="staff_menu.php?token=
					<?php echo $token; ?>" class="font-bold hover:text-blue-800">Menu</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <p>Add New Menu Item</p>
            </div>
            <p class="text-gray-500 mb-10">Fill in the form below to add new menu item</p>
            <form action="../php/action.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="menusId" value="<?php echo $_SESSION['menus_id'];?>">
                <input type="hidden" name="token" value="<?php echo $_GET['token'];?>">
                <div class="lg:w-1/2 grid grid-cols-2 gap-x-5 gap-y-8 mb-20">
                    <div class="col-span-2">
                        <p class="font-bold">Menu Category</p>
                        <div class="flex flex-row items-center space-x-3 mt-3">
                            <?php
                            $stmt = $conn->prepare('SELECT id, name FROM category');
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $categories = $result->fetch_all(MYSQLI_ASSOC);
                            ?>
                            <?php foreach ($categories as $category) { ?>
                                <div class="icheck-material-teal capitalize" id="category-<?php echo $category['id']; ?>">
                                    <input type="radio" id="<?php echo $category['id']; ?>" name="category" value="<?php echo $category['id']; ?>" required />
                                    <label for="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                                </div>
                            <?php } ?>
                        </div>


                    </div>
                    <div class="col-span-1">
                        <p class="font-bold">Name</p>
                        <input type="text" name="name" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" value="<?php echo $_SESSION['menu_name'];?>" required>
                    </div>
                    <div class="col-span-1">
                        <p class="font-bold">Image</p>
                        <label class="w-full mt-3 flex flex-row items-center border-3 border-green-800 rounded-lg p-0.5">
                            <div class="bg-green-800 text-white px-4 py-1.5 rounded-lg">
                                <p>Choose File</p>
                            </div>
                            <p id="fileName" class="ml-4 w-20"><?php echo $_SESSION['thumbnail'];?></p>
                            <input id="upload-input" name="image" value="<?php echo $_SESSION['thumbnail'];?>" class="hidden" placeholder="Select a file" type="file" accept="image/*" onchange="getFileName()">
                        </label>
                        <script>
                            function getFileName() {
                                var x = document.getElementById('upload-input')
                                x.style.visibility = 'collapse'
                                document.getElementById('fileName').innerHTML = x.value.split('\\').pop()
                            }
                        </script>
                    </div>
                    <div class="col-span-2 w-full" id="dynamicAddRemove">
                        <p class="font-bold mb-3">Option Details</p>
                        <div class="flex flex-row items-end space-x-4 mb-3 w-full">
                            <div class="w-full">
                                <p class="text-sm font-bold">Option Name</p>
                                <input type="text" name="optionName[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" value="<?php echo $_SESSION['option_name'];?>" required>
                            </div>
                            <div class="w-full">
                                <p class="text-sm font-bold">Price (PHP)</p>
                                <input type="number" min="1" step="any" name="optionPrice[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" value="<?php echo $_SESSION['option_cost'];?>" required>
                            </div>
                            <button type="button" name="add" id="dynamic-ar">
                                <div class="bg-green-800 hover:bg-green-700 text-white text-center rounded-lg px-5 py-2.5 w-20 flex flex-row items-center justify-center transition-all duration-500 transform hover:scale-105">
                                    <p>Add</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    <button type="submit" name="edit_create" class="border-3 hover:border-green-700 border-green-800 hover:bg-green-700 bg-green-800 text-white py-4 rounded-lg font-bold transition-all duration-500 transform hover:scale-105">
                        <p>Confirm Edit</p>
                    </button>
                    <a href="staff_menu.php?token=<?php echo $token; ?>" class="border-3 hover:border-red-700 border-red-800 hover:bg-red-700 bg-red-800 text-white py-4 rounded-lg text-center font-bold transition-all duration-500 transform hover:scale-105"> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div> 
<script type="text/javascript">
        var i = 0;
        $("#dynamic-ar").click(function () {
            ++i;
            $("#dynamicAddRemove").append('<div class="flex flex-row items-end space-x-4 mb-3 w-full dynamicField"><div class="w-full"><input type="text" name="optionName[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required></div><div class="w-full"><input type="number" min="1" step="any" name="optionPrice[]" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required></div><button type="button" class="remove-input-field"><div class="bg-red-800 hover:bg-red-700 text-white text-center rounded-lg px-5 py-2.5 w-20 flex flex-row items-center justify-center transition-all duration-500 transform hover:scale-105"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></div></button></div>'
            );
        });
        $(document).on('click', '.remove-input-field', function () {
            $(this).parents('.dynamicField').remove();
        });
    </script>
<?php include_once('foot.php');?>
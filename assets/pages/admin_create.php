<?php 
$title = 'Create Admin - Foodcourt';
include_once('head.php');?>

<div class="h-full flex flex-row bg-white overflow-x-auto">
  <?php include_once('cus_nav.php');?>

  <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">


            <div class="p-10">


                    <p class="text-3xl font-bold">Add New User Account</p>


                          <div class="flex flex-row items-center text-sm my-10">
                              <a href="admin_home.php?token=<?php echo $_GET['token'];?>" class="font-bold hover:text-blue-800">Home</a>
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                              <a href="admin_user.php?token=<?php echo $_GET['token'];?>" class="font-bold hover:text-blue-800">All Users</a>
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                              <p>Add New User Account</p>
                          </div>


                          <p class="text-gray-500 mb-10">Fill in the form below to add new user account</p>

                          <form action="../php/action.php" method="post">

                              <input type="hidden" name="_token" value="PfWNHlL2FlAy62WENXwAoE9vntwr1T9sHIwSp1EW">

                              <div class="lg:w-1/2 grid grid-cols-2 gap-x-5 gap-y-8 mb-20">


                                  <div class="col-span-2 grid grid-cols-2 gap-x-5">

                                      <p class="col-span-2 font-bold">User Role</p>

                                      <div class="col-span-1 mt-3">

                                          <select name="role" id="role" class="w-full p-1 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg capitalize" required>
                                      
                                      <option disabled selected value class="bg-gray-200">-- Select one role --</option>

                                                                      <option value="2" class="capitalize">staff</option>
                                                                      <option value="3" class="capitalize">customer</option>
                                      
                                  </select>

                                      </div>

                                  </div>


                                  <div class="col-span-1">
                                      <p class="font-bold">User Name</p>

                                      <input type="text" name="firstName" value="" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>

                                  </div>


                                  <div class="col-span-1">
                                      <p class="font-bold">Station Name</p>

                                      <input type="text" name="lastName" value="" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>

                                  </div>


                                  <div class="col-span-1">
                                      <p class="font-bold">Email Address</p>

                                      <input type="text" name="email" value="" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>

                                  </div>


                                  <div class="col-span-1">
                                      <p class="font-bold">Password</p>

                                      <input type="text" name="password" value="" maxlength="16" class="w-full mt-3 p-2 border-3 border-green-800 focus:outline-none focus:border-green-500 rounded-lg" required>

                                  </div>

                                  <button type="submit" class="border-3 hover:border-green-700 border-green-800 hover:bg-green-700 bg-green-800 text-white py-4 rounded-lg font-bold transition-all duration-500 transform hover:scale-105">
                              <p>Confirm Create</p>
                          </button>

                                  <a href="admin_user.php?token=<?php echo $_GET['token'];?>" class="border-3 hover:border-red-700 border-red-800 hover:bg-red-700 bg-red-800 text-white py-4 rounded-lg text-center font-bold transition-all duration-500 transform hover:scale-105">
                              Cancel
                          </a>

                              </div>

                          </form>

                </div>





        </div>
</div>



<?php include_once('foot.php');?>
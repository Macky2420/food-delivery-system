<?php 
session_start();
include_once('head.php');?>

<div class="group bg-gray-200 h-full w-16 hover:w-36 pt-10 fixed z-10 top-0 left-0 overflow-hidden whitespace-nowrap transition-all duration-500">

            <a href="staff_home.php">
                <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800   text-green-800 border-r-4 border-green-800   text-gray-400 transition-all duration-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                    <p class="opacity-0 group-hover:opacity-100">Home</p>
                </div>
            </a>

            <a href="staff_menu.php">
                <div class="flex flex-row items-center space-x-4 py-3 pl-2 font-bold hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800    text-gray-400 transition-all duration-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                    <p class="opacity-0 group-hover:opacity-100">Menu</p>
                </div>
            </a>

            <form action="../php/action.php" method="post">
                <input type="hidden" name="_token" value="MBDzpIjKBCkau3dJRcKnCLbPib5PAe1T30z72c2U">
                <button type="submit" name="logout" class="w-full flex flex-row items-center space-x-3 py-3 pl-2 font-bold text-gray-400 hover:text-green-800 border-r-0 hover:border-r-4 hover:border-green-800 transition-all duration-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2.5 w-8 flex-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <p class="opacity-0 group-hover:opacity-100">Logout</p>
            </button>

            </form>




        </div>

<?php include_once('foot.php');?>
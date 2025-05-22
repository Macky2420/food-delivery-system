<?php 
session_start();
$title = "Home Admin- Delivery";
include_once('../php/connection.php');
include_once('head.php');
require_once('../php/message.php');?> 
<div class="h-full flex flex-row bg-white overflow-x-auto"> 
    <?php include_once('cus_nav.php');?> 
    <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="grid grid-cols-5">
            <div class="col-span-7 lg:col-span-5">
                <style>
                    .slick-dots {
                        bottom: 10px;
                    }
                </style>
                <div class="relative mx-10 mt-10 -mb-10">
                    <div class="customerHome w-full rounded-2xl overflow-hidden">
                        <img src="../img/sliders/slide1.png">
                        <img src="../img/sliders/slide2.png">
                        <img src="../img/sliders/slide3.png">
                        <img src="../img/sliders/slide4.png">
                        <img src="../img/sliders/slide5.png">
                        <img src="../img/sliders/slide7.png">
                        <img src="../img/sliders/slide6.png">
                    </div>
                </div>
                <div wire:id="u7h44CLXGJyZzthpY60u" wire:initial-data="{&quot;fingerprint&quot;:{&quot;id&quot;:&quot;u7h44CLXGJyZzthpY60u&quot;,&quot;name&quot;:&quot;customer-home-menu&quot;,&quot;locale&quot;:&quot;en&quot;,&quot;path&quot;:&quot;customer\/home&quot;,&quot;method&quot;:&quot;GET&quot;},&quot;effects&quot;:{&quot;listeners&quot;:[&quot;flashMessage&quot;,&quot;flashError&quot;]},&quot;serverMemo&quot;:{&quot;children&quot;:[],&quot;errors&quot;:[],&quot;htmlHash&quot;:&quot;48eb7e76&quot;,&quot;data&quot;:{&quot;foods&quot;:[],&quot;drinks&quot;:[],&quot;section&quot;:null,&quot;optionId&quot;:null,&quot;myOrders&quot;:[],&quot;name&quot;:[],&quot;quantity&quot;:[]},&quot;dataMeta&quot;:{&quot;modelCollections&quot;:{&quot;foods&quot;:{&quot;class&quot;:&quot;App\\Models\\Menu&quot;,&quot;id&quot;:[1],&quot;relations&quot;:[&quot;menuOption&quot;,&quot;category&quot;,&quot;order&quot;],&quot;connection&quot;:&quot;mysql&quot;},&quot;drinks&quot;:{&quot;class&quot;:null,&quot;id&quot;:[],&quot;relations&quot;:[],&quot;connection&quot;:null},&quot;myOrders&quot;:{&quot;class&quot;:null,&quot;id&quot;:[],&quot;relations&quot;:[],&quot;connection&quot;:null}}},&quot;checksum&quot;:&quot;751bff86cccebe4582fb8f41a90c2ddde5d1849c209ea4d5b4bbc8127102559c&quot;}}" wire:init="loadSection" class="p-10">
                    <div wire:poll.450ms></div>
                    <div class="flex flex-row w-full lg:w-1/2 whitespace-nowrap">
                        <div wire:click="food" id="foodsButton" class="border-b-6 hover:border-green-800 border-green-800 w-full flex flex-row items-center gap-x-2 pr-10 py-2 font-bold text-lg cursor-pointer transition-all duration-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                            </svg>
                            <p class="">All Station</p>
                        </div>
                    </div>
                    <div id="foodsContent" class="visible">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-7 mt-10"> <?php
                                if (isset($_GET['token'])) {
                                    $token = $_GET['token'];
                                    $query = $conn->prepare('SELECT role_id FROM users WHERE token = ?');
                                    $query->bind_param('s', $token);
                                    $query->execute();
                                    $result = $query->get_result();
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $role_id = $row['role_id'];

                                        // execute a query to fetch the stations based on the role of the user
                                        if ($role_id == 1) { // assuming role_id 2 is for staff
                                            $station_query = $conn->prepare('SELECT * FROM users WHERE role_id = 2');
                                            $station_query->execute();
                                            $station_result = $station_query->get_result();

                                            while ($station_row = $station_result->fetch_assoc()) {

                                                ?> <div class="my-5 w-full">
                                <form action="../php/action.php" method="post">
                                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                                    <input type='hidden' name='stationToken' value="<?php echo $station_row['token'];?>">

                                    <button type="submit" name="staff_post" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                                        <div class="absolute right-1 top-1 flex flex-row space-x-2"> <?php
                                                                if ($station_row['status'] > 0) {
                                                                    echo '
																			<div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
																				<p>Active</p>
																			</div>';
                                                                } else {
                                                                    echo '
																			<div class="px-2 py-1 bg-yellow-600 text-white text-xs rounded-full">
																				<p>Offline</p>
																			</div>';
                                                                }
                                                                ?> </div>
                                        <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                            <p class="font-semibold text-center tracking-widest"> <?php echo $station_row['name']; ?> </p>
                                        </div>
                                    </button>
                                </form>
                            </div> <?php
                                            }

                                        } else { // for other roles
                                            echo '
															<h2>Their is no station yet.</h2>';
                                        }
                                    } else { // token not found
                                        echo 'Invalid token.';
                                    }
                                }
                                ?> </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php include_once('foot.php');?>
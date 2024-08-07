<?php 
session_start();
$title = "Foodcourt - Customer";
include_once('../php/connection.php');
include_once('head.php');
require_once('../php/message.php');
?> <div class="h-full flex flex-row bg-white overflow-x-auto"> <?php include_once('cus_nav.php');?> <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
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
                <div class="p-10">
                    <div wire:poll.450ms></div>
                    <div class="flex flex-row w-full lg:w-1/2 whitespace-nowrap">
                        <div id="stationButton" class="border-b-6 hover:border-green-800 border-green-800 w-full flex flex-row items-center gap-x-2 pr-10 py-2 font-bold text-lg cursor-pointer transition-all duration-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                            </svg>
                            <p class="">All Station</p>
                        </div>
                        <div id="ordersButton" class="border-b-6 hover:border-green-800 border-gray-300 w-full flex flex-row items-center gap-x-2 pr-10 py-2 font-bold text-lg cursor-pointer transition-all duration-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                            </svg>
                            <p class="">Order History</p>
                        </div>
                    </div>
                    <div id="stationContent" class="visible">
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
                                        if ($role_id == 3) { // assuming role_id 2 is for staff
                                            $station_query = $conn->prepare('SELECT * FROM users WHERE role_id = 2');
                                            $station_query->execute();
                                            $station_result = $station_query->get_result();

                                            while ($station_row = $station_result->fetch_assoc()) {

                                                ?> <div class="my-5 w-full">
                                <form action="../php/action.php" method="post">
                                    <input type="hidden" name="cus_token" value="<?php echo $_GET['token']; ?>">
                                    <input type="hidden" name="station_token" value="<?php echo $station_row['token']; ?>">
                                    <button type="submit" name="cus_menu" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
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
                    <div class="hidden" id="ordersContent">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-7 mt-10">
                        <?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = $conn->prepare('SELECT DISTINCT user_id FROM reserve_orders WHERE cus_token = ?');
    $query->bind_param('s', $token);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_id = $row['user_id'];

            $query2 = $conn->prepare('SELECT * FROM users WHERE id = ?');
            $query2->bind_param('s', $user_id);
            $query2->execute();
            $result2 = $query2->get_result();

            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
?>
                <div class="my-5 w-full">
                    <form action="../php/action.php" method="post">
                        <input type="hidden" name="cus_token" value="<?php echo $_GET['token']; ?>">
                        <input type="hidden" name="station_token" value="<?php echo $row2['token']; ?>">
                        <button type="submit" name="cus_menu" class="relative patternOne border-4 border-green-800 w-full h-44 rounded-lg transform hover:scale-105 transition-all duration-500">
                            <div class="absolute right-1 top-1 flex flex-row space-x-2">
                                <?php
                                if ($row2['status'] > 0) {
                                    echo '<div class="px-2 py-1 bg-green-600 text-white text-xs rounded-full">
                                            <p>Active</p>
                                          </div>';
                                } else {
                                    echo '<div class="px-2 py-1 bg-yellow-600 text-white text-xs rounded-full">
                                            <p>Offline</p>
                                          </div>';
                                }
                                ?>
                            </div>
                            <div class="absolute bottom-0 left-0 py-1.5 bg-green-800 text-white w-full">
                                <p class="font-semibold text-center tracking-widest">
                                    <?php echo $row2['name']; ?>
                                </p>
                            </div>
                        </button>
                    </form>
                </div>
<?php
            }
        }
    } else { // for other roles
        echo '<h2>You have no reservation yet.</h2>';
    }
}
?> </div>
                    </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Livewire Component wire-end:u7h44CLXGJyZzthpY60u -->
            </div>
        </div>
    </div>
</div>
<script>
    // All food station
    const stationButton = document.querySelector('#stationButton');
    const stationContent = document.querySelector('#stationContent');
    // Order history
    const ordersButton = document.querySelector('#ordersButton');
    const ordersContent = document.querySelector('#ordersContent');
    // All food station
    stationButton.addEventListener('click', () => {
        if (stationContent.classList.contains('visible')) {
            stationContent.classList.remove('hidden');
            ordersContent.classList.add('hidden');
            stationButton.classList.add('border-green-800');
            ordersButton.classList.remove('border-green-800');
        }
    });
    // Order history
    ordersButton.addEventListener('click', () => {
        if (ordersContent.classList.contains('hidden')) {
            ordersContent.classList.remove('hidden');
            stationContent.classList.add('hidden');
            stationButton.classList.remove('border-green-800');
            stationButton.classList.add('border-gray-300');
            ordersButton.classList.add('border-green-800');
        }
    });
</script> <?php include_once('foot.php');?>
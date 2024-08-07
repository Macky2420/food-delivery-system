<?php
session_start(); 
$title = 'Help - Foodcourt';
include_once('../php/connection.php');
include_once('head.php');
include_once('../php/message.php');?> <div class="h-full flex flex-row bg-white overflow-x-auto"> 
    <?php include_once('cus_nav.php');?> 
    <div class="ml-16 w-full min-h-screen overflow-hidden text-green-800">
        <div class="p-10">
            <p class="text-3xl font-bold"> Help - Frequently Asked Questions </p>
            <div class="flex flex-row items-center text-sm my-10">
                <a href="cus_home.php" class="font-bold hover:text-blue-800">Home</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <p>Help - Frequently Asked Questions</p>
            </div>
            <div class="flex flex-row items-center gap-x-2 text-gray-500">
                <p class="">Need help in using the website? Browse through the FAQs below</p>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="my-10 flex flex-col gap-y-3 w-full xl:w-1/2">
                <div class="shadow-lg overflow-hidden">
                    <div class="select-none accordion rounded-md flex flex-row items-center justify-between bg-green-800 text-white cursor-pointer px-10 py-3 w-full font-bold">
                        <p>How to make an order?</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <div class="panel rounded-b-md bg-gray-200 text-green-800 px-10 py-6 w-full hidden overflow-hidden">
                        <p>You can make an order from:</p>
                        <ol class="list-disc list-inside">
                            <li>
                                <a href="cus_home.php?token=<?php echo $_GET['token'];?>" class="text-blue-500 font-bold">Home page </a> (All station and Order History)
                            </li>
                            <li>
                                <a href="cus_menu.php?token=<?php echo $_GET['token'];?>" class="text-blue-500 font-bold">Menu page</a>
                            </li>
                        </ol>
                        <br>
                        <p class="font-bold">Steps:</p>
                        <ol class="list-decimal list-inside">
                            <li>From the menu list, select the menu item that you desire.</li>
                            <li>Click on the <strong>Option</strong> field, and select one from the dropdown. </li>
                            <li>Click on the green <strong>Plus</strong> button. </li>
                            <li>The menu item will appear in <strong>My Orders</strong> (right side). </li>
                            <li>Repeat <strong>Step 1 - Step 3</strong> if you want to add more. </li>
                            <li>After you're finished, on <strong>My Orders</strong> section, click <strong>Submit</strong>. </li>
                        </ol>
                    </div>
                </div>
                <div class="shadow-lg overflow-hidden">
                    <div class="select-none accordion rounded-md flex flex-row items-center justify-between bg-green-800 text-white cursor-pointer px-10 py-3 w-full font-bold">
                        <p>How to check my order status?</p>
                        <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <div class="panel rounded-b-md bg-gray-200 text-green-800 px-10 py-6 w-full hidden overflow-hidden">
                        <p>You can access this from:</p>
                        <ol class="list-disc list-inside">
                            <li>
                                <a href="cus_home.php?token=<?php echo $_GET['token'];?>" class="text-blue-500 font-bold">Home page</a>
                            </li>
                            <li>
                                <a href="cus_menu.php?token=<?php echo $_GET['token'];?>" class="text-blue-500 font-bold">Menu page</a>
                            </li>
                        </ol>
                        <br>
                        <p class="font-bold">Steps:</p>
                        <ol class="list-decimal list-inside">
                            <li>On <strong>My Orders</strong> section, click the <strong>Submitted Order</strong> button. </li>
                            <li>Look for the <strong>colored tag</strong> on the menu item. </li>
                            <li>
                                <strong>Pending</strong> means the menu item is currently being prepare.
                            </li>
                            <li>
                                <strong>Completed</strong> means your item has been prepared.
                            </li>
                            <li>
                                <strong>Not available</strong> means your item has not available yet.
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="shadow-lg overflow-hidden">
                    <div class="select-none accordion rounded-md flex flex-row items-center justify-between bg-green-800 text-white cursor-pointer px-10 py-3 w-full font-bold">
                        <p>Where to find drinks section?</p>
                        <svg id="arrow3" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <div class="panel rounded-b-md bg-gray-200 text-green-800 px-10 py-6 w-full hidden overflow-hidden">
                        <p class="font-bold">Steps:</p>
                        <ol class="list-decimal list-inside">
                            <li>Go to <a href="cus_home.php" class="text-blue-500 font-bold">Menu</a> page. </li>
                            <li>Click on the <strong>Drinks</strong> button. </li>
                            <li>The Drink Menu should appear.</li>
                        </ol>
                    </div>
                </div>
                <br>
                <p class="text-3xl font-bold"> Customer - Comment and Feedback </p>
                <br>
                <div class="flex flex-row items-center gap-x-2 text-gray-500">
                                <p class="">Your Feedback Helps Improve Our Services</p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div><br>

                            <form action="../php/action.php" method="post" class="mt-5">
    <div class="text-gray-500 cursor-pointer transition-all duration-500">
    <label for="ratingStars" style="font-size: 20px;" class="mb-2">Rate us:</label> 
  
        <i id="star" class="fa fa-star fa-2x" id="1"></i>
        <i id="star" class="fa fa-star fa-2x" id="2"></i>
        <i id="star" class="fa fa-star fa-2x" id="3"></i>
        <i id="star" class="fa fa-star fa-2x" id="4"></i>
        <i id="star" class="fa fa-star fa-2x" id="5"></i>
        <br><br>
    
</div>

    <?php
    if (isset($_GET['token'])){
        $token = $_GET['token'];
        $stmt1 = $conn->prepare('SELECT * FROM users WHERE token = ?');
        $stmt1->bind_param('s', $token);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if ($result1->num_rows > 0){
            $row1 = $result1->fetch_assoc();
    ?>
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <input type="hidden" id="ratingInput" name="rating" value="">
    <input type="hidden" name="name" value="<?php echo $row1['name']; ?>">
    <?php
        }
    }
    ?>
    <div class="mb-4">
        <textarea id="message" name="message" placeholder="Enter your message here" rows="4" class="border border-green-800 px-3 py-2 rounded-md w-full" required></textarea>
    </div>
    <button type="submit" name="save" class="bg-green-800 text-white px-4 py-2 rounded-md hover:bg-green-700">Submit</button>
</form>


<div class="card bg-gray-200 rounded-md">
  <div class="card-body">
    <?php
      $stmt2 = $conn->prepare('SELECT * FROM feedback ORDER BY id DESC');
      $stmt2->execute();
      $feedbackEntries = $stmt2->get_result();

      if ($feedbackEntries->num_rows === 0) {
        echo '<p>Be the first to provide feedback! Your input is valuable to us.</p>';
      } else {
        $firstComment = true;
        while ($row = $feedbackEntries->fetch_assoc()) {
          $timestamp = strtotime($row['timestamp']);
          $timeAgo = getTimeAgo($timestamp);
    ?>
    <?php if (!$firstComment) { ?>
    <div class="my-4"></div> <!-- Add space between comments -->
    <?php } ?>
    <div class="border border-green-800 rounded-md">
      <div class="d-flex flex-start align-items-center px-10 py-6 w-full">
      <div class="text-gray-500 cursor-pointer transition-all duration-500">
      <?php
      $rating = $row['rating'];
      for ($i = 1; $i <= 5; $i++) {
        $starClass = ($i <= $rating) ? 'fa-star' : 'fa-star-o';
        $starColor = ($i <= $rating) ? 'gold' : 'gray';
        echo '<i class="fa ' . $starClass . ' fa-2x" style="color: ' . $starColor . '"></i>';
      }
      ?>
      <br><br>
    </div>
        <div>
          <i class="fa fa-user-circle-o fa-3x me-3"></i>
          <h6 class="font-bold text-primary mb-1" style="font-size: 20px;"><?php echo $row['user_name']; ?></h6>
        </div>
        <div>
          <p class="text-muted small mb-0 text-gray-500"><?php echo $timeAgo; ?></p>
          <p class="mt-3 mb-4 pb-2 text-center italic mx-auto px-10 w-full" style="font-size: 20px;">
            "<?php echo $row['user_feedback']; ?>"
          </p>
        </div>
      </div>
    </div>
    <?php
        $firstComment = false;
      }
    }
    ?>
  </div>
</div>


<?php
date_default_timezone_set('Asia/Manila'); // Replace 'Your_Timezone' with the appropriate timezone identifier

function getTimeAgo($timestamp) {
  $currentTimestamp = time();
  $diff = $currentTimestamp - $timestamp;

  if ($diff < 60) {
    return $diff . " seconds ago";
  } elseif ($diff < 3600) {
    return floor($diff / 60) . " minutes ago";
  } elseif ($diff < 86400) {
    return floor($diff / 3600) . " hours ago";
  } else {
    return date("M j, Y g:i A", $timestamp);
  }
}
?>

  </div>
</div>

    </div>
            
            
            <script>
               const stars = document.querySelectorAll('#star');
const ratingInput = document.getElementById('ratingInput');

let selectedRating = -1;

stars.forEach((star, index) => {
  star.addEventListener('click', () => {
    selectedRating = index;
    updateStarColors();
    ratingInput.value = selectedRating + 1; // Set the value of the rating input field
  });
});

function updateStarColors() {
  stars.forEach((star, index) => {
    if (index <= selectedRating) {
      star.style.color = 'gold';
    } else {
      star.style.color = 'gray';
    }
  });
}


                var acc = document.getElementsByClassName("accordion");
                var i;
                for (i = 0; i < acc.length; i++) {
                    acc[i].addEventListener("click", function() {
                        if (this.classList.contains('bg-green-800')) {
                            this.classList.remove('bg-green-800');
                            this.classList.add('bg-green-700');
                        } else {
                            this.classList.remove('bg-green-700');
                            this.classList.add('bg-green-800');
                        }
                        var panel = this.nextElementSibling;
                        if (panel.classList.contains('hidden')) {
                            panel.classList.remove('hidden');
                        } else {
                            panel.classList.add('hidden');
                        }
                        var icon = this.lastElementChild;
                        if (icon.classList.contains('rotate-90')) {
                            icon.classList.remove('rotate-90');
                        } else {
                            icon.classList.add('rotate-90');
                        }
                    });
                }
            </script>
        </div>
    </div>
</div> 
<?php include_once('foot.php');?>
<?php 
session_start();
$title = 'Forgot - Foodcourt';
 require_once("head.php");
 require_once('../php/message.php');
 $_SESSION['token'] = bin2hex(random_bytes(32));?>


<div class="grid grid-cols-3 h-screen bg-gradient-to-b from-green-900 via-green-900 to-green-700">

<div class="col-span-3 lg:col-span-1 shadow-2xl w-full flex flex-col items-center justify-center p-5 bg-white rounded-none lg:rounded-r-3xl">
    <svg class="w-40 text-green-900 mb-30" fill="#064e3b" stroke="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 189.748 189.748" xml:space="preserve">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier"> 
            <g><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M76.958,70.746V58.641c27.781,0,51.915,14.78,57.381,35.146l-11.697,3.153C118.582,81.755,99.36,70.746,76.958,70.746z M189.748,117.394h-12.365c-1.318,22.296-15.96,39.934-33.811,39.934H46.435c-17.844,0-32.479-17.638-33.797-39.934H0.26v-12.104 h2.016C0.834,101.99,0,98.55,0,95.016c0-16.529,16.553-30.178,37.702-31.823c7.51-18.061,30.142-30.771,55.89-30.771 c25.693,0,48.267,12.648,55.845,30.65c22.053,0.943,39.59,14.913,39.59,31.939c0,3.546-0.757,6.998-2.198,10.273h2.908 L189.748,117.394L189.748,117.394z M15.832,104.52l-0.919,0.77h157.563c2.104-2.259,4.444-5.77,4.444-10.273 c0-10.772-13.683-19.881-29.885-19.881l-6.508,0.187l-1.241-4.614c-4.072-15.173-23.294-26.182-45.695-26.182 c-22.379,0-41.595,10.985-45.693,26.123l-1.203,4.472h-4.637c-16.275,0-29.965,9.111-29.965,19.89 C12.105,98.334,13.364,101.541,15.832,104.52z M165.177,117.394H24.846c1.162,15.593,10.344,27.828,21.589,27.828h97.137 C154.815,145.216,164.012,132.986,165.177,117.394z"></path> </g> </g>
            </svg>
    <form autocomplete="off" action="../php/action.php" method="post" class="w-full flex flex-col items-center">
        
        <div class="space-y-3 w-3/5 mb-4">
            <p class="font-bold text-2xl text-green-900">Forgot Password?</p>
        </div>
  
        <div class="space-y-3 w-3/5 mb-4">
            <p class="font-semibold">Verify your Email</p>
            <input type="text" placeholder="Enter your Email Address" name="email"  class="focus:outline-none border-3 border-gray-400 focus:border-green-500 rounded-lg p-2 w-full" required> <!--border-red-500 bg-red-200-->
            
            <?php if(isset($_SESSION['sendError'])): ?>
            <p class="text-xs text-red-500"><?php echo $_SESSION['sendError']; ?></p>
            <?php endif; ?>
          
        </div>
                <!-- Next it can be Submit and remove the a tag -->
        <button type="submit" name="forgot" class="rounded-2xl flex flex-row items-center justify-center space-x-2 py-3 w-3/5 bg-green-800 hover:bg-green-600 text-white font-bold mt-4 transform hover:scale-105 transition duration-500">
          <p>Send Code</p>
      </button>

      <div class="space-y-3 w-3/5 mb-10 mt-4">
        <a href="login.php"><p class="text-green-900 italic hover:underline">Back to Login</p></a>
      </div>

        <div class="visible lg:hidden text-xs mt-5 text-green-800 font-bold absolute bottom-0 p-4 flex flex-row items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            <p>Food Court RS V1.0 - Creation of JAMF-ROSE &copy; 2023</p>
        </div>

    </form>

</div>

<div class="relative lg:col-span-2 h-full bg-gradient-to-b from-green-900 via-green-900 to-green-700 hidden lg:flex flex-col items-center justify-center">
<p class="text-white font-bold text-4xl p-10 text-center">NWSSU Food Court Reservation System</p>

<div class="w-0 lg:w-2/3 autoplay text-white text-sm text-center">
    <div>
        <p class="">Hungry, but hate waiting in line?</p>
    </div>
    <div>
      <p class="">Let our reservation system satisfy your cravings!</p>
  </div>
    <div>
        <p class="">Maximize your lunch break with our</p>
    </div>
    <div>
      <p class="">Food Court Reservation System - eat more, wait less!</p>
  </div>
    <div>
        <p class="">Join the smart eaters - use our website to</p>
    </div>
    <div>
      <p class="">Reserve your food at the food court!</p>
  </div>
</div>

<div class="text-xs text-white absolute bottom-0 p-4 flex flex-row items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
    </svg>
    <p>Creation of JAMF-ROSE &copy; 2023</p>
</div>
</div>
</div>
<script>

const thisEmail = document.getElementById('thisEmail');

thisEmail.addEventListener('input', () => {
  thisEmail.classList.remove('border-red-500', 'bg-red-200');
  thisEmail.classList.add('border-green-500');

  const errorElement = document.querySelector('#thisEmail + p.text-xs.text-red-500');
  if (errorElement) {
    errorElement.remove();
    <?php unset($_SESSION['sendError']); ?>
  }
});


</script>
<?php require_once("foot.php");?>
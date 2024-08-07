<!-- Livewire Scripts -->

<!--<livewire:scripts />-->


<!-- <script data-turbo-eval="false" data-turbolinks-eval="false">
        if (window.livewire) {
            console.warn('Livewire: It looks like Livewire\'s @livewireScripts JavaScript assets have already been loaded. Make sure you aren\'t loading them twice.')
        }
      window.livewire = new Livewire();
        window.livewire.devTools(true);
        window.Livewire = window.livewire;
        window.livewire_app_url = '';
        window.livewire_token = 'FziAlBxiLr26hQghPrMs6alf8FLiyr3bR7tty4wg';

        /* Make sure Livewire loads first. */
        if (window.Alpine) {
            /* Defer showing the warning so it doesn't get buried under downstream errors. */
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    console.warn("Livewire: It looks like AlpineJS has already been loaded. Make sure Livewire\'s scripts are loaded before Alpine.\\n\\n Reference docs for more info: http://laravel-livewire.com/docs/alpine-js")
                })
            });
        }

        /* Make Alpine wait until Livewire is finished rendering to do its thing. */
        window.deferLoadingAlpine = function(callback) {
            window.addEventListener('livewire:load', function() {
                callback();
            });
        };

        let started = false;

        window.addEventListener('alpine:initializing', function() {
            if (!started) {
                window.livewire.start();

                started = true;
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            if (!started) {
                window.livewire.start();

                started = true;
            }
        });
    </script> -->
  



<!-- JQuery -->
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<!-- Slick JS -->
<script type="text/javascript" src="../CSS/slick/slick.min.js"></script>

<!-- Slick Initiator -->
<script type="text/javascript" src="../JS/slick.js"></script>

<!-- For all the actions -->
<!--<script type="text/javascript" src="../JS/app.js"></script>-->
<!--<script type="text/javascript" src="../JS/menu_index.js"></script>-->
<!--<script type="text/javascript" src="../JS/message.js"></script>-->
<!--<script type="text/javascript" src="../JS/order_index.js"></script>-->
<!--<script type="text/javascript" src="../JS/order_show.js"></script>-->

</body>
</html>
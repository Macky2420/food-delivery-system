<?php
if (session('error')) { ?>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        timer: 10000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'error',
        title: '<?php echo session('error'); ?>',
        showCloseButton: true
    });
</script>
<?php } elseif (session('success')) { ?>
  <script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        timer: 10000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: '<?php echo session('success'); ?>',
        showCloseButton: true
    });
</script>
<?php } 

elseif (session('success')) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            timer: 10000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: '<?php echo session('success'); ?>',
            showCloseButton: true
        })
    </script> <?php
}
?> 
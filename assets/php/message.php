<?php

if (isset($_SESSION['error'])) {
    echo '<script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            iconColor: "white",
            customClass: {
                popup: "colored-toast"
            },
            timer: 10000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer)
                toast.addEventListener("mouseleave", Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: "error",  
            title: "' . $_SESSION['error'] . '",
            showCloseButton: true
        })
    </script>';
    unset($_SESSION['error']);
} elseif (isset($_SESSION['success'])) {
    echo '<script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            iconColor: "white",
            customClass: {
                popup: "colored-toast"
            },
            timer: 10000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer)
                toast.addEventListener("mouseleave", Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: "success",
            title: "' . $_SESSION['success'] . '",
            showCloseButton: true
        })
    </script>';
    unset($_SESSION['success']);
}
?>

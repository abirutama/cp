</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php if($this->session->flashdata('success_message')){ ?>
<script>
Swal.fire({
    text: '<?= $this->session->flashdata('success_message') ?>',
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
<?php } ?>

<?php if($this->session->flashdata('error_message')){ ?>
<script>
Swal.fire({
    text: '<?= $this->session->flashdata('error_message') ?>',
    icon: 'error',
    confirmButtonText: 'OK'
});
</script>
<?php } ?>

<script>
$(document).ready(function() {

    // Check for click events on the navbar burger icon
    $(".navbar-burger").click(function() {
        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");
    });

    // Modal Deposit
    $("#primary-deposit").click(function() {
        $("#modal-wallet").toggleClass("is-active");
    });
    $("#close-primary-deposit").click(function() {
        $("#modal-wallet").toggleClass("is-active");
    });

    
});
</script>


</html>
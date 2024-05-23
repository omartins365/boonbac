<?php
$err_msg = "";
//include other errors in alert display
if ($errors->any()) {
    // alertDanger($err_msg,"Couldn't complete request");
     foreach ($errors->all() as $error) {
        alertDanger($error);
     }
}

$messages = Core::get_smessage();

// dd($rsp_msg,$message);
//display alert
if (!empty($messages)) {
    ?>
<div class="message-box px-2">
    <?php
    foreach ($messages as $message) {
        $alert_temp = $message[0];
        $alert_heading = $message[1];
?>
    <div class="messages alert <?php echo $alert_temp; ?> alert-dismissible fade show" style="align-content: center; text-align: center;" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span class="sr-only">Close</span>
            </button>
            <div class="lead mb-0">
                @isset($alert_heading)
                    <h5 class=" mb-0"><?php echo $alert_heading; ?></h5>
                @endisset

                <div class="alert-body"><?php echo $message[2]; ?> </div>
            </div>
    </div>
    <?php
    }
    ?>
</div>
<?php
}
?>

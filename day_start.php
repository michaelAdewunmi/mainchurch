<?php
require_once './config/config.php';
session_start();


if ($_SESSION['admin_type'] !== 'super'
    && $_SESSION['admin_type'] !== 'supercashr'
) {
    echo "
            <script type='text/javascript'>alert('Unauthorized to access this page');
                window.location='logout.php';
            </script>
        ";
}
?>

<head>
    <link rel="stylesheet" href="assets/css/special-notification-and-extras.css">
</head>
<?php

//Get DB instance.
$db = getDbInstance();


$db->where("day", date('Y-m-d'));
$db->where("day_started", true);
$db->where("day_ended", "NOT YET");
$db->where("time_day_ended", "NULL");
$db->where("endorsed_by", 'supercashr');

$row = $db->get('start_and_end_day_controller');

if ($db->count>=1) {

?>

<div class="special_div">
    <h1 class="notification">Day Started Already</h1>
    <a class="special_btn" href="/index.php">Go Home</a>
</div>

    <?php

} else {

    $data = Array (
        "day"               => date('Y-m-d'),
        "day_started"       => true,
        "time_day_started"  => date('Y-m-d H:i:s'),
        "endorsed_by"       => "supercashr"
    );

    $result = $db->insert("start_and_end_day_controller", $data);
    ?>
    <div class="special_div">
        <h1 class="notification green">Successfully Started the day</h1>
        <a class="special_btn" href="/index.php">Go Home</a>
    </div>
    <?php
}


/*
CREATE TABLE `start_and_end_day_controller` (
    `id` INT(50) NOT NULL AUTO_INCREMENT,
    `day` DATE NOT NULL,
    `day_started` TINYINT(1) NOT NULL DEFAULT '0',
    `time_day_started` VARCHAR(50) DEFAULT NULL,
    `day_ended` VARCHAR(7) DEFAULT 'NOT YET',
    `time_day_ended` VARCHAR(50) DEFAULT 'NULL',
    `endorsed_by` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    */

?>





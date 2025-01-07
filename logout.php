<?php
session_start();
session_destroy();
header("Location: Recipe_HomePage.php");
exit();
?> 
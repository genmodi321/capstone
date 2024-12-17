<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
    echo "User is logged in: " . $_SESSION['user_id'] . ", " . $_SESSION['user_type'];
} else {
    echo "User is not logged in.";
}
?>

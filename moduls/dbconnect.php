<?php 
function dbconnect(){
    return mysqli_connect('localhost','mysql','mysql','task_manager');
}
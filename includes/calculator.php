<?php

include "../class/calculator.class.php";

if(!isset($_POST['submit'])) {

 
  header("Location: ../index.php?multiply=error");
 } else {
     
     
     include_once '../includes/config.php';
     $myString = mysqli_real_escape_string($conn,$_POST['submit']);
     $myArray = explode(',', $myString);
     
    $factor1 = $myArray[0];
    $factor2 = $myArray[2];
    $operator = $myArray[1]; 
    $result = new Calculate($factor1, $factor2);
   
    // this works but I don't understand why the if statements won't work
    // $store = $result-> multiply();
    
    // date config
    
    date_default_timezone_set("Europe/Sarajevo");
    $timestamp = time();
    $mysql_datetime = strftime("%Y-%m-%d %H:%M:%S");
    
    // doesn't work as an example on how not to do it (function/variable scope issue)
    
    // switch(isset($operator)){
    //     case "+":
    //          $store = $result-> add();
    //         break;
    //     case "-":
    //          $store = $result-> subtract();
    //         break;
    //     case "*":
    //          $store = $result-> multiply();
    //         break;
    //     case "/":
    //          $store = $result-> divide();
    //         break;
    // };
    
    // works
    
    if($operator === "+"){
         $store = $result-> add();
    } elseif($operator === "-") {
         $store = $result-> subtract();
    } elseif($operator === "*"){
         $store = $result-> multiply();
    } elseif($operator === "/"){
         $store = $result-> divide();
    }
    
   if(empty($factor1) || empty($factor2) || empty($operator) || empty($store) || empty($mysql_datetime)){
        
        header("Location: ../index.php?sql=error");
        exit();
    } else {
        $sql = "INSERT INTO multiplication (factor1, factor2, operation, result, date) VALUES ('$factor1', '$factor2', '$operator', '$store', '$mysql_datetime');";
        mysqli_query($conn, $sql);
        
        // also stores data inside the url that can be accessed via get method
        header("Location: ../index.php?multiply=success&factor1=$factor1&factor2=$factor2&operator=$operator&store=$store&mysql_datetime=$mysql_datetime");
        exit();
    }
    
    
     
     
 }

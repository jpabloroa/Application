<?php 



include "routes.php";





/**
 * -----------------------------------------------
 * PHP Route Things
 * -----------------------------------------------
 */

//define your route. This is main page route. for example www.example.com
Route::add('/hallo', function(){

    //define which page you want to display while user hit main page. 
    echo "perico pico";
    //include('administrador.php/clientes/');
});


// route for www.example.com/join
Route::add('/join', function(){
    include('join.php');
});

Route::add('/login', function(){
    include('login.php');
});

Route::add('/forget', function(){
    include('forget.php');
});



Route::add('/logout', function(){
    include('logout.php');
});





//method for execution routes    
Route::submit();
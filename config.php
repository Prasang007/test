<?php 


    if($_SERVER['HTTP_HOST'] == 'localhost')
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $db = 'test';
    }
    DEFINE('HOST',$host);
    DEFINE('USERNAME',$username);
    DEFINE('PASSWORD', $password);
    DEFINE('DBNAME',$db);
?>

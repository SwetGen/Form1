<?php

ini_set('display_errors', 'on');

header('Content-type: text/html');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Content-Type: text/html; charset= utf-8');

// Подключение к БД MySQL
$dbHost = 'localhost';
$dbName = 'sw';
$dbUser = 'sw';
$dbPass = 'R0';
$connect = @mysql_connect($dbHost, $dbUser, $dbPass) or die('Error: cannot connect to database server');
mysql_select_db($dbName) or die('Error: specified database does not exist');

$do = $_GET['do']; 

switch ($do) {

    case 'loadData': // Загружает все отзывы из БД
        $allFeedBacks = mysql_query("SELECT * FROM `FeedBacks`");
        if(mysql_num_rows($allFeedBacks)){
            $elems[] = mysql_fetch_assoc($allFeedBacks);
            while ($row = mysql_fetch_assoc($allFeedBacks)){
                $elems[] = $row;
            }
            echo json_encode( array('arr' => $elems) );
        }
        break;

    case 'saveData': // Загружает новый отзыв в БД
        $userName = $_POST['userName'];
        $feedBack = $_POST['feedBack'];
        $curTime = time();
        $sqls[] = "(NULL,'".mysql_escape_string((string)$userName)."', '".mysql_escape_string((string)$feedBack)."', '".mysql_escape_string((int)$curTime)."')";
        $saveFeedBack = mysql_query("INSERT INTO `FeedBacks` (`id`, `username`, `feedback`, `date`) VALUES ".implode(', ', $sqls));
        $idRecordBD = mysql_insert_id();
        echo json_encode( array('id' => $idRecordBD ) );
        break;

    case 'deleteData': // Удаляет отзыв из БД
        $id = $_POST['id'];
        $deleteFeedback = mysql_query("DELETE FROM `FeedBacks` WHERE `id` = ".$id);
        break;

    case 'checkAdmin': // Загружает и сранивает пароль/логин админа
        $flag = 0;
        $curLogin = $_POST['login'];
        $curPassword = $_POST['password'];
        $adminAcc = mysql_query("SELECT * FROM `Account`");
        if(mysql_num_rows($adminAcc)){
            $elems2[] = mysql_fetch_assoc($adminAcc);
            while ($row2 = mysql_fetch_assoc($adminAcc)){
                $elems2[] = $row2;
            }
            foreach ($elems2 as $key => $value) {
                if ($value['login'] == $curLogin && $value['password'] == $curPassword) {
                    $flag = 1;
                }
            }
        }
        echo json_encode( array('response' => ($flag == 1 ? "ok" : "not ok") ) );
        break;

    default:
        # code...
        break;
}




?>

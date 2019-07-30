<?php
// DB 설정
$db_host = 'localhost';
$db_user = 'remnant2816';
$db_password = 'ehdghk08!@';
$db_database = 'remnant2816';

// DB 연결
$connect = mysql_connect($db_host,$db_user,$db_password) or die(mysql_error());
mysql_select_db($db_database, $connect) or die(mysql_error());
mysql_query("SET NAMES 'utf8'", $connect) or die(mysql_error());

$query = "UPDATE g5_member SET mb_10 = '$_POST[mb_10]' WHERE mb_id = '$_POST[mb_id]' ";
$result = mysql_query($query);


if (!$result) die(mysql_error());
mysql_close($connect);

echo "<script>alert(\"Input Success!\");</script>";
// 처리가 완료되면 성공 메시지 보여주고 이동할 페이지로 이동


 $prevPage = $_SERVER["HTTP_REFERER"]; // prevPage 변수에 이전 페이지 변수를 저장함
echo "<script>location.href='http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog&wr_id=".$_POST[wr_id]."</script>";


header("location:".$prevPage); // DB 처리를 마치고 원래 페이지로 이동시킴
?>
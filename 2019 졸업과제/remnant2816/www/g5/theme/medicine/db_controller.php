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


/*
*
* 190508 $owner가 다른 item을 삭제/추가 하려고 할때에 막아주는 코드가 필요해 
* 
 */


// DB에 데이터 입력
if( $_POST[delete_id] == "" ) { // delete_id 에 아무 값이 없으면, INSERT
	$query = "insert into g5_item (i_owner, i_name, i_status, i_target, i_begin, i_end, i_etc1, i_etc2, i_etc3) values('$_POST[i_owner]', '$_POST[i_name]', '$_POST[i_status]', '$_POST[i_target]', '$_POST[i_begin]', '$_POST[i_end]', '$_POST[i_etc1]', '$_POST[i_etc2]', '$_POST[i_etc3]')";

	$result = mysql_query($query);
}
else { // delete_id 에 값이 있으면 DELETE
	$query = "DELETE FROM g5_item WHERE i_id = '$_POST[delete_id]'";
	$result = mysql_query($query);
}
// DB 입력시 오류가 있다면 오류를 출력하고 없으면 DB 연결 끊기
if (!$result) die(mysql_error());
mysql_close($connect);

echo "<script>alert(\"Input Success!\");</script>";
// 처리가 완료되면 성공 메시지 보여주고 이동할 페이지로 이동


 $prevPage = $_SERVER["HTTP_REFERER"]; // prevPage 변수에 이전 페이지 변수를 저장함
//echo "<script>location.href='http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog&wr_id=".$_POST[wr_id]."</script>";


header("location:".$prevPage); // DB 처리를 마치고 원래 페이지로 이동시킴
?>
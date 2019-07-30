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


// DB에 데이터 입력
// 하위노드의 카테고리이름과  같은 이름을 가진 노드가, 그 하위노드의 상위노드가 됨.


$sql = "SELECT * FROM g5_valid_data WHERE d_subject = '$_POST[d_category]'";
$res = mysql_query($sql);
$row = mysql_fetch_array($res);

$parrent_id = $row['d_id'];



$query = "insert into g5_valid_data (d_pid, d_owner, d_type, d_category, d_subject, d_content, d_url) values('$parrent_id', '$_POST[d_owner]', '$_POST[d_type]', '$_POST[d_category]', '$_POST[d_subject]', '$_POST[d_content]', '$_POST[d_url]')";

	$result = mysql_query($query);


// DB 입력시 오류가 있다면 오류를 출력하고 없으면 DB 연결 끊기
if (!$result) die(mysql_error());
mysql_close($connect);

echo "<script>alert(\"Input Success!\");</script>";
// 처리가 완료되면 성공 메시지 보여주고 이동할 페이지로 이동


 $prevPage = $_SERVER["HTTP_REFERER"]; // prevPage 변수에 이전 페이지 변수를 저장함
//echo "<script>location.href='http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog&wr_id=".$_POST[wr_id]."</script>";


header("location:".$prevPage); // DB 처리를 마치고 원래 페이지로 이동시킴
?>
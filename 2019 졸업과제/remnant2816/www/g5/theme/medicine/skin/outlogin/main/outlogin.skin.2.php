<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<!-- 로그인 후 아웃로그인 시작 { -->
<section id="main_login_after">
	<h2>나의 회원정보</h2>
	<div class="hello">
		<span class="profile_img"><?php echo get_member_profile_img($member['mb_id']); ?></span>
		<br><b><?php echo $nick ?></b>님,<br>
		<div class="myinfo">
			<a href="http://remnant2816.cafe24.com/g5/bbs/member_confirm.php?url=register_form.php">MyPage</a>
		</div>

		<?php 
	        $mb = get_member($member['mb_id']);
	        $mb_name = $mb['mb_nick'];
	        // 190516 로그인된 ID 의 닉네임과, BLOG 게시판의 작성자가 일치하는 blog를 새창으로 열기

	        $sql = "SELECT wr_id FROM g5_write_blog WHERE wr_name = '$mb_name'";
	        $result = sql_query($sql);

	        for($i =0; $row = sql_fetch_array($result); $i++){
        	    $link = $row['wr_id'];
    		}
		 ?>
		<div class="myinfo"><a href="http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog&wr_id=<?php echo $link ?>" onClick="window.open('http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog&wr_id=<?php echo $link ?>','pagename','resizable,height=880,width=1200'); return false;">MyBlog</a></div>

		<div class="myinfo"><a>Menu</a></div>
    </div>
</section>
<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->

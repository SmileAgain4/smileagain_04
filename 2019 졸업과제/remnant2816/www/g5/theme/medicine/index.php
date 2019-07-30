<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<section id="container_middle" class="idx_section idx_section2">
	<div class="innr">
		<div class="block block1">
			<h3>About Sharing-Economy</h3>
			<p>공유경제에 대해서<br>&nbsp;</p>
			<a href="#" class="go_bd">Learn</a>
		</div>
		<div class="block block2">
			<h3>BLOG List</h3>
			<p>Smile Again에 등록된<br>블로그 리스트</p>
			<a href="http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog" class="go_bd">Search Blogs</a>
		</div>
		<div class="block block3">
			<h3>BLOG Open</h3>
			<p>Smile Again에서<br>나만의 Blog를 개설합니다.</p>
			<a href="http://remnant2816.cafe24.com/g5/bbs/write.php?bo_table=blog" class="go_bd">Open My Blog</a>
		</div>
	
		<div class="block block4">
			<?php echo outlogin('theme/main'); // 외부 로그인 ?>
		</div>
		<div class="block block5">
			<!-- 190502 /medicine/skin/outlogin/main/outlogin.skin.2.php 에서 설정 -->
		    <?php
		    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
		    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
		    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
		    echo latest('theme/news', 'blog', 5, 23);
		    ?>
		</div>
		<div class="block block6">
			<h3>SNS 연동</h3>
			<p>나의 Blog에<br>SNS를 연동하는 방법입니다.</p>		
			<a href="#" class="go_bd">Kakao 플러스친구</a>
		</div>
		<div class="block block7">
			<h3>채팅</h3>
			<p>SmileAgain의 블로거와 회원<br>채팅방에 참여합니다.</p>		
			<a href="#" class="go_bd">Chattings</a>
		</div>
	</div>
</section>

<hr>
<!-- 190502 인기블로그 썸네일 추가 -->
<section class="idx_section">
	<div id="thumbnail_wrapper">
	<div id="thumbnail_title">
		<span> 더 나은 세상을 위한 공유경제 </span>
	</div>

	<ul class="portfolio_list">
<?php
	$sql = "select * from g5_write_blog_main ORDER BY wr_id DESC";
	$result = sql_query($sql);

// 전체 게시글 불러오는 소스
//	for($i=0; $row = sql_fetch_array($result); $i++){

//	테스트용 8개만 불러오는 소스
	for($i=0; $i < 8 && $row = sql_fetch_array($result); $i++){
		preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $row['wr_content'], $img);
		echo "<li class='portfolio'>"
				."<a href=''>"
				."<div class='portfolio_img'>"
					."<img src='"
					.$img[1][0]	// work 게시판의 각 게시글의 첫번째 img의 src를 불러옴
					."'/>"
				."</div>"
				."<div class='portfolio_con'>"
					."<h2>".$row['wr_subject']."</h2>"
				."</div>"
				."</a>"
			."</li>";
	}
?>
	</ul>
	</div>
</section>
<hr>
<!-- 190502 인기블로그 썸네일 추가 -->

		    
<section class="idx_section">
	<div class="innr">
	<?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    echo latest('theme/basic', 'free', 4, 23);
    ?>
    </div>
</section>

<section class="idx_section idx_section2">
	<div class="innr">
	<?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    echo latest('theme/gallery_block', 'gallery', 6, 20);
    ?>
    </div>
</section>

<section id="contact" class="idx_section">
	<div class="innr">
		<h2>Smile Again : Office </h2>
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3259.0149664355067!2d129.08011751552226!3d35.23099746213889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x356893ed44882865%3A0x7734040946809f1!2z7Lu07ZOo7YSw6rO17ZWZ6rSA!5e0!3m2!1sko!2skr!4v1556692615359!5m2!1sko!2skr" width="1100" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
		<p>Address : <span>부산광역시 금정구 부산대학로 컴퓨터공학관 #777.</span></p>
		<p>TEL : <span>1234-1234</span></p>
	</div>
</section>

<script>
	$("#container").removeClass("container").addClass("idx-container");
</script>
<?php include_once(G5_THEME_PATH.'/tail.php'); ?>
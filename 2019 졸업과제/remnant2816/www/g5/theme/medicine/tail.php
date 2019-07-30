<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>

	</div>

</div>
<!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->
<div id="ft">
    <div id="ft_wr">
        <ul id="ft_menu">
            <li><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1문의</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/new.php">새글</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php" class="visit">접속자 <strong class="visit-num"><?php echo connect('theme/basic'); // 현재 접속자수  ?></strong></a></li>
        </ul>
        <?php echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
        <div id="ft_link">
	        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">플랫폼 소개</a>
	        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a>
	        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관</a>
	    </div>
	    <span class="ft_adds">부산광역시 금정구 부산대학로, 부산대학교 컴퓨터공학관 #777</span>
	    <div id="ft_copy">Copyright &copy; <b> SMILE AGAIN</b> All rights reserved.</div>	  
    </div>
    <div id="ft_fix">
    	<div class="innr">
			<span class="quick_tit">Quick Menu <i class="fa fa-plus-circle" aria-hidden="true"></i></span>
	    	<ul>
	    		<li><a href="http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=blog">Blog</a></li>
	    		<li><a href="http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=free">자유게시판</a></li>
	    		<li><a href="http://remnant2816.cafe24.com/g5/bbs/board.php?bo_table=qa">QnA</a></li>
	    		<li><a href="http://remnant2816.cafe24.com/g5/bbs/member_confirm.php?url=register_form.php">My Page</a></li>
	    	</ul>
    	</div>  
    </div>    
    <div id="top_btn">
        <div class="top_btn_wp">
            <a href="#" title="상단으로" class="scroll-top"><i class="fa fa-2x fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span></a>
            <a href="#" title="가운데로" class="scroll-center"><i class="fa fa-circle" aria-hidden="true"></i><span class="sound_only">가운데로</span></a>
            <a href="#" title="하단으로" class="scroll-bottom"><i class="fa fa-2x fa-arrow-down" aria-hidden="true"></i><span class="sound_only">하단으로</span></a>
        </div>
    </div>
    <script>
    $(function() {

        $("#top_btn .scroll-top").on("click", function(e) {
            e.preventDefault();
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
        $("#top_btn .scroll-center").on("click", function(e) {
            e.preventDefault();

            var middle_pos = $("body").offset().top - ( $(window).height() - $("body").outerHeight(true) ) / 2;

            $("html, body").animate({scrollTop:middle_pos}, '500');
            return false;
        });

        $("#top_btn .scroll-bottom").on("click", function(e) {
        	e.preventDefault();

        	var scrollBottom = $("html,body").scrollTop + $("html,body").height();

            $("html, body").animate({scrollTop:$(document).height()}, '500');
            return false;
        });
    });
    </script>       
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">
<iframe src="<?php echo $board['bo_1']."&".$board['bo_2']."&nick=".$member['mb_nick']?>" width=100% height=600 frameborder=0 framespacing=0 marginheight=0 marginwidth=0 scrolling=no vspace=0></iframe>
</div>
<?php if ($admin_href) { ?><a href="<?php echo $admin_href ?>">*</a><?php } ?>


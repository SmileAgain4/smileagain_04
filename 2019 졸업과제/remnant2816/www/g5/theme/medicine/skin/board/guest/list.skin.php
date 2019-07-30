<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 회원 레벨이 글쓰기 레벨 이상이면, 쓰기 페이지로 보낸다.
if ($member['mb_level'] >= $board['bo_write_level']) {
	if ( basename($_SERVER["PHP_SELF"]) == "board.php" ) {
		goto_url('./write.php?bo_table='.$bo_table."&page=".$page);
		exit();
	}
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 조회수 보여주느냐 마느냐 - "0" 이나 "" 이면 안보여주고, 그외의 값이면 보여준다.
$is_hit_view = "0";
if ($is_hit_view) $colspan--;
?>

<link rel="stylesheet" href="<?php echo $board_skin_url ?>/style.css">

<?php if ( basename($_SERVER["PHP_SELF"]) != "write.php" ) { // 글쓰기 페이지에서도 bo_subject 를 가린다.?>
<?php if (!$wr_id) { ?><h2 id="bo_list_title"><?php echo $board['bo_subject'] ?><span class="sound_only"> 목록</span></h2><?php } ?>
<?php } ?>

<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">

	<!-- 게시판 카테고리 시작 { -->
	<?php if ($is_category) { ?>
	<form name="fcategory" id="fcategory" method="get">
	<nav id="bo_cate">
		<h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
		<ul id="bo_cate_ul">
			<?php echo $category_option ?>
		</ul>
	</nav>
	</form>
	<?php } ?>
	<!-- } 게시판 카테고리 끝 -->

	<!-- 게시판 페이지 정보 및 버튼 시작 { -->
	<div class="bo_fx">
		<?php if ($rss_href || $write_href) { ?>
		<ul class="btn_bo_user">
			<?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
			<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
		</ul>
		<?php } ?>
	</div>
	<!-- } 게시판 페이지 정보 및 버튼 끝 -->

	<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="sw" value="">

	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption><?php echo $board['bo_subject'] ?> 목록</caption>
		<tbody>
		<?php
		for ($i=0; $i<count($list); $i++) {

			// 190508 $owner 값으로 게시글 필터링 
			if($list[$i]['wr_1'] == $owner || !isset($owner)) {

		?>
        <div class="guestwrap">
        <div class="list">
            <div class="left">
                <?php if ($is_checkbox) { ?>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                <?php } ?>
                <?php echo $list[$i]['datetime'] ?> <b><?php
			if ($list[$i]['is_notice']) // 공지사항
				echo '<strong>공지</strong>';
			else if ($wr_id == $list[$i]['wr_id'])
				echo "<span class=\"bo_current\">열람중</span>";
			else
				echo "no.".$list[$i]['num'];
			?></b>
            </div>
            <div class="right">
                <div class="auther">[ <?php echo $list[$i]['wr_1'] ?> ] <?php echo $list[$i]['name'] ?></div>
                <div style="width:600px !important; overflow:hide;"><?php if($list[$i]['wr_option']=="secret"){
                        echo "비밀글입니다 <img src='{$board_skin_url}/img/icon_secret.gif'>";
                    }else {
                        echo "<span style='word-break:break-all; width:600px; white-space:pre-wrap'>".$list[$i]['wr_subject']."</span>"; 
                    } ?></div>
                <div style="margin-top:10px;">
                    <?php if ($list[$i]['comment_cnt']) { ?><strong><a href="<?php echo $list[$i]['href'] ?>&c=1">답변<?php echo $list[$i]['comment_cnt']; ?>개</a></strong><?php }else{ ?><a href="<?php echo $list[$i]['href'] ?>&c=1">답변달기</a><?}?>
                
                </div>
            </div>
        </div>
        </div>
            
		<?php 
		// 190508 $owner 값으로 게시글 필터링 
		} // 필터랑 IF문 괄호 닫기 
	}

		 ?>
		<?php if (count($list) == 0) { echo ''; } ?>
		</tbody>
		</table>
	</div>

	<?php if ($list_href || $is_checkbox || $write_href) { ?>
	<div class="bo_fx">
		<?php if ($is_checkbox) { ?>
		<ul class="btn_bo_adm">
			<li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
			<li><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>
			<li><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>
		</ul>
		<?php } ?>

		<?php if ($list_href || $write_href) { ?>
		<ul class="btn_bo_user">
			<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li><?php } ?>
		</ul>
		<?php } ?>
	</div>
	<?php } ?>
	</form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages;  ?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
	<legend>게시물 검색</legend>

	<form name="fsearch" method="get">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sop" value="and">
	<label for="sfl" class="sound_only">검색대상</label>
	<select name="sfl" id="sfl">
		<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
		<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
		<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
		<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
		<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
		<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
		<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
	</select>
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required  class="frm_input required" size="15" maxlength="15">
	<input type="submit" value="검색" class="btn_submit">
	</form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
	var f = document.fboardlist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}

function fboardlist_submit(f) {
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택복사") {
		select_copy("copy");
		return;
	}

	if(document.pressed == "선택이동") {
		select_copy("move");
		return;
	}

	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
			return false;
	}

	return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
	f.action = "./move.php";
	f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->

<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
/*
주소 형태는 //ch4.azo.co.kr/c04/?rn=방번호&rt=방제목&색상표&size=1&nick=<?php echo $member['mb_nick']?> 형식입니다.
예)
//ch4.azo.co.kr/c04/?rn=12345678&rt=아조 채팅 테스트&size=1&nick=<?php echo $member['mb_nick']?>"
*/

?>

<div class="azo_lat">
<iframe src="//ch4.azo.co.kr/c04/?rn=12345678&rt=아조 채팅 테스트&size=1&nick=<?php echo $member['mb_nick']?>" width=100% height=100% frameborder=0 framespacing=0 marginheight=0 marginwidth=0 scrolling=no vspace=0></iframe>
</div>
</div>

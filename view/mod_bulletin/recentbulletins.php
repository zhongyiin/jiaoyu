<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
if (sizeof($bulletins_list)) {
?>
<style type="text/css">
.bulletin h4 {font-weight:normal;}
#andyscroll<?php echo $randstr;?> {
	overflow: hidden;
	padding: 0 10px;
	text-align: left;
	height:150px;
	overflow:hidden;
}
#andyscroll<?php echo $randstr;?> a {
	display:block;
}
</style>

<div class="list_con notice_con" id="andyscroll<?php echo $randstr;?>">
	<div class="bulletin" style="height:auto;" id="scrollmessage<?php echo $randstr;?>">
	<?php 
		foreach($bulletins_list as $bulletin) {
			echo '<h4><a href="'.Html::uriquery('mod_bulletin', 'bulletin_content', array('bulletin_id' => $bulletin->id)).'">'.$bulletin->title.'</a></h4>';
		}
	?>
	</div>
	<div id="tab2"></div>
</div><div class="list_bot"></div>
<?php
} else {
	echo '<div class="list_main"><div class="marquee bulletin" style="margin-top:15px;">'.__('No Records!').'</div><div class="list_bot"></div></div><div class="blankbar"></div>';
}
if($bulletin_type=='1'){
?>
<script type="text/javascript">
<!--
var stopscroll = false;
var scrollElem = document.getElementById("andyscroll<?php echo $randstr;?>");
var marqueesHeight = scrollElem.style.height;
scrollElem.onmouseover = new Function('stopscroll = true');
scrollElem.onmouseout  = new Function('stopscroll = false');
var preTop = 0;
var currentTop = 0;
var stoptime = 0;
var leftElem = document.getElementById("scrollmessage<?php echo $randstr;?>"); 
scrollElem.appendChild(leftElem.cloneNode(true));
init_srolltext();
function init_srolltext(){
	scrollElem.scrollTop = 0;
	setInterval('scrollUp()', 20);//的面的这个参数25, 是确定滚动速度的, 数值越小, 速度越快
}
function scrollUp(){
	if(stopscroll) return;
	currentTop += 2; //设为1, 可以实现间歇式的滚动; 设为2, 则是连续滚动
	if(currentTop == 19) {
		stoptime += 1;
		currentTop -= 1;
		if(stoptime == 180) {
			currentTop = 0;
			stoptime = 0;
		}
	}else{
		preTop = scrollElem.scrollTop;
		scrollElem.scrollTop += 1;
		if(preTop == scrollElem.scrollTop){
			scrollElem.scrollTop = 0;
			scrollElem.scrollTop += 1;
		}
	}
}
//-->
</script>
<?php 
} 
?>
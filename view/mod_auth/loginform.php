<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
$id_seed = Toolkit::randomStr();
$id_seed = preg_replace("/\d/",'',$id_seed);
$_randstr= Toolkit::randomStr(8);
?>
<script type="text/javascript" language="javascript">
<!--
function on_success_<?php echo $_randstr;?>(response) {
    var o_result = _eval_json(response);
    if (!o_result) {
        return on_failure(response);
    }
    
    var stat = document.getElementById("loginform_stat");
    if (o_result.result == "ERROR") {
        document.forms["loginform"].reset();
        reload_captcha("<?php echo $id_seed; ?>");
        
        stat.innerHTML = o_result.errmsg;
        return false;
    } else if (o_result.result == "OK") {
        stat.innerHTML = "<?php _e('OK, redirecting...'); ?>";
        window.location.href = o_result.forward;
    } else {
        return on_failure(response);
    }
}

function on_failure_<?php echo $_randstr;?>(response) {
    document.forms["loginform"].reset();
    reload_captcha("<?php echo $id_seed; ?>");
    
    document.getElementById("loginform_stat").innerHTML = "<?php _e('Request failed!'); ?>";
    return false;
}

function reload_captcha(<?php echo $id_seed; ?>) {
    var captcha = document.getElementById("login_captcha<?php echo $id_seed; ?>");
    if (captcha) {
        captcha.src = "captcha.php?s=" + random_str(6);
    }
}
//-->
</script>
<div class="loginblock">
<?php
$loginform = new Form('index.php', 'loginform', 'check_login_info');
$loginform->p_open('mod_auth', 'dologin', '_ajax');
?>

<div class="login_main">
	<div class="login_top"></div>
	<div class="login_con">
			<div class="login_blank"></div>
			<div class="login_left"><?php _e('Username'); ?>:</div><div class="login_right"><?php echo Html::input('text', 'login_user', '', '', $loginform, 'RequiredTextbox', __('Please input your username!')); ?></div>
			<div class="login_left"><?php _e('Password'); ?>:</div><div class="login_right"><?php echo Html::input('password', 'login_pwd', '', '', $loginform, 'RequiredTextbox',  __('Please input your password!')); ?></div>
			<?php if (SITE_LOGIN_VCODE) { ?>
			<div class="login_left"><?php _e('Security'); ?>:</div><div class="login_right"><div id="yzmshow"><img id="login_captcha" src="captcha.php" border="0" class="img_vmiddle"/></div><?php echo Html::input('text', 'rand_rs', '', 'size="2"', $loginform, 'RequiredTextbox', __('Please give me an answer!')); ?></div>
			<?php } ?>
			<div class="login_all"><a href="index.php?<?php echo Html::xuriquery('mod_user', 'reg_form'); ?>"><?php _e('Register user!'); ?></a><input name="s1" type="submit" id="s1" value="<?php _e('Login'); ?>" /><?php            
				echo Html::input('hidden', '_f', $forward_url);
				?></div>
			<span id="loginform_stat" class="status" style="display:none;"></span>
	</div>
	<!--div class="list_bot login_bot"></div-->
</div>
<div class="list_bot login_bot"></div>			
<!--div class="blankbar"></div-->		


<script type="text/javascript">
            	$("#rand_rs").focus(function(){
					
					$("#yzmshow").show();
					reload_captcha("<?php echo $id_seed;?>");
				});
				$("#rand_rs").blur(function(){
					$("#yzmshow").hide();
				});
</script>

<?php
$loginform->close();
$running_msg = __('Checking user...');
$custom_js = <<<JS
$("#loginform_stat").css({"display":"block"});
$("#loginform_stat").html("$running_msg");
_ajax_submit(thisForm, on_success_{$_randstr}, on_failure_{$_randstr});
return false;

JS;
$loginform->addCustValidationJs($custom_js);
$loginform->writeValidateJs();
?>
</div>
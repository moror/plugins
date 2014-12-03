<?php
/*
WP Moror Analyzer Page
*/

$wpma_status = "normal";

if(isset($_POST['wpma_update_options'])) {
	if($_POST['wpma_update_options'] == 'Y') {
		update_option("wp_moror_analyzer", maybe_serialize($_POST));
		$wpma_status = 'update_success';
	}
}

if(!class_exists('WPMororAnalyzerPage')) {
class WPMororAnalyzerPage {
function WPMororAnalyzer_Options_Page() {
	?>

	<div class="wrap">
	<div id="wpma-options">
	<div id="wpma-title"><h2><?php _e('WP Moror Analyzer', 'wp-moror-analyzer') ?></h2></div>
	<?php
	global $wpma_status;
	if($wpma_status == 'update_success')
		$message =__('Configuration updated', 'wp-moror-analyzer') . "<br />";
	else if($wpma_status == 'update_failed')
		$message =__('Error while saving options', 'wp-moror-analyzer') . "<br />";
	else
		$message = '';

	if($message != "") {
	?>
		<div class="updated"><strong><p><?php
		echo $message;
		?></p></strong></div><?php
	} ?>
	<div id="wpma-desc">
	<p><?php _e('This plugin add Moror analyzer code to your site.', 'wp-moror-analyzer'); ?></p>
	<p><?php _e('<b>Note</b>: The browser must support javascript.', 'wp-moror-analyzer'); ?></p>
	</div>

	<!--right-->
	<div class="postbox-container" style="float:right;width:300px;">
	<div class="metabox-holder">
	<div class="meta-box-sortables">

	<!--about-->
	<div id="wpma-about" class="postbox">
	<h3 class="hndle"><?php _e('About this plugin', 'wp-moror-analyzer'); ?></h3>
	<div class="inside"><ul>
	<li><a href="http://moror.ir"><?php _e('Moror analyzer', 'wp-moror-analyzer'); ?></a></li>
	</ul></div>
	</div>
	<!--about end-->
	<!--others-->
	<!--others end-->

	</div></div></div>
	<!--right end-->

	<!--left-->
	<div class="postbox-container" style="float:none;margin-right:320px;">
	<div class="metabox-holder">
	<div class="meta-box-sortabless">

	<!--setting-->
	<div id="wpma-setting" class="postbox" style="padding: 10px;">
	<h3 class="hndle"><?php _e('Settings', 'wp-moror-analyzer'); ?></h3>
	<?php $wp_moror_analyzer = maybe_unserialize(get_option('wp_moror_analyzer'));?>

	<form method="post" action="<?php echo get_bloginfo("wpurl"); ?>/wp-admin/options-general.php?page=wp-moror-analyzer">
	<input type="hidden" name="wpma_update_options" value="Y">

	<script type="text/javascript">
		prettifyOnLoadHead = function() {
			allways_load_yes.checked = true;
			allways_load_no.disabled = true;
		}

		prettifyOnLoadFooter = function() {
			allways_load_no.disabled = false;
		}
	</script>

	<table class="form-table" style="clear:none;">
		<tr>
		<th scope="row"><?php _e('Where the js files should be loaded?', 'wp-moror-analyzer'); ?></th>
		<td>
		<input type="radio" name="load_pos" value="head" onclick="prettifyOnLoadHead();" <?php if($wp_moror_analyzer['load_pos'] == 'head') { echo 'checked'; } ?> /><?php _e('Head', 'wp-moror-analyzer'); ?><br />
		<input type="radio" name="load_pos" value="footer" onclick="prettifyOnLoadFooter();" <?php if($wp_moror_analyzer['load_pos'] == 'footer') { echo 'checked'; } ?> /><?php _e('Footer', 'wp-moror-analyzer'); ?>
		</td>
		<td><?php _e('Head: Load the js files in the &lt;head&gt; section. If this is checked, the next option will be disabled.<br />Footer: Load the js files in the &lt;div id="footer"&gt; section.', 'wp-moror-analyzer'); ?></td>
		</tr>

		<tr>
		<th scope="row"><?php _e('Insert analyze code if user logged in?', 'wp-moror-analyzer'); ?></th>
		<td>
		<input type="radio" name="allow_user" id="allways_load_yes" value="yes" <?php if($wp_moror_analyzer['allow_user'] == 'yes') { echo 'checked'; } ?> /><?php _e('Yes', 'wp-moror-analyzer'); ?>
		<input type="radio" name="allow_user" id="allways_load_no" value="no" <?php if($wp_moror_analyzer['allow_user'] == 'no') { echo 'checked'; } ?> /><?php _e('No', 'wp-moror-analyzer'); ?>
		</td>
		<td><?php _e('Yes: Allway add analyze code to site, event when user is loggen in.
				<br />No: Do not add analyze code when admin is logged in.', 'wp-moror-analyzer'); ?></td>
		</tr>


		<tr>
		<th scope="row"><?php _e('Enter your analyze code', 'wp-moror-analyzer'); ?></th>
		<td colspan="2">
			<p><?php echo '<a target="_blank" href="http://moror.ir/panel/sitecode/'.urlencode(rtrim(preg_replace('/(https?:\/\/)([wW]{3}\.)?([^\\/]*)/', "$3", get_bloginfo("wpurl")), "/")).'">'.__('Get your analyze code form here', 'wp-moror-analyzer').'</a>'; ?></p>
			<textarea cols="75" rows="5" style="direction:ltr;text-align:left;" name="analyzer_code"><?php echo stripslashes($wp_moror_analyzer['analyzer_code']); ?></textarea>
		</td>
		</tr>
	</table>

	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Save Changes', 'wp-moror-analyzer'); ?>" />
	</p>
	</form>
	</div>
	<!--setting end-->

	<!--others-->
	<!--others end-->

	</div></div></div>
	<!--left end-->

	</div>
	</div>
	<?php
}

function WPMororAnalyzer_Menu() {
	add_options_page(__('WP Moror Analyzer'), __('WP Moror Analyzer'), 'manage_options', 'wp-moror-analyzer', array(__CLASS__,'WPMororAnalyzer_Options_Page'));
}

} // end of class WPMororAnalyzerPage
} // end of if(!class_exists('WPMororAnalyzerPage'))
?>

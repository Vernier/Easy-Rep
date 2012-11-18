<?php
/*
/¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\
|     » Copyright Notice «      |
|¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯| 
| » Easy Rep 1.0 © 2012         |
| » Released free of charge     |
| » Released under GNU licence  |
| » You may edit or modify      |
|   this plugin, however you    |
|   may not redistribute it.    |
| » You should have received a  |
|   copy of the GNU General     |
|   Public License along with   |
|   this program.  If not, see  |
|   http://www.gnu.org/licenses |
| » This notice must stay       |
|   intact for legal use.       |
|                               |
/¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯\
|    » Easy Rep 1.0 © 2012 «    |
\_______________________________/
 */
//Disallow Direct initialization For Security Reasons
if(!defined("IN_MYBB"))
{
	die("You Cannot Access This File Directly. Please Make Sure IN_MYBB Is Defined.");
}
if ($mybb->settings['enabled_easyrep'] == 1){
$page->add_breadcrumb_item("Easy Rep", "index.php?module=tools-easyrep");
$lang->load("easyrep");
$sub_tabs['positive_rep'] = array(
            'title' => $lang->positive_rep,
            'link' => "index.php?module=tools-easyrep&amp;action=addpositive",
            'description' => $lang->positive_rep_to_users
        );
$sub_tabs['neutral_rep'] = array(
            'title' => $lang->neutral_rep,
            'link' => "index.php?module=tools-easyrep&amp;action=addneutral",
            'description' => $lang->neutral_rep_to_users
        );
$sub_tabs['negative_rep'] = array(
            'title' => $lang->negative_rep,
            'link' => "index.php?module=tools-easyrep&amp;action=addnegative",
            'description' => $lang->negative_rep_to_users
        );

if (($mybb->input['action'] == "addpositive") || ($mybb->input['action'] == "")) {
	$page->output_header($lang->positive_rep_header);
	$page->output_nav_tabs($sub_tabs, 'positive_rep');
	$positiveform = new Form("index.php?module=tools-easyrep&amp;action=addpositive", "post", "easyrep");

			$positiveform_container = new FormContainer($lang->easyrep);
                  $positiveform_container->output_row($lang->positive_rep_to_which_uid, "", $positiveform->generate_text_box('positive_rec_uid', '', array('id' => 'positive_rec_uid')), 'positive_rec_uid');
                  $positiveform_container->output_row($lang->positive_rep_from_uid, "", $positiveform->generate_text_box('positive_from_uid', '', array('id' => 'positive_from_uid')), 'positive_from_uid');
                  $positiveform_container->output_row($lang->positive_rep_pid, "", $positiveform->generate_text_box('positive_rec_post', '', array('id' => 'positive_rec_post')), 'positive_rec_post');
                  $positiveform_container->output_row($lang->positive_rep_amount, "", $positiveform->generate_text_box('positive_rec_amount', '', array('id' => 'positive_rec_amount')), 'positive_rec_amount');
                  $positiveform_container->output_row($lang->positive_rep_unix, "", $positiveform->generate_text_box('positive_unix_time', '', array('id' => 'positive_unix_time',)), 'positive_unix_time');
                  $positiveform_container->output_row($lang->easyrep_comment, "", $positiveform->generate_text_area('positive_rec_comment', '', array('id' => 'positive_rec_comment')), 'positive_rec_comment');
                  $positiveform_container->output_row($lang->easyrep_interger_required);
			$positiveform_container->end();
			$positive_rec_uid = $db->escape_string($mybb->input['positive_rec_uid'], $numbersarray);
			$positive_from_uid = $db->escape_string($mybb->input['positive_from_uid'], $numbersarray);
			$positive_rec_post = $db->escape_string($mybb->input['positive_rec_post'], $numbersarray);
			$positive_rec_amount = $db->escape_string($mybb->input['positive_rec_amount'], $numbersarray);
			$positive_unix_time = $db->escape_string($mybb->input['positive_unix_time'], $numbersarray);
			$positive_rec_comment = $db->escape_string($mybb->input['positive_rec_comment'], $numbersarray);

						if((!empty($mybb->input['positive_rec_uid']) || $mybb->input['positive_rec_uid'] == '0') && (!empty($mybb->input['positive_from_uid']) || $mybb->input['positive_from_uid'] == '0') && (!empty($mybb->input['positive_rec_post']) || $mybb->input['positive_rec_post'] == '0') && (!empty($mybb->input['positive_rec_amount']) || $mybb->input['positive_rec_amount'] == '0') && (!empty($mybb->input['positive_unix_time']) || $mybb->input['positive_unix_time'] == '0') && (preg_match('/^\d+$/', $positive_rec_uid)) && (preg_match('/^\d+$/', $positive_from_uid)) && (preg_match('/^\d+$/', $positive_rec_post)) && (preg_match('/^\d+$/', $positive_rec_amount)) && (preg_match('/^\d+$/', $positive_unix_time)) && ($mybb->request_method == "post")){
				$db->query("INSERT INTO `".TABLE_PREFIX."reputation` VALUES (NULL, '$positive_rec_uid', '$positive_from_uid', '$positive_rec_post', '$positive_rec_amount', '$positive_unix_time', '$positive_rec_comment')");
			    flash_message($lang->easyrep_success, 'success');
			    log_admin_action(array('do'=>$lang->easyrep_added.$mybb->input['positive_rec_amount'].$lang->positive_rep_to_uid.$mybb->input['positive_rec_uid'].$lang->easyrep_with_unix_timestamp.$mybb->input['positive_unix_time']));
			    admin_redirect('index.php?module=tools-easyrep');
			}
			elseif($mybb->request_method == "post"){
				flash_message($lang->easyrep_error, 'error');
				admin_redirect('index.php?module=tools-easyrep&amp;action=addpositive');
				die();
			}

			$buttons = "";
			$buttons[] = $positiveform->generate_submit_button($lang->positive_rep);
			$positiveform->output_submit_wrapper($buttons);
			$positiveform->end();
			$page->output_footer();
}
if ($mybb->input['action'] == "addneutral") {
	$page->output_header($lang->neutral_rep_header);
	$page->output_nav_tabs($sub_tabs, 'neutral_rep');
	$neutralform = new Form("index.php?module=tools-easyrep&amp;action=addneutral", "post", "easyrep");

			$neutralform_container = new FormContainer($lang->easyrep);
                  $neutralform_container->output_row($lang->neutral_rep_to_which_uid, "", $neutralform->generate_text_box('neutral_rec_uid', '', array('id' => 'neutral_rec_uid')), 'neutral_rec_uid');
                  $neutralform_container->output_row($lang->neutral_rep_from_uid, "", $neutralform->generate_text_box('neutral_from_uid', '', array('id' => 'neutral_from_uid')), 'neutral_from_uid');
                  $neutralform_container->output_row($lang->neutral_rep_pid, "", $neutralform->generate_text_box('neutral_rec_post', '', array('id' => 'neutral_rec_post')), 'neutral_rec_post');
                  $neutralform_container->output_row($lang->neutral_rep_unix, "", $neutralform->generate_text_box('neutral_unix_time', '', array('id' => 'neutral_unix_time',)), 'neutral_unix_time');
             	  $neutralform_container->output_row($lang->easyrep_comment, "", $neutralform->generate_text_area('neutral_rec_comment', '', array('id' => 'neutral_rec_comment')), 'neutral_rec_comment');
                  $neutralform_container->output_row($lang->easyrep_interger_required);
			$neutralform_container->end();
			$neutral_rec_uid = $db->escape_string($mybb->input['neutral_rec_uid'], $numbersarray);
			$neutral_from_uid = $db->escape_string($mybb->input['neutral_from_uid'], $numbersarray);
			$neutral_rec_post = $db->escape_string($mybb->input['neutral_rec_post'], $numbersarray);
			$neutral_unix_time = $db->escape_string($mybb->input['neutral_unix_time'], $numbersarray);
			$neutral_rec_comment = $db->escape_string($mybb->input['neutral_rec_comment'], $numbersarray);

						if((!empty($mybb->input['neutral_rec_uid']) || $mybb->input['neutral_rec_uid'] == '0') && (!empty($mybb->input['neutral_from_uid']) || $mybb->input['neutral_from_uid'] == '0') && (!empty($mybb->input['neutral_rec_post']) || $mybb->input['neutral_rec_post'] == '0') && (!empty($mybb->input['neutral_unix_time']) || $mybb->input['neutral_unix_time'] == '0') && (preg_match('/^\d+$/', $neutral_rec_uid)) && (preg_match('/^\d+$/', $neutral_from_uid)) && (preg_match('/^\d+$/', $neutral_rec_post)) && (preg_match('/^\d+$/', $neutral_unix_time)) && ($mybb->request_method == "post")){
				$db->query("INSERT INTO `".TABLE_PREFIX."reputation` VALUES (NULL, '$neutral_rec_uid', '$neutral_from_uid', '-$neutral_rec_post', '0', '$neutral_unix_time', '$neutral_rec_comment')");
			    flash_message($lang->easyrep_success, 'success');
			    log_admin_action(array('do'=>$lang->easyrep_added.$lang->neutral_rep_to_uid.$mybb->input['neutral_rec_uid'].$lang->easyrep_with_unix_timestamp.$mybb->input['neutral_unix_time']));
			    admin_redirect('index.php?module=tools-easyrep');
			}
			elseif($mybb->request_method == "post"){
				flash_message($lang->easyrep_error, 'error');
				admin_redirect('index.php?module=tools-easyrep&amp;action=addneutral');
				die();
			}

			$buttons = "";
			$buttons[] = $neutralform->generate_submit_button($lang->neutral_rep);
			$neutralform->output_submit_wrapper($buttons);
			$neutralform->end();
			$page->output_footer();
}
if ($mybb->input['action'] == "addnegative") {
	$page->output_header($lang->negative_rep_header);
	$page->output_nav_tabs($sub_tabs, 'negative_rep');
	$negativeform = new Form("index.php?module=tools-easyrep&amp;action=addnegative", "post", "easyrep");

			$negativeform_container = new FormContainer($lang->easyrep);
                  $negativeform_container->output_row($lang->negative_rep_to_which_uid, "", $negativeform->generate_text_box('negative_rec_uid', '', array('id' => 'negative_rec_uid')), 'negative_rec_uid');
                  $negativeform_container->output_row($lang->negative_rep_from_uid, "", $negativeform->generate_text_box('negative_from_uid', '', array('id' => 'negative_from_uid')), 'negative_from_uid');
                  $negativeform_container->output_row($lang->negative_rep_pid, "", $negativeform->generate_text_box('negative_rec_post', '', array('id' => 'negative_rec_post')), 'negative_rec_post');
                  $negativeform_container->output_row($lang->negative_rep_amount, "", $negativeform->generate_text_box('negative_rec_amount', '', array('id' => 'negative_rec_amount')), 'negative_rec_amount');
                  $negativeform_container->output_row($lang->negative_rep_unix, "", $negativeform->generate_text_box('negative_unix_time', '', array('id' => 'negative_unix_time',)), 'negative_unix_time');
       	          $negativeform_container->output_row($lang->easyrep_comment, "", $negativeform->generate_text_area('negative_rec_comment', '', array('id' => 'negative_rec_comment')), 'negative_rec_comment');
                  $negativeform_container->output_row($lang->easyrep_interger_required);
			$negativeform_container->end();
			$negative_rec_uid = $db->escape_string($mybb->input['negative_rec_uid'], $numbersarray);
			$negative_from_uid = $db->escape_string($mybb->input['negative_from_uid'], $numbersarray);
			$negative_rec_post = $db->escape_string($mybb->input['negative_rec_post'], $numbersarray);
			$negative_rec_amount = $db->escape_string($mybb->input['negative_rec_amount'], $numbersarray);
			$negative_unix_time = $db->escape_string($mybb->input['negative_unix_time'], $numbersarray);
			$negative_rec_comment = $db->escape_string($mybb->input['negative_rec_comment'], $numbersarray);

						if((!empty($mybb->input['negative_rec_uid']) || $mybb->input['negative_rec_uid'] == '0') && (!empty($mybb->input['negative_from_uid']) || $mybb->input['negative_from_uid'] == '0') && (!empty($mybb->input['negative_rec_post']) || $mybb->input['negative_rec_post'] == '0') && (!empty($mybb->input['negative_rec_amount']) || $mybb->input['negative_rec_amount'] == '0') && (!empty($mybb->input['negative_unix_time']) || $mybb->input['negative_unix_time'] == '0') && (preg_match('/^\d+$/', $negative_rec_uid)) && (preg_match('/^\d+$/', $negative_from_uid)) && (preg_match('/^\d+$/', $negative_rec_post)) && (preg_match('/^\d+$/', $negative_rec_amount)) && (preg_match('/^\d+$/', $negative_unix_time)) && ($mybb->request_method == "post")){
				$db->query("INSERT INTO `".TABLE_PREFIX."reputation` VALUES (NULL, '$negative_rec_uid', '$negative_from_uid', '$negative_rec_post', '-$negative_rec_amount', '$negative_unix_time', '$negative_rec_comment')");
			    flash_message($lang->easyrep_success, 'success');
			    log_admin_action(array('do'=>$lang->easyrep_added.$mybb->input['negative_rec_amount'].$lang->negative_rep_to_uid.$mybb->input['negative_rec_uid'].$lang->easyrep_with_unix_timestamp.$mybb->input['negative_unix_time']));
			    admin_redirect('index.php?module=tools-easyrep');
			}
			elseif($mybb->request_method == "post"){
				flash_message($lang->easyrep_error, 'error');
				admin_redirect('index.php?module=tools-easyrep&amp;action=addnegative');
				die();
			}

			$buttons = "";
			$buttons[] = $negativeform->generate_submit_button($lang->negative_rep);
			$negativeform->output_submit_wrapper($buttons);
			$negativeform->end();
			$page->output_footer();
}
}
else {
	echo $lang->easyrep_disabled_error;
}

?>
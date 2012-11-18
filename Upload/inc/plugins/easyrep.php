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

//Hooks
$plugins->add_hook('admin_tools_menu', 'easyrep_admin_tools_menu');
$plugins->add_hook('admin_tools_action_handler', 'easyrep_admin_tools_action_handler');
$plugins->add_hook('admin_tools_permissions', 'easyrep_admin_tools_permissions');

//Info
function easyrep_info()
{
    global $lang;
    $lang->load('easyrep');
return array(
        "name"  => $lang->easyrep,
        "description"=> $lang->easyrep_description,
        "website"        => "http://community.mybb.com/user-55924.html",
        "author"        => "Vernier",
        "authorsite"    => "http://community.mybb.com/user-55924.html",
        "version"        => "1.0",
        "guid"             => "749131aec6e2b615f75c5ceb14e21ca3",
        "compatibility" => "16*"
    );
}


//Activate
function easyrep_activate()
{
    global $db, $lang;
    $lang->load('easyrep');
$easyrep_group = array(
        'gid'    => 'NULL',
        'name'  => 'easyrep',
        'title'      => $lang->easyrep,
        'description'    => $lang->easyrep_settinggroup_description,
        'disporder'    => "1",
        'isdefault'  => 'no',
    );
$db->insert_query('settinggroups', $easyrep_group);
 $gid = $db->insert_id();

 $easyrep_setting = array(
        'sid'            => 'NULL',
        'name'        => 'enabled_easyrep',
        'title'            => $lang->easyrep_setting_title,
        'description'    => $lang->easyrep_setting_description,
        'optionscode'    => 'yesno',
        'value'        => '1',
        'disporder'        => 1,
        'gid'            => intval($gid),
    );

$db->insert_query('settings', $easyrep_setting);
  rebuild_settings();

}

//Deactivate
function easyrep_deactivate()
{
  global $db;
 $db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name IN ('enabled_easyrep')");
    $db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='easyrep'");
rebuild_settings();
}


function easyrep_admin_tools_menu(&$sub_menu)
{
    global $mybb, $lang;
    $lang->load('easyrep');
    if ($mybb->settings['enabled_easyrep'] == 1){
    $sub_menu[] = array('id' => 'easyrep', 'title' => $lang->easyrep, 'link' => 'index.php?module=tools-easyrep');
}
}

function easyrep_admin_tools_action_handler(&$actions)
{
    $actions['easyrep'] = array('active' => 'easyrep', 'file' => 'easyrep.php');
}

function easyrep_admin_tools_permissions(&$admin_permissions)
{
    global $lang;
    $lang->load('easyrep');
    $admin_permissions['easyrep'] = $lang->easyrep_admin_permissions;
} 
?>
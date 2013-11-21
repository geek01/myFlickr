<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2008-02-28
// $Id: header.php,v 1.3 2008/05/14 01:22:58 tad Exp $
// ------------------------------------------------------------------------- //
include_once "../../mainfile.php";

//引入TadTools的函式庫
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";

//include_once "function.php";

//判斷是否對該模組有管理權限
$isAdmin=false;
if ($xoopsUser) {
    $module_id = $xoopsModule->getVar('mid');
    $isAdmin=$xoopsUser->isAdmin($module_id);
}

$interface_menu[_MD_MYFLICK_SMNAME1]="index.php";
$interface_menu[_MD_MYFLICK_SMNAME2]="sets.php";
$interface_menu[_MD_MYFLICK_SMNAME3]="collections.php";
$interface_menu[_MD_MYFLICK_SMNAME4]="favorite.php";


if($isAdmin){
  $interface_menu[_MD_MYFLICK_ADMIN]="admin/index.php";
}

?>
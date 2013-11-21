<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_MYFLICK_NAME;
$modversion['version'] = 1.00;
$modversion['description'] = _MI_MYFLICK_DESC;
$modversion['author'] = _MI_MYFLICK_AUTHOR;
$modversion['credits'] = _MI_MYFLICK_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = 'images/logo.png';
$modversion['dirname'] = basename(dirname(__FILE__));


//---模組狀態資訊---//
$modversion['release_date'] = '2013-11-20';
$modversion['module_website_url'] = '';
$modversion['module_website_name'] = '';
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = '';
$modversion['author_website_name'] = '';
$modversion['min_php']=5.2;
$modversion['min_xoops']='2.5';


//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = '';
$modversion ['paypal']['item_name'] = 'Donation : ';
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';


//---後台使用系統選單---//
$modversion['system_menu'] = 1;


//---模組資料表架構---//
//$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
//$modversion['tables'][0] = '';


//---後台管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';


//---前台主選單設定---//
$modversion['hasMain'] = 1;
//$modversion['sub'][1]['name'] = '';
//$modversion['sub'][1]['url'] = '';


//---模組自動功能---//
//$modversion['onInstall'] = "include/install.php";
//$modversion['onUpdate'] = "include/update.php";
//$modversion['onUninstall'] = "include/onUninstall.php";


//---偏好設定---//
$modversion['config'] = array();
$i=1;
$modversion['config'][$i]['name']	= 'userid';
$modversion['config'][$i]['title']	= '_MI_MYFLICK_USERID';
$modversion['config'][$i]['description']	= '_MI_MYFLICK_USERID_DESC';
$modversion['config'][$i]['formtype']	= 'textbox';
$modversion['config'][$i]['valuetype']	= 'text';
$modversion['config'][$i]['default']	= '';

$i++;
$modversion['config'][$i]['name']	= 'key';
$modversion['config'][$i]['title']	= '_MI_MYFLICK_KEY';
$modversion['config'][$i]['description']	= '_MI_MYFLICKR_KEY_DESC';
$modversion['config'][$i]['formtype']	= 'textbox';
$modversion['config'][$i]['valuetype']	= 'text';
$modversion['config'][$i]['default']	= '';

$i++;
$modversion['config'][$i]['name']	= 'number';
$modversion['config'][$i]['title']	= '_MI_MYFLICK_NUMBER';
$modversion['config'][$i]['description']	= '_MI_MYFLICKR_NUMBER_DESC';
$modversion['config'][$i]['formtype']	= 'textbox';
$modversion['config'][$i]['valuetype']	= 'text';
$modversion['config'][$i]['default']	= '30';


//---搜尋---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "搜尋函數名稱";

//---區塊設定---//
//$modversion['blocks'] = array();
//$modversion['blocks'][1]['file'] = "區塊檔.php";
//$modversion['blocks'][1]['name'] = 區塊名稱（常數）;
//$modversion['blocks'][1]['description'] = 區塊說明（常數）;
//$modversion['blocks'][1]['show_func'] = "執行區塊函數名稱";
//$modversion['blocks'][1]['template'] = "區塊樣板.html";
//$modversion['blocks'][1]['edit_func'] = "編輯區塊函數名稱";
//$modversion['blocks'][1]['options'] = "設定值1|設定值2";

//---樣板設定---//
$modversion['templates'] = array();
$i=1;
$modversion['templates'][$i]['file'] = 'myflickr_index_tpl.html';
$modversion['templates'][$i]['description'] = 'myflickr_index_tpl.html';


//---評論---//
//$modversion['hasComments'] = 1;
//$modversion['comments']['pageName'] = '單一頁面.php';
//$modversion['comments']['itemName'] = '主編號';

//---通知---//
//$modversion['hasNotification'] = 1;



?>

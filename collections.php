<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = set_bootstrap("myflickr_index_tpl_b3.html");
include_once XOOPS_ROOT_PATH . "/header.php";
/*-----------function區--------------*/

function show_collection_album($collection_id=""){
  global $xoopsModuleConfig, $xoopsTpl;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", XOOPS_ROOT_PATH."/uploads/myflickr_cache");

  $user_id=$xoopsModuleConfig['userid'];

  $collections = $f->collections_getTree($collection_id,$user_id);
  if ($f->getErrorCode() != NULL) {
    return "<div class='alert alert-error'>".$f->getErrorMsg()."</div>";
  }

  $photoColData = "";
    foreach($collections['collections']['collection'] as $collection)
    {
        $photoColData .="
        <div class='col-lg-3 col-sm-4 col-xs-6'>
          <div class='sets thumbnail'>
          <a href='collections.php?op=col_sets&col={$collection['id']}'><img src='{$collection['iconlarge']}' class='album-primary' /><div class='sets-title text-center'>{$collection['title']}</div></a>
          </div>
        </div>
        ";
    }
    $main="
    <div class='myflickr'>
      <div class='page-header'><h2>"._MD_MYFLICK_SMNAME3."</h2></div>
        <div class='row'>
          {$photoColData}
        </div>
    </div>
    ";

  $xoopsTpl->assign( "main" , $main);
}

function show_collection_sets($collection_id){
  global $xoopsModuleConfig, $xoopsTpl;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", XOOPS_ROOT_PATH."/uploads/myflickr_cache");

  $user_id=$xoopsModuleConfig['userid'];

  $collections = $f->collections_getTree($collection_id,$user_id);
  if ($f->getErrorCode() != NULL) {
    return "<div class='alert alert-error'>".$f->getErrorMsg()."</div>";
  }

  $photoSetData = "";
    foreach($collections['collections']['collection'] as $collection)
    {
      $colTitle=$collection['title'];
      foreach ($collection['set'] as $set)
      {
        $info = $f->photosets_getInfo($set['id']);
        $photoy=$info;
        $photoy['id'] = $info['primary'];
        $upday= date("Y-m-d" ,$info['date_update']);
        $photoSetData .="
        <div class='col-lg-3 col-sm-4 col-xs-6'>
          <div class='sets thumbnail'>
            <a href='photo.php?sid={$set['id']}'><img src='" . $f->buildPhotoURL($photoy, "small") . "' class='album-primary' /><div class='sets-title'>".$set['title']."</div></a>
            <div class='sets-info'>
              <span class='glyphicon glyphicon-picture'></span> ".$info['photos']." <span class='glyphicon glyphicon-eye-open'></span> ".$info['count_views']." <span class='glyphicon glyphicon-time'></span> ".$upday."
            </div>
          </div>
        </div>
        ";
      }
    }
    $main="
    <div class='myflickr'>
      <div class='page-header'><h2>{$colTitle}</h2></div>
        <div class='row'>
          {$photoSetData}
        </div>
    </div>
    ";

  $xoopsTpl->assign( "main" , $main);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path( '/modules/system/include/functions.php' );
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$col = system_CleanVars($_REQUEST, 'col', '', 'int');
$page = system_CleanVars($_REQUEST, 'page', 1, 'int');

switch($op){

  case "col_sets":
  show_collection_sets($col);
  break;

	default:
	show_collection_album();
	break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH.'/footer.php';
?>
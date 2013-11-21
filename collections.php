<?php
/*-----------引入檔案區--------------*/
include "header.php";
include XOOPS_ROOT_PATH."/header.php";
$xoopsOption['template_main'] = "myflickr_index_tpl.html";
/*-----------function區--------------*/

function show_collection_album($collection_id=""){
  global $xoopsModuleConfig;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", "../uploads/myflickr_cache");

  $user_id=$xoopsModuleConfig['userid'];

  $collections = $f->collections_getTree($collection_id,$user_id);

  $photoColData = "";
    foreach($collections['collections']['collection'] as $collection)
    {
        $photoColData .="
        <div class='sets'><a href='collections.php?op=col_sets&col={$collection['id']}'><img src='{$collection['iconlarge']}' class='album-primary' /><div class='sets-title'>{$collection['title']}</div></a>
        </div>
        ";
    }
    $main="
    <div class='container-fluid myflickr'>
      <div class='page-header'><h2>"._MD_MYFLICK_SMNAME3."</h2></div>
        <div class='row-fluid'>
          {$photoColData}
        </div>
    </div>
    ";

  return $main;
}

function show_collection_sets($collection_id){
  global $xoopsModuleConfig;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", "../uploads/myflickr_cache");

  $user_id=$xoopsModuleConfig['userid'];

  $collections = $f->collections_getTree($collection_id,$user_id);

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
        <div class='sets'><a href='photo.php?sid={$set['id']}'><img src='" . $f->buildPhotoURL($photoy, "small") . "' class='album-primary' /><div class='sets-title'>".$set['title']."</div></a>
        <div class='sets-info'><span><i class='icon-picture'></i> ".$info['photos']."</span><span><i class='icon-eye-open'></i> ".$info['count_views']."</span><span><i class='icon-time'></i> ".$upday."</span></div></div>
        ";
      }
    }
    $main="
    <div class='container-fluid myflickr'>
      <div class='page-header'><h2>{$colTitle}</h2></div>
        <div class='row-fluid'>
          {$photoSetData}
        </div>
    </div>
    ";

  return $main;
}

/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$col = isset($_GET['col'])?$_GET['col'] : "";
$page = isset($_GET['page'])?$_GET['page'] : 1;

$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "css" , "<link rel='stylesheet' type='text/css' media='screen' href='module.css' />") ;

switch($op){

  case "col_sets":
  $main=show_collection_sets($col);
  break;

	default:
	$main=show_collection_album();
	break;
}

/*-----------秀出結果區--------------*/
echo $main;
include_once XOOPS_ROOT_PATH.'/footer.php';
?>
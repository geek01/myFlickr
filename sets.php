<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = set_bootstrap("myflickr_index_tpl_b3.html");
include_once XOOPS_ROOT_PATH . "/header.php";
/*-----------function區--------------*/

function show_all_sets($page){
  global $xoopsModuleConfig, $xoopsTpl;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", XOOPS_ROOT_PATH."/uploads/myflickr_cache");

  $user_id=$xoopsModuleConfig['userid'];
  $per_page=$xoopsModuleConfig['number'];

    $sets=$f->photosets_getList($user_id, $page, $per_page,"url_s");
    if ($f->getErrorCode() != NULL) {
      return "<div class='alert alert-error'>".$f->getErrorMsg()."</div>";
    }
    $pages = $sets['pages'];
    $total = $sets['total'];
    $perpage = $sets['perpage'];

      /*foreach ($sets['photoset'] as $set)
      {
        $info = $f->photosets_getInfo($set['id']);
        $photoy=$info;
        $photoy['id'] = $info['primary'];
        $upday= date("Y-m-d" ,$info['date_update']);
        $photoSetData .="
        <div class='sets'><a href='photo.php?sid=$set[id]'><img src='" . $f->buildPhotoURL($photoy, "small") . "' class='album-primary' /><div class='sets-title'>".$set['title']."</div></a>
        <div class='sets-info'><span><i class='icon-picture'></i> ".$info['photos']."</span><span><i class='icon-eye-open'></i> ".$info['count_views']."</span><span><i class='icon-time'></i> ".$upday."</span></div></div>
        ";
      }*/
      
      foreach ($sets['photoset'] as $set)
      {
        $upday= date("Y-m-d" ,$set['date_update']);
        $photoSetData .="
        <div class='col-lg-3 col-sm-4 col-xs-6'>
          <div class='sets thumbnail'>
            <a href='photo.php?sid={$set['id']}'><img src='".$set['primary_photo_extras']['url_s']."' class='album-primary' />
              <div class='sets-title'>".$set['title']['_content']."</div>
            </a>
            <div class='sets-info'>
              <span class='glyphicon glyphicon-picture'></span> ".$set['photos']." <span class='glyphicon glyphicon-eye-open'></span> ".$set['count_views']." <span class='glyphicon glyphicon-time'></span> ".$upday."
            </div>
          </div>
        </div>
        ";
      }

    $pLimit = 10;
    $pCurrent = ceil($page / $pLimit);
    $pTotal = ceil($total / $perpage);

    $i = ($pCurrent * $pLimit) - ($pLimit - 1);

    $back = $page - 1;
    $next = $page + 1;

    if($page > 1) {
      $back_pr = "<li><a href='?page={$back}'>&laquo; "._MD_MYFLICK_PREVPAGE."</a></li>";
    }else{
      $back_pr = "<li class='disabled'><a href='javascript: void(0)'>&laquo; "._MD_MYFLICK_PREVPAGE."</a></li>";
    }

    while ( $i <= $pages && $i <= ($pCurrent * $pLimit) ) {
      if ($i == $page) {
        $pagenum = "{$pagenum}<li class='active'><a href='javascript: void(0)'>{$i}</a></li>";
      } else {
        $pagenum .= "<li><a href='?page={$i}'>{$i}</a></li>";
      }
    $i++;
    }
    
    if($page != $pages) {
      $next_pr = "<li><a href='?page={$next}'>"._MD_MYFLICK_NEXTPAGE." &raquo;</a></li>";
    }else{
      $next_pr = "<li class='disabled'><a href='javascript: void(0)'>"._MD_MYFLICK_NEXTPAGE." &raquo;</a></li>";
    }

    if(($page - $pLimit) > 1){
      $back_mr = "<li class='disabled'><a>...</a></li>";
    }

    if(($page + $pLimit) < $pTotal){
      $next_mr = "<li class='disabled'><a>...</a></li>";
    }

    $pagenation="
    <div class='text-center'>
     <ul class='pagination'>
       {$back_pr}{$back_mr}{$pagenum}{$next_mr}{$next_pr}
     </ul>
    </div>";

    $main="
    <div class='myflickr'>
      <div class='page-header'><h2>"._MD_MYFLICK_SMNAME2."</h2></div>
        <div class='row'>
          {$photoSetData}
        </div>
      <div class='row'>{$pagenation}</div>
    </div>
    ";

  $xoopsTpl->assign( "main" , $main);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path( '/modules/system/include/functions.php' );
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$page = system_CleanVars($_REQUEST, 'page', 1, 'int');

switch($op){

	default:
	show_all_sets($page);
	break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH.'/footer.php';
?>

<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = set_bootstrap("myflickr_index_tpl_b3.html");
include_once XOOPS_ROOT_PATH . "/header.php";
/*-----------function區--------------*/

function show_photo($photoset_id,$page){
  global $xoopsModuleConfig, $xoopsTpl;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", XOOPS_ROOT_PATH."/uploads/myflickr_cache");

  //$user_id=$xoopsModuleConfig['xflickr_userid'];
  $per_page=$xoopsModuleConfig['number'];

    $photos = $f->photosets_getPhotos($photoset_id, 'original_format', NULL, $per_page, $page);
    $info = $f->photosets_getInfo($photoset_id);
    if ($f->getErrorCode() != NULL) {
      return "<div class='alert alert-error'>".$f->getErrorMsg()."</div>";
    }
    $pages = $photos['photoset']['pages'];
    $total = $photos['photoset']['total'];
    $perpage = $photos['photoset']['perpage'];

      foreach ($photos['photoset']['photo'] as $photo)
      {
        $photoData .="
        <div class='col-lg-3 col-sm-4 col-xs-6 photo'>
          <a href='".$f->buildPhotoURL($photo, 'large')."' title='{$photo['title']}' class='fancybox-thumb thumbnail' rel='gallery1'>
          <img data-src='holder.js' alt='{$photo['title']}' src='".$f->buildPhotoURL($photo, 'small')."' />
          <div class='title'>{$photo['title']}</div>
          </a>
        </div>";
      }

    $pLimit = 10;
    $pCurrent = ceil($page / $pLimit);
    $pTotal = ceil($total / $perpage);

    $i = ($pCurrent * $pLimit) - ($pLimit - 1);

    $back = $page - 1;
    $next = $page + 1;

    if($page > 1) {
      $back_pr = "<li><a href='?sid={$photoset_id}&page={$back}'>&laquo; "._MD_MYFLICK_PREVPAGE."</a></li>";
    }else{
      $back_pr = "<li class='disabled'><a href='javascript: void(0)'>&laquo; "._MD_MYFLICK_PREVPAGE."</a></li>";
    }

    while ( $i <= $pages && $i <= ($pCurrent * $pLimit) ) {
      if ($i == $page) {
        $pagenum = "{$pagenum}<li class='active'><a href='javascript: void(0)'>{$i}</a></li>";
      } else {
        $pagenum .= "<li><a href='?sid={$photoset_id}&page={$i}'>{$i}</a></li>";
      }
    $i++;
    }
    
    if($page != $pages) {
      $next_pr = "<li><a href='?sid={$photoset_id}&page={$next}'>"._MD_MYFLICK_NEXTPAGE." &raquo;</a></li>";
    }else{
      $next_pr = "<li class='disabled'><a href='javascript: void(0)'>"._MD_MYFLICK_NEXTPAGE." &raquo;</a></li>";
    }

    if(($page - $pLimit) > 1){
      $back_mr = "<li class='disabled'><a>...</a></li>";
    }

    if(($page + $pLimit) < $pTotal){
      $next_mr = "<li class='disabled'><a>...</a></li>";
    }

    //$pagecount="<li class='disabled'><a href='javascript: void(0)'>共{$pTotal}頁，第{$page}頁</a></li>";

    $pagenation="
    <div class='text-center'>
     <ul class='pagination'>
       {$back_pr}{$back_mr}{$pagenum}{$next_mr}{$next_pr}
     </ul>
    </div>";

    $jquery=get_jquery();

    $main="
    $jquery
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/fancyBox/source/jquery.fancybox.css' type='text/css' media='screen' />
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancyBox/source/jquery.fancybox.pack.js'></script>
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-buttons.css' type='text/css' media='screen' />
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-buttons.js'></script>
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-media.js'></script>
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-thumbs.css' type='text/css' media='screen' />
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-thumbs.js'></script>
    <script type='text/javascript'>
    $(document).ready(function() {
      $('.fancybox-thumb').fancybox({
        prevEffect  : 'fade',
        nextEffect  : 'fade',
        helpers : {
          title : {
            type: 'inside'
          },
          buttons : {},
          thumbs  : {
            width : 50,
            height  : 50
          }
        }
      });
    });
    </script>
    <div class='myflickr'>
      <div class='page-header'><h2>{$info['title']['_content']}</h2></div>
        <div class='row'>
          <div class='thumbnails clearfix'>
            {$photoData}
          </div>
        </div>
      <div class='row'>{$pagenation}</div>
    </div>
    ";

  $xoopsTpl->assign( "main" , $main);
}

function get_sets_id(){
  global $xoopsModuleConfig;
  require_once "class/phpFlickr/phpFlickr.php";

  $f = new phpFlickr($xoopsModuleConfig['key']);
  $f->enableCache("fs", XOOPS_ROOT_PATH."/uploads/myflickr_cache");

  $user_id=$xoopsModuleConfig['userid'];

  $sets=$f->photosets_getList($user_id, NULL);

  foreach ($sets['photoset'] as $set)
  {
    $main[]=$set['id'];
  }

  return $main;
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path( '/modules/system/include/functions.php' );
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$sid = system_CleanVars($_REQUEST, 'sid', '', 'int');
$page = system_CleanVars($_REQUEST, 'page', 1, 'int');

switch($op){

	default:
  $sets_id=get_sets_id();
  if (!in_array($sid, $sets_id)) {
    redirect_header("index.php",3,_MD_MYFLICK_SIDERROR);
  }
	show_photo($sid,$page);
	break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH.'/footer.php';
?>
<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = set_bootstrap("myflickr_index_tpl_b3.html");
include_once XOOPS_ROOT_PATH . "/header.php";
/*-----------function區--------------*/

function show_public_photo($page){
  global $xoopsModuleConfig, $xoopsTpl;
  require_once "class/phpFlickr/phpFlickr.php";

	$f = new phpFlickr($xoopsModuleConfig['key']);
	$f->enableCache("fs", XOOPS_ROOT_PATH."/uploads/myflickr_cache");

	$user_id=$xoopsModuleConfig['userid'];
	$per_page=$xoopsModuleConfig['number'];

    $photos = $f->people_getPublicPhotos($user_id, NULL, 'original_format', $per_page ,$page);
    if ($f->getErrorCode() != NULL) {
      return "<div class='alert alert-error'>".$f->getErrorMsg()."</div>";
    }
    $pages = $photos['photos']['pages'];
    $total = $photos['photos']['total'];
    $perpage = $photos['photos']['perpage'];

      foreach ($photos['photos']['photo'] as $photo)
      {
        $photoData .="
        <div class='col-lg-3 col-sm-4 col-xs-6 photo'>
          <a href='".$f->buildPhotoURL($photo, 'large')."' title='{$photo['title']}' class='fancybox-thumb thumbnail' rel='gallery1'>
          <img data-src='holder.js' alt='{$photo['title']}' src='".$f->buildPhotoURL($photo, "small")."' />
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
    } //end while
    

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
          buttons : {}
        }
      });
    });
    </script>
    <div class='myflickr'>
      <div class='page-header'><h2>"._MD_MYFLICK_SMNAME1."</h2></div>
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

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path( '/modules/system/include/functions.php' );
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$page = system_CleanVars($_REQUEST, 'page', 1, 'int');

switch($op){

	default:
  show_public_photo($page);
	break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu));

include_once XOOPS_ROOT_PATH.'/footer.php';
?>
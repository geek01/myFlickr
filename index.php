<?php
/*-----------引入檔案區--------------*/
include "header.php";
include XOOPS_ROOT_PATH."/header.php";
$xoopsOption['template_main'] = "myflickr_index_tpl.html";
/*-----------function區--------------*/

function show_public_photo($page){
  global $xoopsModuleConfig;
  require_once "class/phpFlickr/phpFlickr.php";

	$f = new phpFlickr($xoopsModuleConfig['key']);
	$f->enableCache("fs", "../uploads/myflickr_cache");

	$user_id=$xoopsModuleConfig['userid'];
	$per_page=$xoopsModuleConfig['number'];

    $photos = $f->people_getPublicPhotos($user_id, NULL, 'original_format', $per_page ,$page);
    $pages = $photos['photos']['pages'];
    $total = $photos['photos']['total'];
    $perpage = $photos['photos']['perpage'];

      foreach ($photos['photos']['photo'] as $photo)
      {
        $photoData .="
        <div class='photo'>
          <a href='".$f->buildPhotoURL($photo, 'large')."' title='{$photo['title']}' class='fancybox-thumb thumbnail' rel='gallery1'>
          <img data-src='holder.js' alt='{$photo['title']}' src='".$f->buildPhotoURL($photo, "small")."' />
          <span class='title'>{$photo['title']}</span>
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
      $back_pr = "<li><a href='?page=$back'>&laquo; "._MD_MYFLICK_PREVPAGE."</a></li>";
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
      $next_pr = "<li><a href='?page=$next'>"._MD_MYFLICK_NEXTPAGE." &raquo;</a></li>";
    }else{
      $next_pr = "<li class='disabled'><a href='javascript: void(0)'>"._MD_MYFLICK_NEXTPAGE." &raquo;</a></li>";
    }

    if(($page - $pLimit) > 1){
      $back_mr = "<li class='disabled'><a href='javascript: void(0)'>...</a></li>";
    }

    if(($page + $pLimit) < $pTotal){
      $next_mr = "<li class='disabled'><a href='javascript: void(0)'>...</a></li>";
    }

    $pagenation="
    <div class='pagination'>
     <ul>
       {$back_pr}{$back_mr}{$pagenum}{$next_mr}{$next_pr}
     </ul>
    </div>";

    $jquery=get_jquery();

    $main="
    $jquery
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/fancybox/source/jquery.fancybox.css' type='text/css' media='screen' />
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancybox/source/jquery.fancybox.pack.js'></script>
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/fancybox/source/helpers/jquery.fancybox-buttons.css' type='text/css' media='screen' />
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancybox/source/helpers/jquery.fancybox-buttons.js'></script>
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancybox/source/helpers/jquery.fancybox-media.js'></script>
    <link rel='stylesheet' href='".XOOPS_URL."/modules/tadtools/fancybox/source/helpers/jquery.fancybox-thumbs.css' type='text/css' media='screen' />
    <script type='text/javascript' src='".XOOPS_URL."/modules/tadtools/fancybox/source/helpers/jquery.fancybox-thumbs.js'></script>
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
    <div class='container-fluid myflickr'>
      <div class='page-header'><h2>"._MD_MYFLICK_SMNAME1."</h2></div>
        <div class='row-fluid'>
          <div class='thumbnails'>
            {$photoData}
          </div>
        </div>
      {$pagenation}
    </div>
    ";

	return $main;
}

/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$page = isset($_GET['page'])?$_GET['page'] : 1;

$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "css" , "<link rel='stylesheet' type='text/css' media='screen' href='module.css' />") ;

switch($op){

	default:
	$main=show_public_photo($page);
	break;
}

/*-----------秀出結果區--------------*/
echo $main;
include_once XOOPS_ROOT_PATH.'/footer.php';
?>
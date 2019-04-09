<div class="home-sidebar-item sidebar-item ">
<div class="home-item-title">
        <h2>NIEUWS (NU.nl)</h2>
        <a href="" class="item-close">&nbsp;</a>
</div>
<div class="sidebar-item-body">















        <ul id="ourNewsFeed">
             
             <?php

			 $link="http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=5&q=".urlencode("http://www.nu.nl/rss");
			 
			// echo $link;
$url = file_get_contents($link);


//echo $url;
 $content = json_decode($url,true); 
 // print_r($content);
  

$i=0;
  foreach($content["responseData"]["feed"]['entries'] as $key => $val) {

  
  if($i<1){
  $class="active";
  }
  else{
  
  $class="";
  }
  
  $i++;
  
  echo ' <li class="'.$class.'">
                        <a href="" class="sidebar-item-header">
                                <h3>'.$val['title'].'
                                </h3>
                               <!-- <p>'.$val['contentSnippet'].'</p>-->
                        </a>

                        <div class="sidebar-item-content">
                                '.$val['content'].' <a href="'.$val['link'].'" target="_blank">Lees verder..</a>
                        </div>
                </li>';
     
  }
  


?>
             
                <!----  <li class="active">
                        <a href="" class="sidebar-item-header">
                                <h3>DOUWE EGBERT EN MONDELEZ 
                                        FUSEREN
                                </h3>
                                <p>Nieuw bedrijf gaat Jacobs Douwe Egberts heten</p>
                        </a>

                        <div class="sidebar-item-content">
                                Koffie- en theemerk DE Master Blenders 1753 
                                (Douwe Egberts) en het Amerikaanse voedselco-
                                nglomeraat Mondelez International voegen hun 
                                koffieactiviteiten samen.Douwe Egberts en Mond-
                                elez fuseren Dat maken de twee ondernemingen 
                                woensdag bekend. Door de fusie ontstaat een 
                                koffieproducent met een jaaromzet van ruim 7 
                                miljard dollar (5 miljard euro). <a href="">Lees verder..</a>
                        </div>
                </li>
                <li>
                        <a href="" class="sidebar-item-header">
                                <h3>DOUWE EGBERT EN MONDELEZ 
                                        FUSEREN
                                </h3>
                                <p>Nieuw bedrijf gaat Jacobs Douwe Egberts heten</p>
                        </a>

                        <div class="sidebar-item-content">
                                Koffie- en theemerk DE Master Blenders 1753 
                                (Douwe Egberts) en het Amerikaanse voedselco-
                                nglomeraat Mondelez International voegen hun 
                                koffieactiviteiten samen.Douwe Egberts en Mond-
                                elez fuseren Dat maken de twee ondernemingen 
                                woensdag bekend. Door de fusie ontstaat een 
                                koffieproducent met een jaaromzet van ruim 7 
                                miljard dollar (5 miljard euro). <a href="">Lees verder..</a>
                        </div>
                </li>
                <li>
                        <a href="" class="sidebar-item-header">
                                <h3>DOUWE EGBERT EN MONDELEZ 
                                        FUSEREN
                                </h3>
                                <p>Nieuw bedrijf gaat Jacobs Douwe Egberts heten</p>
                        </a>

                        <div class="sidebar-item-content">
                                Koffie- en theemerk DE Master Blenders 1753 
                                (Douwe Egberts) en het Amerikaanse voedselco-
                                nglomeraat Mondelez International voegen hun 
                                koffieactiviteiten samen.Douwe Egberts en Mond-
                                elez fuseren Dat maken de twee ondernemingen 
                                woensdag bekend. Door de fusie ontstaat een 
                                koffieproducent met een jaaromzet van ruim 7 
                                miljard dollar (5 miljard euro). <a href="">Lees verder..</a>
                        </div>
                </li>----->
        </ul>
</div>
</div>		
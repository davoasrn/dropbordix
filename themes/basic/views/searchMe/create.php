<?php 

$this->renderPartial('_searchMe', 
           array( 
           'model'=>$model,               
	    	'url' =>array("searchMe/create")
            )
        ); ?>
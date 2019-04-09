<?php $this->renderPartial('_searchMe', 
            array(
            'users'=>$users,
            'announcement'=>$announcement,
            'auto_detail'=>$auto_detail,
                
	    	'url' =>array("site/searchMe")
            )
        ); ?>
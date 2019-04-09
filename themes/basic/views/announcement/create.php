<?php $this->renderPartial('_form', 
            array(
                'model'=>$model,
                'auto_detail' => $auto_detail,
                'announce_paid' => $announce_paid,
                'users' => $user,
                'files' => $files,
                'checkAction' => 'announcement/check',
		'url' =>array("announcement/create")
            )
        ); ?>
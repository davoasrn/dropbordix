<?php $this->renderPartial('_form', 
            array(
                'model'=>$model,
                'auto_detail' => $auto_detail,
                'announce_paid' => $announce_paid,
                'users' => $users,
                'files' => $files,
				'checkAction' => 'announcement/checkNotLogined',
				'url' =>array("announcement/createNotLogined")
            )
        ); ?>
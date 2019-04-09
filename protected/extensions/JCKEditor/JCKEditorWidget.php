<?php

class JCKEditorWidget extends CWidget {

	public $path;
	public $width = '100%';
	public $height = '375px';
	public $config = array();
	public $id;
	public $toolbar;
	
	public function run() {
		$config_json = CJSON::encode(array_merge(array('width'=>$this->width, 'height'=>$this->height, 'toolbar'=>$this->toolbar), $this->config));
		Yii::app()->clientScript->registerScript('JCKEditorWidgetPath', 'window.CKEDITOR_BASEPATH = "'.$this->path.'";', SmartClientScript::POS_HEAD_BEGIN);
		Yii::app()->clientScript->registerScriptFile($this->path.'ckeditor.js');
		Yii::app()->clientScript->registerScript('JCKEditorWidgetReplace_'.$this->id, '
			var instance = CKEDITOR.instances["'.$this->id.'"];
			if (instance) { CKEDITOR.remove(instance); }
			CKEDITOR.replace("'.$this->id.'", '.$config_json.');
		');
	}

}

?>
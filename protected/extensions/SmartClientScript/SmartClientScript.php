<?php

class SmartClientScript extends CClientScript {

	//Включить NLSClientScript
	public $NLSClientScript = false;

	// Скрипт появляется в НЕAD до скриптов с POS_HEAD
	const POS_HEAD_BEGIN = 5;
	
	// NLS v5.0
	public $includePattern = 'null';//default: 'null'
	public $excludePattern = 'null';//default: 'null'

	//Вставляет скрипты в HEAD
	public function renderHead(&$output)
	{
		if($this->NLSClientScript) $this->_putnlscode();
	
		$html='';
		foreach($this->metaTags as $meta)
			$html.=CHtml::metaTag($meta['content'],null,null,$meta)."\n";
		foreach($this->linkTags as $link)
			$html.=CHtml::linkTag(null,null,null,null,$link)."\n";
		foreach($this->cssFiles as $url=>$media)
			$html.=CHtml::cssFile($url,$media)."\n";
		foreach($this->css as $css)
			$html.=CHtml::css($css[0],$css[1])."\n";
		if($this->enableJavaScript)
		{
			if(isset($this->scriptFiles[self::POS_HEAD_BEGIN]))
			{
				foreach($this->scriptFiles[self::POS_HEAD_BEGIN] as $scriptFile)
					$html.=CHtml::scriptFile($scriptFile)."\n";
			}
			if(isset($this->scripts[self::POS_HEAD_BEGIN]))
				$html.=CHtml::script(implode("\n",$this->scripts[self::POS_HEAD_BEGIN]))."\n";
			
			if(isset($this->scriptFiles[self::POS_HEAD]))
			{
				foreach($this->scriptFiles[self::POS_HEAD] as $scriptFile)
					$html.=CHtml::scriptFile($scriptFile)."\n";
			}
			if(isset($this->scripts[self::POS_HEAD]))
				$html.=CHtml::script(implode("\n",$this->scripts[self::POS_HEAD]))."\n";
		}

		if($html!=='')
		{
			$count=0;
			$output=preg_replace('/(<title\b[^>]*>|<\\/head\s*>)/is','<###head###>$1',$output,1,$count);
			if($count)
				$output=str_replace('<###head###>',$html,$output);
			else
				$output=$html.$output;
		}
	}
	
	//NLS v5.0
	protected function _putnlscode() {
		if (Yii::app()->request->isAjaxRequest)
			return;
		//we need jquery
		$this->registerCoreScript('jquery');
		//Minified code
		$this->registerScript('fixDuplicateResources',
			'(function($){var cont=($.browser.msie&&parseInt($.browser.version)<=7)?document.createElement("div"):null,excludePattern='.$this->excludePattern.',includePattern='.$this->includePattern.';$.nlsc={resMap:{},normUrl:function(url){if(!url)return null;if(cont){cont.innerHTML="<a href=\""+url+"\"></a>";url=cont.firstChild.href;}if(excludePattern&&url.match(excludePattern))return null;if(includePattern&&!url.match(includePattern))return null;return url.replace(/\?*(_=\d+)?$/g,"");},fetchMap:function(){for(var url,i=0,res=$(document).find("script[src]");i<res.length;i++){if(!(url=this.normUrl(res[i].src?res[i].src:res[i].href)))continue;this.resMap[url]=1;}}};var c={global:true,beforeSend:function(xhr,opt){if(opt.dataType!="script")return true;if(!$.nlsc.fetched){$.nlsc.fetched=1;$.nlsc.fetchMap();}var url=$.nlsc.normUrl(opt.url);if(!url)return true;if($.nlsc.resMap[url])return false;$.nlsc.resMap[url]=1;return true;}};if($.browser.msie)c.dataFilter=function(data,type){if(type&&type!="html"&&type!="text")return data;return data.replace(/(<script[^>]+)defer(=[^\s>]*)?/ig,"$1");};$.ajaxSetup(c);})(jQuery);', 
			CClientScript::POS_HEAD
		);
	}
}

?>
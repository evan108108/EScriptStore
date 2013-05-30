<?php
class CMeInFile extends CWidget
{
	public static $script_contents = array();
	public static $filename_cache_buster = '';

	public $filename;

	public function init()
	{	
		$this->setScriptFileName();
		$this->controller->beginClip( get_class($this) );
	}

	public function run()
	{
		$this->controller->endClip();
		$content = $this->controller->clips[(get_class($this))];

		CMeInFile::$script_contents = CMap::mergeArray(
			CMeInFile::$script_contents,
			array( get_class($this) => array(sha1($content) => $content) )
		);

		$this->registerCSS();
		$this->registerJS();

		$this->cacheScript(get_class($this));
	}

	public function setScriptFileName()
	{
		if(empty($this->filename)) {
			$this->filename = $this->getDefaultScriptFileName();
		}
	}

	public function getDefaultScriptFileName()
	{
		if(YII_DEBUG && empty(CMeInFile::$filename_cache_buster)) {
			CMeInFile::$filename_cache_buster = '-' . sha1(rand(10000, 999999999999));
		}

		return sha1(Yii::app()->request->requestUri) . CMeInFile::$filename_cache_buster . '.' . ( (get_class($this) == 'EJSscript')? 'js': 'css' );
	}

	public function registerCSS()
	{
		if(isset(CMeInFile::$script_contents['ECSSscript']) && get_class($this) == 'ECSSscript') {
			$script_path =	Yii::app()->createAbsoluteUrl('EScriptStore/scripts', array(
				'type' => 'css',
				'script_name' => $this->filename,
			));
			Yii::app()->getClientScript()->registerCssFile($script_path);
		}
	}

	public function registerJS()
	{
		if(isset(CMeInFile::$script_contents['EJSscript']) && get_class($this) == 'EJSscript') {
			$script_path =	Yii::app()->createAbsoluteUrl('EScriptStore/scripts', array(
				'type' => 'js',
				'script_name' => $this->filename
			));
			Yii::app()->clientScript->registerScriptFile($script_path);
		}
	}

	public function cacheScript($type)
	{
		$cache_key = $this->filename;
		if(isset(CMeInFile::$script_contents['ECSSscript']) && get_class($this) == 'ECSSscript') {
			Yii::app()->cache->set($cache_key, implode("\n", CMeInFile::$script_contents[$type]));
		} else if(isset(CMeInFile::$script_contents['EJSscript']) && get_class($this) == 'EJSscript') {
			Yii::app()->cache->set($cache_key, implode("\n", CMeInFile::$script_contents[$type]));
		}
		return true;		
	}

}


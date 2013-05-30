<?php

class ScriptsController extends Controller
{
	public function actionIndex($type, $script_name)
	{
		$script_text = Yii::app()->cache->get($script_name);

		if($script_text === false) {
			throw new CHttpException('404', 'Script not found.');
		}

		if($type == 'js') {
			$this->renderJS($script_text);
		} else {
			$this->renderJsCSS($script_text);
		}
	}

	public function renderJS($script_text)
	{
		header("Content-type: text/javascript");
		echo $script_text;
		Yii::app()->end();
	}

	public function renderJsCSS($script_text)
	{
		header("Content-type: text/css");
		echo $script_text;
		Yii::app()->end();
	}
}

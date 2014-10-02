<?php

class AjaxController extends Controller
{
	public function actionIndex()
	{
		$this->renderText('AJAX');
	}
}
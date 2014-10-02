<?php echo "<?php\n"; ?>

class AjaxController extends Controller
{
	public function actionIndex()
	{
		$this->renderText('AJAX');
	}
}
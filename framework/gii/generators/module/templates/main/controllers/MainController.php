<?php echo "<?php\n"; ?>

class MainController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
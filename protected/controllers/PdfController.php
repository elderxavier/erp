<?php
class PdfController extends Controller
{
    /**
     * Makes warranty-pdf for product
     * @param int $id
     */
    public function actionWarranty($id = null)
    {
        //include mpdf library
        Yii::import('application.extensions.mpdf.mpdf',true);

        //get html for pdf from partial
        $html = $this->renderPartial('_pdf_warranty_invoice',null,true);

        /* @var $pdf mPDF */
        $pdf = new mPDF('utf-8','A4',11,'Arial',5,5,5,5,5,5,'P');

        $stylesheet = file_get_contents('css/style_pdf_warranty.css');
        $pdf->WriteHTML($stylesheet, 1);

        //convert html to pdf
        $pdf->WriteHTML($html,2);

        //if dir not exist
        if(!file_exists('pdf'))
        {
            //create
            mkdir('pdf');
        }

        //filename
        $file_name = "test.pdf";

        //if dir created
        if(file_exists('pdf'))
        {
            //save file
            $pdf->Output('pdf/'.$file_name, 'F');
        }

        $this->ForceDownload('pdf/'.$file_name);
    }


    /**
     * Makes invoice-pdf for outgoing operation
     * @param null $id
     * @throws CHttpException
     */
    public function actionInvoice($id = null)
    {
        /* @var $operation OperationsOut */

        //include mpdf library
        Yii::import('application.extensions.mpdf.mpdf',true);

        if($operation = OperationsOut::model()->findByPk($id))
        {
            //get html for pdf from partial
            $html = $this->renderPartial('_pdf_operation_invoice',array('operation' => $operation),true);

            /* @var $pdf mPDF */
            $pdf = new mPDF('utf-8','A4',9,'Arial',5,5,5,5,5,5,'P');

            $stylesheet = file_get_contents('css/style_pdf_invoice.css');
            $pdf->WriteHTML($stylesheet, 1);

            //convert html to pdf
            $pdf->WriteHTML($html,2);

            //if dir not exist
            if(!file_exists('pdf'))
            {
                //create
                mkdir('pdf');
            }

            //filename
            $file_name = $operation->invoice_code.'.pdf';

            //if dir created
            if(file_exists('pdf'))
            {
                //save file
                $pdf->Output('pdf/'.$file_name, 'F');
            }

            $this->ForceDownload('pdf/'.$file_name);
        }
        else
        {
            throw new CHttpException(404);
        }


    }

    public function actionPackingList($id = null)
    {
        //include mpdf library
        Yii::import('application.extensions.mpdf.mpdf',true);

        $stock_movement = StockMovements::model()->findByPk($id);
        if(!empty($stock_movement))
        {
            //get html for pdf from partial
            $html = $this->renderPartial('_pdf_packing_list',array('movement' => $stock_movement),true);

            /* @var $pdf mPDF */
            $pdf = new mPDF('utf-8','A4-L',9,'Arial',5,5,5,5,5,5,'L');
            $pdf -> displayDefaultOrientation = 'L';

            $stylesheet = file_get_contents('css/packing_list.css');
            $pdf->WriteHTML($stylesheet, 1);

            //convert html to pdf
            $pdf->WriteHTML($html,2);

            //if dir not exist
            if(!file_exists('pdf'))
            {
                //create
                mkdir('pdf');
            }

            //filename
            $file_name = 'testpacking.pdf';

            //if dir created
            if(file_exists('pdf'))
            {
                //save file
                $pdf->Output('pdf/'.$file_name, 'F');
            }

            $this->ForceDownload('pdf/'.$file_name);
        }
        else
        {
            throw new CHttpException(404);
        }
    }




    /**
     * Starts force download of file
     * @param string $file
     */
    private  function ForceDownload($file) {
        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            // читаем файл и отправляем его пользователю
            readfile($file);
            exit;
        }
    }



}
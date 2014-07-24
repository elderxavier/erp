<?php

/**
 * Class CBaseForm
 */
class CBaseForm extends CFormModel
{
    //declare labels and messages array
    protected $labels = array();
    protected $messages = array();

    public function __construct($scenario='')
    {
        $this->labels = Labels::model()->getLabels();
        $this->messages = FormMessages::model()->getLabels();

        parent::__construct($scenario);
    }
}
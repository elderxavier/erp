<?php

class CPagerComponent extends Controller
{
    private $_array = array(); //array of items
    private $_limit = 0; //on one page
    private $_total_pages = 0; //count of pages
    private $_current_page = 0; //selected page

    public $formatted_array = array(); //formatted


    /**
     * Constructor for pager
     * @param string $arr
     * @param null $on_page
     * @param int $current_page
     */
    public function __construct($arr,$on_page,$current_page = 1)
    {
        $this->_array = $arr;
        $this->_limit = $on_page;
        $this->_total_pages = (int)ceil(count($this->_array)/$this->_limit);
        $this->_current_page = $current_page;
        $this -> _getPreparedArray();
    }

    private function _getPreparedArray()
    {
        $offset = (int)($this->_limit * ($this->_current_page - 1));
        $this->formatted_array = array_slice($this->_array,$offset,$this->_limit);
    }

    public function renderPages($filtration_url = '')
    {
        $this->renderPartial('/partials/_pagination', array('pages' => $this->_total_pages, 'current_page' => $this->_current_page, 'filtration_url' => $filtration_url));
    }


}
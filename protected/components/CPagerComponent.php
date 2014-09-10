<?php

class CPagerComponent extends Controller
{
    private $array = array(); //array of items
    private $limit = 0; //on one page
    private $total_pages = 0; //count of pages
    private $formatted_array = array(); //formatted
    private $current_page = 0; //selected page

    /**
     * Constructor for pager
     * @param array $arr
     * @param int $on_page
     */
    public function __construct($arr,$on_page)
    {
        $this->array = $arr;
        $this->limit = $on_page;
        $this->total_pages = (int)ceil(count($this->array)/$this->limit);
    }

    public function getPreparedArray($current_page)
    {
        $offset = (int)($this->limit * ($current_page - 1));
        $this->formatted_array = array_slice($this->array,$offset,$this->limit);
        $this->current_page = $current_page;

        return $this->formatted_array;
    }

    public function renderPages($filtration_url = '')
    {
        $this->renderPartial('/partials/_pagination', array('pages' => $this->total_pages, 'current_page' => $this->current_page, 'filtration_url' => $filtration_url));
    }


}
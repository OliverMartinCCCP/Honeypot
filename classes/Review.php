<?php

class Review {
    private $_db;
    private $_data;

    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this->_data = $this->_db->get('reviews', array('userid', '=', '1'));
    }

    public function getReviews(){
        $this->_data = $this->_db->get('reviews', array('userid', '=', '1'));
    }

    public function getData(){
        return $this->_data->first();
    }

}
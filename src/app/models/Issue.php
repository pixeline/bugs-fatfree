<?php
	
	class Issue extends DB\SQL\Mapper{

	public function __construct(DB\SQL $db) {
	    parent::__construct($db,'issues');
	}
	
	public function all() {
	    $this->load();
	    return $this->query;
	}

	public function getById($id) {
	    $this->load(array('id=?',$id));
	    return $this->query;
	}

	public function add() {
	    $this->copyFrom('POST');
	    $this->created_at = date("Y-m-d H:i:s");
	    $this->updated_at = $this->created_at;
/*
	    echo '<pre>';
	    pr($this);
	    exit;
*/
	    $this->save();
	}
	
	public function edit($id) {
	    $this->load(array('id=?',$id));
	    $this->copyFrom('POST');
	    $this->update();
	}
	
	public function delete($id) {
	    $this->load(array('id=?',$id));
	    $this->erase();
	}
}
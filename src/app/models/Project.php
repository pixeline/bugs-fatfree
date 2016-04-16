<?php
	
	class Project extends DB\SQL\Mapper{

	public function __construct(DB\SQL $db) {
	    parent::__construct($db,'projects');
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
	
	public function users($project_id){
		// Fetch a given project's users info
		return $this->db->exec("SELECT * FROM view_projects_users WHERE project_id='$project_id'");
	}
	
	public function issues($project_id){
		// Fetch a given project's users info
		return $this->db->exec("SELECT * FROM view_projects_issues WHERE project_id='$project_id'");
	}
}
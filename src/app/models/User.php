<?php

class User extends DB\SQL\Mapper{

	public function __construct(DB\SQL $db) {
		parent::__construct($db, 'users');
	}


	public function all() {
		$this->load();
		return $this->query;
	}


	public function getByIdOrName($id) {


		if(is_int($id)){
			$this->load(array('id=?', $id));

		} elseif (is_string($id)){
			$this->load(array('username=?', $id));
		} else{
			die("invalid user id");
		}
		return $this->query;
	}


	public function add() {
		$this->copyFrom('POST');
		$this->save();
	}


	public function edit($id) {
		$this->load(array('id=?', $id));
		$this->copyFrom('POST');
		$this->update();
	}


	public function delete($id) {
		$this->load(array('id=?', $id));
		$this->erase();
	}


	public function projects($id){
		// Fetch User projects (+ opened issues for each)
		//$this->load(array('id=?', $id));
		return $this->db->exec('SELECT p.id, p.title, (SELECT count(id) FROM issues WHERE closed_at IS NULL AND projects_id=p.id ) as opened_issues_amount FROM projects_users as pu LEFT JOIN projects as p ON pu.projects_id=p.id WHERE pu.users_id='. $id );
	}


}
<?php

class ProjectController extends Controller{

	function list_issues(){

		$this->f3->set('SESSION.user.is_inside_project',1);

		$project = new Project($this->db);
		$this_project = $project->getById( $this->f3->get('PARAMS.project_id') );
		$this->f3->set('project', $this_project[0]);

		$issues=new DB\SQL\Mapper($this->db, 'view_projects_issues');
		$issuesList = $issues->find(array('project_id=?', $this->f3->get('PARAMS.project_id')));

		$this->f3->set('issues', $issuesList);
		$this->f3->set('content', 'welcome-loggedin.htm');
	}


}
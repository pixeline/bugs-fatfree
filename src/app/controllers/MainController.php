<?php

class MainController extends Controller{

	function render(){

		$this->f3->clear('SESSION.project');
		$this->f3->clear('SESSION.issue');
		$this->f3->set('user_projects',  $this->f3->get('SESSION.user.projects') );

		$project = new Project($this->db);
		$this_project = $project->all();
		$this->f3->set('project', $this_project);
		
		$issues=new DB\SQL\Mapper($this->db,'view_projects_issues');
		$issuesList = $issues->load(array('project_id=?', $this->f3->get('PARAMS.project_id')));
		
		$this->f3->set('issues', $issuesList);
		$this->f3->set('content', 'home.dashboard.htm');
	}


}
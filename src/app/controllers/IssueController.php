<?php

class IssueController extends Controller{

	function read(){

		$this->f3->set('SESSION.user.is_inside_project',1);


		$project = new Project($this->db);
		$this_project = $project->getById( $this->f3->get('PARAMS.project_id') );
		$this->f3->set('project', $this_project[0]);

		$issues=new DB\SQL\Mapper($this->db, 'view_projects_issues');
		$issuesList = $issues->find(array('project_id=?', $this->f3->get('PARAMS.project_id')));
		$issue = $issues->load(array('issue_id=?', $this->f3->get('PARAMS.issue_id')));
		$this->f3->set('issues', $issuesList);
		$this->f3->set('issue', $issue);
		$this->f3->set('content', 'issue.htm');
	}


	function create(){
		$project = new Project($this->db);
		$this_project = $project->getById( $this->f3->get('PARAMS.project_id') );
		$this->f3->set('project', $this_project[0]);
		
		$this->f3->set('content', 'issue.edit.form.htm');
	}

}
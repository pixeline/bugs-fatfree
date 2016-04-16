<?php

class IssueController extends Controller{

	function render(){

		$issue=new DB\SQL\Mapper($this->db, 'view_projects_issues');
		$issue->load(array('issue_id=?', $this->f3->get('PARAMS.issue_id')));

		$this->f3->set('SESSION.issue', array(
				'id'=> $issue->issue_id,
				'title'=>$issue->issue_title,
				'description'=> $issue->issue_description,
				'project_id'=> $issue->project_id,
				'project_title'=>$issue->project_title,
				'user_id'=>$issue->user_id,
				'display_name' => $issue->display_name,
				'attachments' => array(),
				'comments'=> array()
			));
		$this->f3->set('content', 'issue.render.htm');
	}


	function create(){

		$project = new Project($this->db);
		$this_project = $project->getById( $this->f3->get('PARAMS.project_id') );
		$this->f3->set('project', $this_project[0]);

		$this->f3->set('issue_edit_form_title', 'Create a new issue');
		$this->f3->set('content', 'issue.edit.form.htm');

	}


	function add(){
		$issue = new Issue($this->db);
		$issue->add();
		$this->f3->reroute('/project/'.$this->f3->get('PARAMS.project_id').'/issue/'. $issue->id );

	}


	function edit(){
		$project = new Project($this->db);
		$this_project = $project->getById( $this->f3->get('PARAMS.project_id') );
		$this->f3->set('project', $this_project[0]);

		$issues=new DB\SQL\Mapper($this->db, 'view_projects_issues');
		$issue = $issues->load(array('issue_id=?', $this->f3->get('PARAMS.issue_id')));
		$this->f3->set('issue', $issue);

		$this->f3->set('issue_edit_form_title', 'Create a new issue');
		$this->f3->set('content', 'issue.edit.form.htm');
	}


}
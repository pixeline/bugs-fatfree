<?php

class ProjectController extends Controller{

	function render(){

		$project = new Project($this->db);
		$project->getById( $this->f3->get('PARAMS.project_id') );
		$this->f3->set('SESSION.project', array(
			'id'=> $project->id, 
			'title'=>$project->title,
			'description'=> $project->description,
			'default_assignee'=> $project->default_assignee,
			'created_at'=>$project->created_at,
			'updated_at'=>$project->updated_at,
			'users' => $project->users($project->id),
			'issues' => $project->issues($project->id)
		));
		
		$this->f3->set('content', 'project.welcome.htm');
	}


}
<?php

class IssueController extends Controller{

	function render(){

		$issue=new DB\SQL\Mapper($this->db, 'view_projects_issues');
		$issue->load(array('id=?', $this->f3->get('PARAMS.issue_id')));

		$this->f3->set('SESSION.issue', array(
				'id'=> $issue->id,
				'title'=>$issue->title,
				'description'=> $issue->description,
				'live_url'=> $issue->live_url,
				'project_id'=> $issue->project_id,
				'project_title'=>$issue->project_title,
				'created_by'=>$issue->created_by,
				'creator_display_name'=>$issue->creator_display_name,
				'created_at'=>$issue->created_at,
				'updated_at'=>$issue->updated_at,
				'assigned_to'=>$issue->assigned_to,
				'assigned_display_name'=>$issue->assigned_display_name,
				'closed_at'=>$issue->closed_at,
				'closed_by'=>$issue->closed_by,
				'closer_display_name'=>$issue->closer_display_name,
				'attachments' => array(),
				'comments'=> array()
			));
		$this->f3->set('content', 'issue.render.htm');
	}


	function create(){
		if($this->f3->get('VERB') === 'POST'){
			$issue = new Issue($this->db);
			$issue->add();
			$this->f3->reroute('/project/'.$this->f3->get('PARAMS.project_id').'/issue/'. $issue->id );
		}
		$this->f3->set('issue_edit_form_title', 'Create a new issue');
		$this->f3->set('content', 'issue.edit.htm');
	}


	function edit(){

		if($this->f3->get('VERB') === 'POST'){
			// SAVE DATA
			//print_r($_POST);
			$issue=new Issue($this->db);
			$issue->edit( $this->f3->get('PARAMS.issue_id') );
			$issue->copyfrom('POST', function($val) {
					return array_intersect_key($val, array_flip(array('title', 'description', 'assigned_to')));
				});
			$issue->save();

			$project = new Project($this->db);
			$project->getById( $this->f3->get('SESSION.project.id') );
			$this->f3->set('SESSION.project.issues', $project->issues($project->id) );
		}
		$this->render();

		$this->f3->set('issue_edit_form_title', 'Edit: '. $this->f3->get('SESSION.issue.title'));
		$this->f3->set('content', 'issue.edit.htm');
	}


	function upload(){
		error_reporting(E_ALL | E_STRICT);

		$upload_folder = $this->f3->get('ROOT').'/'. $this->f3->get('UPLOADS');

		$web = \Web::instance();

		$files = $web->receive();

		if(count($files)>0){
			$report = array();
			foreach($files as $file => $okay){
				// get image info
				$local_path_image = $this->f3->get('ROOT').'/'.$file;

				// Save in DB.
				$attachment = new DB\SQL\Mapper($this->db, 'attachments');
				$attachment->filename = $file;
				$attachment->filetype = pathinfo($local_path_image, PATHINFO_EXTENSION);
				$attachment->issues_id =  $this->f3->get('SESSION.issue.id');
				$attachment->users_id =  $this->f3->get('SESSION.user.id');
				$attachment->created_at = date("Y-m-d H:i:s");
				$attachment->save();

				// Create thumbnail
				$img = new Image('../../'.$file);
				$img->resize(  $this->f3->get('thumbwidth'), $this->f3->get('thumbheight'), true, true );
				$thumb_filename = pathinfo($local_path_image, PATHINFO_FILENAME).'_thumb.'. $attachment->filetype;
				file_put_contents($upload_folder. $thumb_filename, $img->dump('jpeg'));

				$report[] =     array(
					'name' => $attachment->filename,
					'size'=> human_filesize($local_path_image),
					'type'=> $attachment->filetype,
					'url'=>  $this->f3->get('HOST').'/'. $attachment->filename ,
					'thumbnailUrl'=> $this->f3->get('HOST').'/'. $this->f3->get('UPLOADS'). $thumb_filename ,
					'deleteUrl'=> '',
					'deleteType'=> 'DELETE'
				);

			}
		}

		$result = array(
			"files"=> $report
		);

		echo json_encode($result);
		$handle->clean();
		exit;

	}


}
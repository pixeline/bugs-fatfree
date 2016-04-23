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
		/*
		$options = array(
			'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
			'upload_dir' => $this->f3->get('ROOT').'/uploads/',
			'upload_url' => $this->f3->get('HOST').'/uploads/',
			'mkdir_mode' => 0775,
		);
*/
		//$upload_handler = new UploadHandler($options);

		/*
		$files = array();

		foreach ($_FILES['files'] as $k => $l) {
			foreach ($l as $i => $v) {
				if (!array_key_exists($i, $files))
					$files[$i] = array();
				$files[$i][$k] = $v;
			}
		}
*/
		//$handle = new Upload($file);
		$upload_folder = $this->f3->get('ROOT').'/'. $this->f3->get('UPLOADS');

		$handle = new upload('php:input');

		if ($handle->uploaded) {
			// save uploaded image with no changes
			$handle->Process($upload_folder);
			if (!$handle->processed) {
				echo json_encode(array('error_orig' =>$handle->error ) );
				$handle->clean();
				exit;
			}
			// Save in DB.
			$attachment = new DB\SQL\Mapper($this->db, 'attachments');
			$attachment->filename = $handle->file_dst_name;
			$attachment->filetype = $handle->image_dst_type;
			$attachment->issues_id =  $this->f3->get('POST.issue_id');
			$attachment->users_id =  $this->f3->get('SESSION.user.id');
			$attachment->created_at = date("Y-m-d H:i:s");
			$attachment->save();

			// Thumbnail
			$handle->file_name_body_pre = 'thumb_';
			$handle->file_safe_name = true;
			$handle->image_resize = true;
			$handle->image_ratio_crop = true;
			$handle->image_x = 100;
			$handle->image_y = 100;
			$handle->dir_chmod = 0775;
			$handle->allowed = array('image/*');
			$handle->process($upload_folder);
			if (!$handle->processed) {
				echo json_encode(array('error_thumb' =>$handle->error ) );
				$handle->clean();
				exit;
			}

			// Finish up.
			
			$result = array(
				"files"=> array(
					array(
						'name' => $handle->file_dst_name,
						'size'=> $handle->file_src_size,
						'type'=> $handle->file_src_mime,
						'url'=>  $this->f3->get('HOST').'/'. $this->f3->get('UPLOADS'). $attachment->filename ,
						'thumbnailUrl'=> $this->f3->get('HOST').'/'. $this->f3->get('UPLOADS'). $handle->file_dst_name ,
						'deleteUrl'=> '',
						'deleteType'=> 'DELETE'
					)
				)
			);

		} else{
			$result = array('error_up' =>$handle->error );

		}
		echo json_encode($result);
		$handle->clean();
		exit;

	}


}
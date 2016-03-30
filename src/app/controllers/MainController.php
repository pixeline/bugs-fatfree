<?php
	
class MainController extends Controller{

	function render($f3){
		
		$projects = new Projects($this->db);
		$project = $projects->all()[0];

		$f3->set('project',$project);
        $template=new Template;
        echo $template->render('layout.htm');
	}
}
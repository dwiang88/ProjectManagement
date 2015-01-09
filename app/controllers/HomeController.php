<?php

use Illuminate\Support\Facades\Auth;
class HomeController extends BaseController {
  
    
	public function index()
	{
		$data['closed'] = DB::table('cx_issues')->where('status_id', '=', 7 )->count();		
		$data['unresolved'] = DB::table('cx_issues')->where('status_id', '!=', 7)->count();
		$data['total_issue'] = DB::table('cx_issues')->count();
		$data['solved_by_you'] = DB::table('cx_issues')->where('assigned_to', '=', Auth::user()->id )->where('status_id', '=', 7 )->count();
		$data['issues_yet_to_solve_by_you'] = DB::table('cx_issues')->where('assigned_to', '=', Auth::user()->id )->where('status_id', '!=', 7 )->count();
		$data['submitted_by_you'] = DB::table('cx_issues')->where('assigned_by', '=', Auth::user()->id )->count();
		$data['records'] = $this->issues_get();
		$data['page_title'] = 'Dashboard';
   		return View::make('dashboard.index', $data);
	}
	

	
	public function issues_get()
	{
		DB::setFetchMode(PDO::FETCH_ASSOC);
		$issues = DB::table('cx_issues')
		->leftJoin('cx_projects as pj', 'pj.id', '=', 'cx_issues.project_id')
		->leftJoin('cx_priority as pr', 'pr.id', '=', 'cx_issues.priority_id')
		->leftJoin('cx_status', 'cx_status.id', '=', 'cx_issues.status_id')
		->leftJoin('users as u', 'u.id', '=', 'cx_issues.assigned_to')
		->leftJoin('users as a', 'a.id', '=', 'cx_issues.assigned_by')	
		->where('assigned_to', '=', Auth::user()->id)
		->where('status_id', '!=', 7)
		->select('issue_id','parent_issue', 'tracking_num','issue_title', 'priority','priority_id','project','status', 'cx_issues.created_at AS postDate', 'a.username AS AssignedBy','u.username AS AssignedTo')
		->get();
		DB::setFetchMode(PDO::FETCH_CLASS);
		//->paginate(15, array('issue_id', 'tracking_num','issue_title', 'priority','project','status', 'cx_issues.created_at') );
		return $issues;
	
	}
	
	
	
    
}

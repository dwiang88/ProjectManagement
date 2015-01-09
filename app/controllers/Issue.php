<?php
class Issue extends BaseController {
	
	public function index()
	{
		return Redirect::route('home');
	}
	
	public function add_get()
	{
		$select = array( "" => "Select");
		$project= DB::table('cx_projects')->orderBy('project', 'ASC')->lists('project','id');	

		$data['project'] = $select+$project ;
		$data['priority'] = DB::table('cx_priority')->orderBy('priority', 'ASC')->lists('priority','id');		
		$data['users'] = DB::table('users')->orderBy('username', 'ASC')->lists('username','id');
		$data['page_title'] = "Add New Issue";
		
		return View::make('issues.add', $data);
	}
	
	public function add_post()
	{
		
		$validator = Validator::make(Input::all(), array(
				'title' => 'required|max:150|min:10',
				'description' => 'required|min:10',
		
		));		
		if ($validator->fails())
		{
			return Redirect::route('add-new-issue')->withErrors($validator)->withInput();
		}
		else
		{
			//Generating Question Tracking Number
			$time = substr( time() , -2);
			$tracking_num = $time."-".rand();
		
			DB::table('cx_issues')->insert(
			array(	'issue_id' => '', 
					'project_id' => Input::get('project') ,
					'parent_issue' => Input::get('parent_issue') ,
					'tracking_num' => $tracking_num,
					'issue_title' => Input::get('title') ,
					'issue_description' => Input::get('description') ,
					'priority_id' => Input::get('priority') ,
					'status_id' => 1 , // 1= Open
					'assigned_to' => Input::get('assigned_to') ,
					'assigned_by' => Auth::user()->id  ,
					'created_at' => date("Y-d-m h:i:s a") ,					
				)
			);
			
			return Redirect::route('Add-new-issue')
			->with('msg', 'Issue Created!'); 
		}
		
	}
	
	
	public function edit_get($id = NULL)
	{
		$data['records'] = DB::table('cx_issues')
								->where('issue_id', '=', $id )
								->where('assigned_by', '=', Auth::user()->id )
								->get();
		$select = array( "" => "Select");
		$project= DB::table('cx_projects')->orderBy('project', 'ASC')->lists('project','id');
	
		$data['project'] = $select+$project ;
		$data['priority'] = DB::table('cx_priority')->orderBy('priority', 'ASC')->lists('priority','id');
		$data['users'] = DB::table('users')->orderBy('username', 'ASC')->lists('username','id');
		$parent_issue = DB::table('cx_issues')->where('issue_id','!=', $id)->lists('issue_title','issue_id');
		$select2 = array( "" => "Select");
		$data['parent_issue']= $select2+$parent_issue; 
		$data['page_title'] = "Edit Issue";
		
		
		
		return View::make('issues.edit', $data);
	}
	
	public function update_post()
	{
		$validator = Validator::make(Input::all(), array(
				'title' => 'required|max:150|min:10',
				'description' => 'required|min:10',
		
		));
		if ($validator->fails())
		{
			return Redirect::route('Edit-Issue')->withErrors($validator)->withInput();
		}
		else
		{		
			DB::table('cx_issues')->where('issue_id', Input::get('issue_id') )			
			->update(
			array(	
			'project_id' => Input::get('project') ,
			'parent_issue' => Input::get('parent_issue') ,		
			'issue_title' => Input::get('title') ,
			'issue_description' => Input::get('description') ,
			'priority_id' => Input::get('priority') ,	
			'assigned_to' => Input::get('assigned_to') ,			
			'updated_at' => date("Y-d-m h:i:s a") ,
			)
			);
				
			return Redirect::route('home')
			->with('msg', 'Issue Updated!')
			->with('type', 'success');
		}
		
	}
	
	public function delete_item($id = NULL)
	{
		DB::table('cx_issues')		
		->where('issue_id', '=', $id)
		->orWhere('parent_issue', '=', $id)
		->delete();
		
		return Redirect::route('home')
		->with('msg', 'Deleted')
		->with('type', 'success');
	}
	
	public function individual_issue_get($id = NULL)
	{
		$data['records'] = DB::table('cx_issues')
		->leftJoin('cx_projects as pj', 'pj.id', '=', 'cx_issues.project_id')
		->leftJoin('cx_priority as pr', 'pr.id', '=', 'cx_issues.priority_id')
		->leftJoin('cx_status', 'cx_status.id', '=', 'cx_issues.status_id')
		->leftJoin('users as u', 'u.id', '=', 'cx_issues.assigned_to')
		->leftJoin('users as a', 'a.id', '=', 'cx_issues.assigned_by')
		->where('issue_id', $id)
		->select('issue_id','parent_issue', 'tracking_num','issue_title','issue_description', 'priority','priority_id','project','status', 'status_id','assigned_by','assigned_to','cx_issues.created_at AS postDate', 'a.username AS AssignedBy','u.username AS AssignedTo')
		->get();
		
		$data['status']= DB::table('cx_status')->orderBy('id', 'ASC')->lists('status','id');
		
		$data['page_title'] = "Details of the Issue";
		return View::make('issues.details', $data);
		
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
		->select('issue_id','parent_issue', 'tracking_num','issue_title', 'priority','priority_id','project','status', 'cx_issues.created_at AS postDate', 'a.username AS AssignedBy','u.username AS AssignedTo')
		->orderBy('issue_id', 'ASC')
		->get();
		DB::setFetchMode(PDO::FETCH_CLASS);
		//->paginate(15, array('issue_id', 'tracking_num','issue_title', 'priority','project','status', 'cx_issues.created_at') );
			
		
		$pre = $this->prepareList( $issues );
		$list =array();
		$sorted_issues = $this->break_array($pre,$counter = NULL, $list);
		
		if(count($sorted_issues) > 0)
		{
			foreach ($sorted_issues as $key=>$value)
			{
				$count = 0;
				foreach ($issues as $rows)
				{
					if($rows['issue_id'] == $key)
					{
						$arranged_issues[$count]['serial'] = $count+1;
						$arranged_issues[$count]['issue_id'] = $key;
						$arranged_issues[$count]['issue_title'] = $value;
						$arranged_issues[$count]['priority'] = $rows['priority'];
						$arranged_issues[$count]['priority_id'] = $rows['priority_id'];
						$arranged_issues[$count]['status'] = $rows['status'];
						$arranged_issues[$count]['postDate'] = $rows['postDate'];
						$arranged_issues[$count]['AssignedTo'] = $rows['AssignedTo'];
						$arranged_issues[$count]['AssignedBy'] = $rows['AssignedBy'];
						$arranged_issues[$count]['tracking_num'] = $rows['tracking_num'];
					}
				$count++;	
				}
			}
			
			$data['records'] = $arranged_issues;
		}
		else
		{
			$data['records'] = NULL;
		}	
		$data['page_title'] = "All Issues";
		return View::make('issues.show',$data);
	
	}
	
	function prepareList(array $items, $pid = 0)
	{
		$output = array();
	
		# loop through the items
		foreach ($items as $item) {
	
		# Whether the parent_id of the item matches the current $pid
		if ((int) $item['parent_issue'] == $pid) {
	
				# Call the function recursively, use the item's id as the parent's id
				# The function returns the list of children or an empty array()
				if ($children = $this->prepareList($items, $item['issue_id'])) {
	
				# Store all children of the current item
				$item['children'] = $children;
				}
	
				# Fill the output
				$output[] = $item;
				}
		}
	
		return $output;
		}
	
	function break_array($data, $counter = NULL, &$list)
	{		
		foreach($data as $row)
		{
			if( array_key_exists('children', $row) )
			{	
				$list[ $row['issue_id'] ] = $row['issue_title'];
				$counter++;
				$this->break_array($row['children'], $counter, $list );
				$counter--;				
			}
			else
			{
				$list[ $row['issue_id'] ] = $this->print_space($counter). $row['issue_title'];
			}		
		}
		
		return $list;
	}

	function print_space($count)
	{
		$html = "";
		for ($i = 1; $i <= $count; $i++)
			{
				$html .= "&nbsp;&nbsp; -- &nbsp;&nbsp;";
		}
		return $html;
	}

	

	public function issue_list_for_dropdown()
	{		
		$records = DB::table('cx_issues')
					->where('project_id', Input::get('project_id') )
					->orderBy('issue_id', 'ASC')
					->lists('issue_title','issue_id');
		
		$output = null;
		$output .= "<option value=''>Select</option>";
		foreach ($records as $key=>$value)
		{
		
			$output .= "<option value='".$key."'>".$value."</option>";
		}		
		return $output;
	}
	
	
	public function change_issue_status()
	{
	
		$validator = Validator::make(Input::all(), array(
				'issue_id' => 'required',
				'status_id' => 'required',
	
		));
		if ($validator->fails())
		{
			return Redirect::route('home');
		}
		else
		{	
			DB::table('cx_issues')
			->where('issue_id', Input::get('issue_id') )
			->update(array('status_id' => Input::get('status_id') ));			
				
			return Redirect::route('Get-Issue',array('id'=> Input::get('issue_id') )); 
			
		}
	
	}
	
	public function issues_posted_by_current_user()
	{
		DB::setFetchMode(PDO::FETCH_ASSOC);
		$data['records'] = DB::table('cx_issues')
		->leftJoin('cx_projects as pj', 'pj.id', '=', 'cx_issues.project_id')
		->leftJoin('cx_priority as pr', 'pr.id', '=', 'cx_issues.priority_id')
		->leftJoin('cx_status', 'cx_status.id', '=', 'cx_issues.status_id')
		->leftJoin('users as u', 'u.id', '=', 'cx_issues.assigned_to')
		->leftJoin('users as a', 'a.id', '=', 'cx_issues.assigned_by')
		->where('assigned_by', '=', Auth::user()->id)
		->where('status_id', '!=', 7)
		->select('issue_id','parent_issue', 'tracking_num','issue_title', 'priority','priority_id','project','status', 'cx_issues.created_at AS postDate', 'a.username AS AssignedBy','u.username AS AssignedTo')
		->get();
		DB::setFetchMode(PDO::FETCH_CLASS);
		//->paginate(15, array('issue_id', 'tracking_num','issue_title', 'priority','project','status', 'cx_issues.created_at') );
		$data['page_title'] = "Issues Posted By Me - Unclosed List";
		return View::make('issues.byme', $data);
	}
	
	
}
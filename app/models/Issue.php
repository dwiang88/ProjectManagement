<?php
class Issue extends Eloquent {
	
	protected $table = "cx_issues";
	protected $primaryKey = 'issue_id';
	protected $fillable = array('issue_title','issue_description','status','assigned_to','assigned_by','created_at','updated_at');
	
	public function assigned_to()
    {
        return $this->belongsTo('User', 'assigned_to', 'id');
    }
    
    public function assigned_by()
    {
    	return $this->belongsTo('User', 'assigned_to', 'id');
    }
}
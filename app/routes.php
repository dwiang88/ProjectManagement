<?php
/*
* Unauthenticated Group
*/
Route::group(array(
	'before' => 'guest'
) ,
function ()
{
	Route::get('/', array(
		'as' => 'sign-in',
		'uses' => 'AccountController@getSignIn',
	));
	/* Sign In (GET)*/
	Route::get('/', array(
		'as' => 'account-sign-in',
		'uses' => 'AccountController@getSignIn'
	));

	// Create Account (GET)

	Route::get('/account/create', array(
		'as' => 'account-create',
		'uses' => 'AccountController@getCreate'
	));
	Route::get('/account/activate/{code}', array(
		'as' => 'account-activate',
		'uses' => 'AccountController@getActivate'
	));

	// Guest CSRF Protection Group

	Route::group(array(
		'before' => 'csrf'
	) ,
	function ()
	{

		// Create Account (POST)

		Route::post('/account/create', array(
			'as' => 'account-create-post',
			'uses' => 'AccountController@postCreate'
		));

		// Sign In (POST)

		Route::post('account/sign-in', array(
			'as' => 'account-sign-in-post',
			'uses' => 'AccountController@postSignIn'
		));
	});
});
/*
* Authenticated Group
*/
Route::group(array(
	'before' => 'auth'
) ,
function ()
{
	Route::get('/dashboard', array(
		'as' => 'home',
		'uses' => 'HomeController@index'
	));

	// All Authenticated Group

	Route::post('/issue/dropdown', array(
		'as' => 'dropdown-issue_list-post',
		'uses' => 'Issue@issue_list_for_dropdown'
	));

	// New Issue

	Route::get('/new-issue', array(
		'as' => 'Add-new-issue',
		'uses' => 'Issue@add_get'
	));

	// All Issues List GET
	Route::get('/issue/list', array(
		'as' => 'All-issues',
		'uses' => 'Issue@issues_get'
	));
	
	// All Issues At a glance (GET)
	Route::get('/issue/list/glance', array(
	'as' => 'All-issues-glance',
	'uses' => 'Issue@issues_glance_get'
	));

	// Individual Issue GET
	Route::get('issue/{id}', array(
		'as' => 'Get-Issue',
		'uses' => 'Issue@individual_issue_get'
	))->where('id', '[0-9]+');
	
	// All Issues Posted By Current User GET
	Route::get('/issue/me', array(
	'as' => 'Individual-issues',
	'uses' => 'Issue@issues_posted_by_current_user'
	));
	
	// In Progress Issues By current User (GET)
	Route::get('/issue/in-progress', array(
	'as' => 'In-progress-issues',
	'uses' => 'Issue@in_progress_by_current_user'
	));
	
	// Edit Issue (GET)
	Route::get('issue/edit/{id}', array(
	'as' => 'Edit-Issue',
	'uses' => 'Issue@edit_get'
	))->where('id', '[0-9]+');
	
	// Delete Issue (GET)
	Route::get('issue/remove/{id}', array(
	'as' => 'Delete-Issue',
	'uses' => 'Issue@delete_item'
	))->where('id', '[0-9]+');
	
	
	/*Sign out (GET) */
	Route::get('/account/sign-out', array(
		'as' => 'account-sign-out',
		'uses' => 'AccountController@getSignOut'
	));
	/*Change Password (GET) */
	Route::get('/account/change-password', array(
		'as' => 'account-change-password',
		'uses' => 'AccountController@getChangePassword'
	));

	// ----------  CSRF Protection group -----

	Route::group(array(
		'before' => 'csrf'
	) ,
	function ()
	{

		// Insert New Issue (POST)
		Route::post('new-issue', array(
			'as' => 'Add-new-issue-post',
			'uses' => 'Issue@add_post'
		));
		
		//  Update Issue (POST)
		Route::post('update-issue', array(
		'as' => 'update-issue-post',
		'uses' => 'Issue@update_post'
				));
		
		// Change Issue Status (POST)
		Route::post('change-issue-status', array(
		'as' => 'change-issue-status',
		'uses' => 'Issue@change_issue_status'
		));

		
		/* Change Password (POST) */
		Route::post('/account/change-password', array(
			'as' => 'account-change-password-post',
			'uses' => 'AccountController@postChangePassword'
		));
	});

	// ----------  End of CSRF Protection group -----

});

<?php

class RoleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::all();
		return View::make('role/index', array('roles' => $roles));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('role/create');	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$role = Role::create(Input::all());

		return Redirect::route('role.profile', $role->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role = Role::find($id);
		$users = $role->users()->get(); 
		return View::make('role/profile', array('role' => $role, 'users' => $users));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$permissions = Permission::all();
		// We want to format permissions as an array using their ID as a key
		$formattedPerms = array();
		foreach ($permissions as $permission) {
			$formattedPerms[$permission->id] = $permission->name;
		}
		$role = Role::find($id);

		return View::make('role/edit', array('role' => $role, 'permissions' => $formattedPerms));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$role = Role::find($id);
		$role->perms()->sync(array_merge(
								$this->calculatePermissions($id), 
								array(Input::get('permission'))
							));
		return Redirect::route('role.profile', $id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function calculatePermissions($id) {
		$role = Role::find($id);
		$permissions = $role->perms()->get();
		$ids = array();

		foreach ($permissions as $permission) {
			$ids[] = $permission->id;
		}

		return $ids;
	}

}

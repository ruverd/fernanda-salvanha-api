<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return all users
     * 
     * @return Response
     */
    public function index()
    {
        return $this->repository->all();    
    }

    /**
     * Store a new user
     * 
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = $this->repository->create($request->all);

        return response()->json($user, 201);
    }

    /**
     * Show the specified user
     * 
     * @param  Integer $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update the specified user
     * 
     * @param  Request $request
     * @param  Integer $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->repository->findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Remove the specified user
     * 
     * @param  Integer $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->repository->find($id)->delete();

        return response()->json(null, 204);
    }
}

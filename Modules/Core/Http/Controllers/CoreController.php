<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CoreController extends Controller
{
    protected $repository;

    /**
     * Construct
     * 
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return response()->json($$this->repository->all(),200);
    }

    /**
     * Show the specified resource.
     * 
     * @return Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return response()->json($$this->repository->create($request->all()),201);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  Request $request
     * @param  Integer $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $result = $this->repository->findOrFail($id);
        $result->update($request->all());
        return response()->json($result,200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $result = $this->repository->fincOrFail($id);
        $result->delete();
        return response()->json(null,204);
    }
}

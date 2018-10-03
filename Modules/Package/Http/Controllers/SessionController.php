<?php

namespace Modules\Package\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Package\Repositories\SessionRepository;

class SessionController extends CoreController
{
    /**
     * Construct
     * 
     * @param SessionRepository $repository
     */
    public function __construct(SessionRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Display a listing of the resource.
     * 
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sessions = ($request->package_id)  
                        ? $this->repository->findByField('package_id',$request->package_id)
                        : $this->repository->all();      
        return response()->json($sessions,200);
    }
}
<?php

namespace Modules\Package\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Package\Repositories\PackageRepository;

class PackageController extends CoreController
{
    protected $user = null;

    /**
     * Construct
     * 
     * @param PackageRepository $repository
     */
    public function __construct(PackageRepository $repository)
    {
        $this->user = Auth::user();
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
        if($request->user_id){
            $packages = $this->repository->findByField('user_id',$request->user_id);
        } else{
            if($this->user->admin){
                $packages = $this->repository->all();
            } else {
                $packages = $this->repository->findByField('user_id',$this->user->id);
            }
        }
        return response()->json($packages,200);
    }
}
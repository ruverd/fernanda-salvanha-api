<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Event\Repositories\EventRepository;
use Modules\Core\Traits\JsonTrait;
use Modules\Core\Contracts\Sync;

class EventController extends Controller
{
    use JsonTrait;

    private $repository,$sync;

    /**
     * @param EventRepository $repository
     */
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get events
     *
     * @return json
     */
    public function index()
    {
        return $this->events();
    }

    /**
     * Get events
     * @param  Request $request
     * @return json
     */
    public function events(Request $request)
    {
        $syncService = app()->make('SyncService');
        dd($syncService->all());
        $query = $request->name ? ['q' => $request->name] : [];
        return $this->repository->getEvents($query)->all();
    }

    /**
     * Get packages
     * @param  Request $request
     * @return json
     */
    public function packages(Request $request)
    {
        $query = $request->name ? ['q' => $request->name] : [];
        return $this->repository->getPackages($query)->all();
    }

    /**
     * Display a listing of the resource
     * @param  Request $request
     * @return json
     */
    public function sessions(Request $request)
    {
        return $this->repository->getSessions($request->package)->all();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('calendar::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('calendar::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('calendar::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}

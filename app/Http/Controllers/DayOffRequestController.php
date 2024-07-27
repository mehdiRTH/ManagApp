<?php

namespace App\Http\Controllers;

use App\Http\Middleware\OffRequestMiddleware;
use App\Http\Requests\OffRequestRequest;
use App\Http\Resources\OffRequestResource;
use App\Jobs\NotificationJob;
use App\Models\OffRequest;
use App\Repositories\OffRequestRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Inertia\Response;
use Closure;
use Illuminate\Http\Request;
use App\Http\Factory\MiddlewareFactory;

class DayOffRequestController extends Controller implements HasMiddleware
{

    public static function middleware() : array
    {
        return [
            new Middleware(function(Request $request, Closure $next){

                $middleware = MiddlewareFactory::createOffRequestMiddleware();
                return $middleware->handle($request,$next);

            },except:['index','create','store'])
        ];
    }

    public function __construct(public OffRequestRepository $offRequestRepository){}


    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        return Inertia::render('OffRequest/Index',[
            'breadcrumbs'=>Breadcrumbs::generate('off_requests.index'),
            'off_requests'=>OffRequestResource::collection($this->offRequestRepository->getOffRequests())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render('OffRequest/Create',[
            'breadcrumbs'=>Breadcrumbs::generate('off_requests.create'),
            'offRequest'=>new OffRequest()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OffRequestRequest $request) : RedirectResponse
    {
        $this->offRequestRepository->store($request);

        return redirect()->route('off_requests.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OffRequest $off_request) : Response
    {
        //Read user Notifications
        NotificationJob::dispatch(auth()->user()->id,$off_request->id);

        return Inertia::render('OffRequest/Show',[
            'breadcrumbs'=>Breadcrumbs::generate('off_requests.show',$off_request),
            'offRequest'=>new OffRequestResource($off_request)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OffRequest $off_request) : Response | RedirectResponse
    {
        if($off_request->status=='Pending')
        {
            return Inertia::render('OffRequest/Create',[
                'breadcrumbs'=>Breadcrumbs::generate('off_requests.edit',$off_request),
                'offRequest'=>new OffRequestResource($off_request)
            ]);
        }

        return redirect()->route('off_requests.index');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OffRequestRequest $request, OffRequest $off_request) : RedirectResponse
    {
        $this->offRequestRepository->update($request,$off_request);

        return redirect()->route('off_requests.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OffRequest $off_request) : RedirectResponse
    {
        $this->offRequestRepository->delete($off_request);

        return back();
    }

}

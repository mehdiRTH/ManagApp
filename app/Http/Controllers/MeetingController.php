<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingsRequest;
use App\Http\Resources\MeetingResource;
use App\Http\Resources\UserResource;
use App\Models\Meeting;
use App\Models\User;
use App\Repositories\MeetingRepository;
use App\Repositories\UserRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class MeetingController extends Controller implements HasMiddleware
{

    public static function middleware():array
    {
        return [
            new Middleware('role:admin|responsible',except:['index','show'])
        ];
    }

    function __construct(public MeetingRepository $meetingRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        $user=auth()->user();
        if ($user->hasRole(['admin', 'responsible']))
        {
            return Inertia::render("Meetings/Index",[
                'breadcrumbs'=>Breadcrumbs::generate('meetings.index'),
                'meetings'=>MeetingResource::collection(Meeting::with(['responsible','createdBy'])->paginate(5))
            ]);
        }else {
            return Inertia::render("Meetings/Index",[
                'breadcrumbs'=>Breadcrumbs::generate('meetings.index'),
                'meetings'=>MeetingResource::collection(Meeting::with(['responsible','createdBy'])->whereJsonContains('participants_id',$user->id)->paginate(5))
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render("Meetings/Create",[
            'breadcrumbs'=>Breadcrumbs::generate('meetings.create'),
            'meeting'=>new MeetingResource(new Meeting()),
            'participantes'=>UserResource::collection(User::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingsRequest $request) : RedirectResponse
    {
        $this->meetingRepository->store($request);

        return redirect()->route('meetings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : Response
    {
        $meeting = Meeting::find($id) ?? new Meeting();

        (new UserRepository())->readNotification($id);

        return Inertia::render('Meetings/Show',[
            'breadcrumbs'=>Breadcrumbs::generate('meetings.show',$meeting),
            'meeting'=>new MeetingResource($meeting->load('responsible'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting) : Response
    {
        return Inertia::render("Meetings/Create",[
            'breadcrumbs'=>Breadcrumbs::generate('meetings.edit',$meeting),
            'meeting'=>new MeetingResource($meeting->load('responsible')),
            'participantes'=>UserResource::collection(User::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeetingsRequest $request, Meeting $meeting): RedirectResponse
    {
        $this->meetingRepository->update($request,$meeting);

        return redirect()->route('meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting): RedirectResponse
    {
        $this->meetingRepository->delete($meeting);

        return back();
    }


}

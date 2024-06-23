<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingsRequest;
use App\Http\Resources\MeetingResource;
use App\Http\Resources\UserResource;
use App\Models\Meeting;
use App\Models\User;
use App\Notifications\MeetingNotification;
use App\Repositories\MeetingRepository;
use Carbon\Carbon;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class MeetingController extends Controller
{

    function __construct(public MeetingRepository $meetingRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("Meetings/Index",[
            'breadcrumbs'=>Breadcrumbs::generate('meetings.index'),
            'meetings'=>MeetingResource::collection(Meeting::with(['responsible','createdBy'])->paginate(5)),
            'participantes'=>UserResource::collection(User::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function store(MeetingsRequest $request)
    {
        $this->meetingRepository->store($request);

        return redirect()->route('meetings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meeting = Meeting::find($id) ?? new Meeting();

        return Inertia::render('Meetings/Show',[
            'breadcrumbs'=>Breadcrumbs::generate('meetings.show',$meeting),
            'meeting'=>new MeetingResource($meeting->load('responsible'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
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
    public function update(MeetingsRequest $request, Meeting $meeting)
    {
        $this->meetingRepository->update($request,$meeting);

        return redirect()->route('meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        $this->meetingRepository->delete($meeting);

        return back();
    }


}

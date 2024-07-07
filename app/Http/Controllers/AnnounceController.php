<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnounceRequest;
use App\Http\Resources\AnnounceResource;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Announce;
use App\Models\Scopes\IsAnnounceActivatedScope;
use App\Models\Section;
use App\Models\User;
use App\Repositories\AnnounceRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
class AnnounceController extends Controller
{

    private $announce;

    /**
     * initialize Announce Repository.
     */

     function __construct(public AnnounceRepository $announceRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        return Inertia::render('Announces/Index',[
            'breadcrumbs'=> Breadcrumbs::generate('announces.index'),
            'announces'=> AnnounceResource::collection(Announce::withoutGlobalScope(IsAnnounceActivatedScope::class)->paginate(5))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        return Inertia::render('Announces/Create',[
            'breadcrumbs'=> Breadcrumbs::generate('announces.create'),
            'announce'=> new AnnounceResource(new Announce()),
            'receivers'=>UserResource::collection(User::all()),
            'sections'=>SectionResource::collection(Section::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnounceRequest $request) : RedirectResponse
    {
        $this->announceRepository->store($request);

        return redirect()->route('announces.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : Response
    {
        $announce=$this->announceRepository->announceWithoutScope($id);

        return Inertia::render('Announces/Create',[
            'breadcrumbs'=> Breadcrumbs::generate('announces.edit',$announce),
            'announce'=> new AnnounceResource($announce),
            'receivers'=>UserResource::collection(User::all()),
            'sections'=>SectionResource::collection(Section::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnounceRequest $request, string $id) : RedirectResponse
    {
        $announce=$this->announceRepository->announceWithoutScope($id);

        $this->announceRepository->update($request,$announce);

        return redirect()->route('announces.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announce $announce)
    {
        $announce->delete();
    }
}

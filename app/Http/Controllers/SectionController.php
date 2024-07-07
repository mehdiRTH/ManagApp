<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Section;
use App\Models\User;
use App\Repositories\SectionRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SectionController extends Controller
{

    function __construct(public SectionRepository $sectionRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        $bread=Breadcrumbs::generate("sections.index");

        return Inertia::render("Sections/Index",[
            'breadcrumbs'=>$bread,
            'sections'=>SectionResource::collection(Section::with(['responsible'])->withCount('employees_affected')->paginate(5)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        $breadcrumb=Breadcrumbs::generate("sections.create");

        return Inertia::render("Sections/Create",[
            'breadcrumbs'=>$breadcrumb,
            'section'=>new SectionResource(new Section()),
            'responsibles'=>UserResource::collection(User::role('responsible')->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request) : RedirectResponse
    {
        // Store function in repository
        $this->sectionRepository->store($request);

        return redirect()->route('sections.index');
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
    public function edit(Section $section) : Response
    {
        $breadcrumb=Breadcrumbs::generate("sections.edit",$section);

        return Inertia::render("Sections/Create",[
            'breadcrumbs'=>$breadcrumb,
            'section'=>new SectionResource($section->load('responsible')),
            'responsibles'=>UserResource::collection(User::role('responsible')->get()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section) : RedirectResponse
    {
        // Update function in repository
        $this->sectionRepository->update($section, $request);

        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section) : RedirectResponse
    {
        // Destroy function in repository
        $this->sectionRepository->destroy($section);

        return back();
    }
}

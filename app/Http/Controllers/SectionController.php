<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Section;
use App\Models\User;
use App\Repositories\SectionRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{

    function __construct(public SectionRepository $sectionRepository){}

    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function create()
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
    public function store(SectionRequest $request)
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
    public function edit(Section $section)
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
    public function update(Request $request, Section $section)
    {
        // Update function in repository
        $this->sectionRepository->update($section, $request);

        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        // Destroy function in repository
        $this->sectionRepository->destroy($section);

        return back();
    }
}

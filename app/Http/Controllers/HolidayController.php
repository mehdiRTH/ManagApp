<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayRequest;
use App\Http\Resources\HolidayResource;
use App\Models\Holiday;
use App\Repositories\HolidayRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use Inertia\Response;

class HolidayController extends Controller implements HasMiddleware
{
    public static function middleware() : array
    {
        return [
            new Middleware('HR', except:['index'])
        ];
    }

    public function __construct(public HolidayRepository $holidayRepository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        return Inertia::render("Holidays/Index",[
            'breadcrumbs'=> Breadcrumbs::generate('holidays.index'),
            'holidays'=>HolidayResource::collection(Holiday::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HolidayRequest $request) : RedirectResponse
    {
        $this->holidayRepository->store($request);

        return redirect()->route('holidays.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Holiday $holiday) : RedirectResponse
    {
        $this->holidayRepository->update($request,$holiday);

        return redirect()->route('holidays.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday) : RedirectResponse
    {
        $this->holidayRepository->destroy($holiday);

        return redirect()->route('holidays.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\DailyActivityResource;
use App\Models\DailyActivity;
use App\Models\User;
use App\Repositories\DailyActivityRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class DailyActivityController extends Controller
{

    public function __construct(public DailyActivityRepository $dailyActivityRepository){}
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        return Inertia::render('DailyActivity/Index',[
            'breadcrumbs'=>Breadcrumbs::generate('daily_activities.index'),
            'daily_activities'=>DailyActivityResource::collection(DailyActivity::paginate(5))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : Response
    {
        $activity=$this->dailyActivityRepository->userActivity($user);

        return Inertia::render('DailyActivity/Show',[
            'breadcrumbs'=>Breadcrumbs::generate('daily_activities.show',$activity),
            'daily_activity'=>new DailyActivityResource($activity)
        ]);
    }

    public function readQr() : Response
    {
        return Inertia::render('DailyActivity/Read',[
            'breadcrumbs'=>Breadcrumbs::generate('daily_activities.read_qr')
        ]);
    }

    public function checkQr($qrCode)
    {
        return $this->dailyActivityRepository->checkQr($qrCode);
    }


}

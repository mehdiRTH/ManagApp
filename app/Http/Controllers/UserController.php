<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\SectionResource;
use App\Http\Resources\UserResource;
use App\Models\Section;
use App\Models\User;
use App\Repositories\UserRepository;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct(public UserRepository $userRepository){}

    //User index
    public function index() : Response
    {
        $users=UserResource::collection(User::paginate(5));
        $breadcrumbs=Breadcrumbs::generate('users.index');

        // return $users;
        return Inertia::render('Users/Index',[
            'users'=> $users,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function create() : Response
    {
        $breadcrumbs=Breadcrumbs::generate('users.create');

        return Inertia::render('Users/Create',[
            'user'=> new UserResource(new User()),
            'breadcrumbs' => $breadcrumbs,
            'roles'=>Role::all(),
            'sections'=>SectionResource::collection(Section::with('responsible')->get())
        ]);
    }

    public function store(UserRequest $request) : RedirectResponse
    {
        $this->userRepository->store($request);

        return redirect()->route('users.index');
    }

    public function edit(User $user) : Response
    {
        $breadcrumbs=Breadcrumbs::generate('users.edit',$user);

        return Inertia::render('Users/Create',[
            'user'=> new UserResource($user),
            'breadcrumbs' => $breadcrumbs,
            'roles'=>Role::all(),
            'sections'=>SectionResource::collection(Section::with('responsible')->get())
        ]);
    }

    public function update(UserRequest $request, User $user) : RedirectResponse
    {
        $this->userRepository->update($request,$user);

        return redirect()->route('users.index');
    }

    public function destroy(User $user) : RedirectResponse
    {
        $this->userRepository->destroy($user);

        return back();
    }
}

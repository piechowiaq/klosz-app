<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domains\Company\Models\Company;
use App\Domains\User\Models\User;
use App\Domains\User\Requests\StoreUserRequest;
use App\Domains\User\Requests\UpdateUserRequest;
use App\Domains\User\Services\UserService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller
{
    use HasRoles;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Users/Index', [
            'filters' => $request->all(['search', 'trashed']),
            'users' => User::when($request->input('search'), function ($query, $search) {

                    $query->where('name' , 'like', '%' . $search. '%')
                        ->orWhere('last_name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                })
                ->when($request->input('trashed'), function ($query, $trashed) {
                    if ($trashed === 'with') {
                        $query->withTrashed();
                    } elseif ($trashed === 'only') {
                        $query->onlyTrashed();
                    }
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'deleted_at' => $user->deleted_at
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws Exception
     */
    public function create(): Response
    {
//        /** @var User $user */
//        $user = Auth::user();
//
//        if ($user->cannot('manage users')){
//            throw new Exception('Cant manage users');
//        }
        return Inertia::render('Admin/Users/Create', [
            'roles' => Role::all()->toArray(),
            'companies' => Company::all()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->userService->create($request->get('name'),
                                            $request->get('last_name'),
                                            $request->get('password'),
                                            $request->get('email'),
                                            $request->get('phone'),
                                            $request->get('role_id'));

        $companyIds = $request->get('company_ids');
        $companies  = new Collection();

        if (is_array($companyIds)) {
            $companies = Company::whereIn('id', $companyIds)->get();
        }

        $user->companies()->sync($companies);

        return Redirect::route('users.edit',  ['user' => $user])->with('success', 'User created.');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return Inertia::render('Admin/Users/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {

       return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
            'roles' => Role::all()->toArray(),
            'role_id' => $user->roles()->first()->id,
            'companies' => Company::all()->toArray(),
            'company_ids' => $user->companies()->get()->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userService->update($user, $request->get('name'),
                                            $request->get('last_name'),
                                            $request->get('password'),
                                            $request->get('email'),
                                            $request->get('phone'),
                                            $request->get('role_id'));

        $companyIds = $request->get('company_ids');
        $companies  = new Collection();

        if (is_array($companyIds)) {
            $companies = Company::whereIn('id', $companyIds)->get();
        }

        $user->companies()->sync($companies);

        return Redirect::route('users.index')->with('success', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::route('users.index')->with('success', 'User deleted.');
    }

    public function restore(User $user): RedirectResponse
    {
        $user->restore();

        return Redirect::route('users.index')->with('success', 'User restored.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserRequest;

use App\Notifications\CheckedOutBookNotification;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Users', 'link' => '/users']
        ];

        $users = User::paginate(User::PER_PAGE);
        return view('users.index', compact(['users', 'breadcrumbs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/home'],
            ['name' => 'Users', 'link' => '/users'],
            ['name' => 'Add a user', 'link' => '/users/create']
        ];

        $roles = Role::all();
        return view('users.create', compact(['roles', 'breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $new_user = User::create($request->validated());

        if ($new_user) {
            alert()->success('New user added.', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $users = User::paginate(User::PER_PAGE);
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Users', 'link' => '/users'],
            ['name' => 'User details', 'link' => '/users/'.$user->id],
        ];

        return view('users.show', compact(['user', 'breadcrumbs']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => '/'],
            ['name' => 'Users', 'link' => '/users'],
            ['name' => 'Update user details', 'link' => '/users/'.$user->id.'/edit'],
        ];

        $roles = Role::all();
        return view('users.edit', compact(['user', 'roles', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $update = $user->update($request->validated());

        if ($update) {
            alert()->success('User data updated.', 'Success')->autoclose(5000);
        } else {
            alert()->error('An error has occurred. Try again later.', 'Error')->autoclose(5000);
        }

        $users = User::paginate(User::PER_PAGE);
        return view('users.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // cannot delete oneself
        if ($user->id != auth()->id()) {
            if ($user->lendings()->count()) {
                alert()->error('Please first delete lendings associated with this user.')->autoclose(5000);
            } else {
                $user->delete();
                alert()->success('User successfully deleted.', 'Success')->autoclose(5000);
            }
        }

        return redirect()->route('users.index');
    }

    public function readUserQRCode($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(422, 'Please scan a valid student card.');
        } else {
            return $user;
        }
    }
}

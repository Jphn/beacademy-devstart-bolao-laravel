<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserControllerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private User $user)
    {
    }

    public function postNewUser(UserControllerRequest $req)
    {
        $data = $req->only('name', 'email');
        $data['password'] = bcrypt($req->password);

        $this->user->create($data);

        return redirect()->back();
    }

    public function putUser(UserControllerRequest $req, $id)
    {
        $user = $this->user->findOrFail($id);

        $data = $req->only('name', 'email');
        if ($req->password)
            $data['password'] = bcrypt($req->password);

        $user->update($data);

        return redirect()->route('admin.list');
    }

    public function deleteUser($id)
    {
        $user = $this->user->findOrFail($id);

        if (Auth::user()->id != $id)
            $user->delete();

        return redirect()->back();
    }
}

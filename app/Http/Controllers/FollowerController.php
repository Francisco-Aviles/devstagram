<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    //
    public function store(User $user)
    {
        //Usamos attach para almacenar los seguidos
        $user->followers()->attach( Auth::user()->id, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        return back();
    }

    public function destroy(User $user)
    {
        //Eliminamos el seguidor
        $user->followers()->detach( Auth::user()->id);
        return back();
    }

}

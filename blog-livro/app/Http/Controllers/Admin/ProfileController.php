<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {

        $user = auth()->user();

        if(!$user->profile()->count()) {

            $user->profile()->create();

        }

        return view('profile.index', compact('user'));
    
    }

    public function update(Request $request) {
        $userData = $request->get('user');
        $profileData = $request->get('profile');

        try {
            if($userData['password']) {
                $userData['password'] = bcrypt($userData['password']);
            } else {
                unset($userData['password']);
            }
            $user = auth()->user();

            $user->update($userData);

            $user->profile()->update($profileData);

            if($request->hasFile('avatar')) {

                Storage::disk('public')->delete($user->avatar);

                $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');

                } else {
                unset($profileData['avatar']);
                }


            flash('Perfil atualizado com sucesso!')->success();

            return redirect()->route('profile.index');

        } catch (Exception $e) {

            $message = 'Erro ao remover Categoria';

            if(env('APP_DEBUG')) {
                $message = $e->getMessage();
            }

            flash($message)->warning();
            return redirect()->back();
        }
    }
}

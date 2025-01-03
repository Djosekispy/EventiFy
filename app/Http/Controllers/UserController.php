<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
   public function updateProfile(Request $request)
   {
       $validatedData = $request->validate([
           'name' => 'required|string|max:255',
           'phone' => 'nullable|string|max:20',
           'website' => 'nullable|string|max:255',
           'contry' => 'nullable|string|max:255',
           'city' => 'nullable|string|max:255',
           'company' => 'nullable|string|max:255',
       ]);

       $user = User::find(auth()->id());
       $user->name = $validatedData['name'];
       $user->phone = $validatedData['phone'];
       $user->website = $validatedData['website'];
       $user->contry = $validatedData['contry'];
       $user->city = $validatedData['city'];
       $user->company = $validatedData['company'];
       $user->save();

       return back()->with('status', 'Perfil atualizado com sucesso!');
   }

   public function updatePassword(Request $request)
   {
    try{
        $validatedData = $request->validate([
            'new_password' => 'required|min:6',
            'confirm_password' => 'required_with:new_password|same:new_password|min:6',
        ]);
        $user = User::find(auth()->id());
        $user->password = bcrypt($validatedData['new_password']);
        $user->save();
        return back()->with('status', 'Senha atualizada com sucesso!');
    } catch (\Throwable $th) {
        return back()->withErrors(['new_password' => $th->getMessage()]);
    }

   }

   public function updateEmail(Request $request)
   { try{
        $validatedData = $request->validate([
            'new_email' => 'required|email',
            'confirm_email' => 'required_with:new_email|same:new_email|email',
        ]);
        $user = User::find(auth()->id());
        $user->email = $validatedData['new_email'];
        $user->save();
        return back()->with('status', 'E-mail atualizada com sucesso!');
    } catch (\Throwable $th) {
        return back()->withErrors(['new_email' => $th->getMessage()]);
    }

   }
public function updateProfileImage(Request $request)
{
    try {
        $validatedData = $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(auth()->id());
        $filePath = $request->file('profile_image')->store('uploads', 'public');
        $user->profile_photo_path = $filePath;
            $user->save();
        return back()->with('status', 'Imagem de perfil atualizada com sucesso!');
    } catch (\Throwable $th) {
        return back()->withErrors(['profile_image' => $th->getMessage()]);
    }
}
}

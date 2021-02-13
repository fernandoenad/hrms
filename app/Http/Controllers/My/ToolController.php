<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Models\PUserLog;

class ToolController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index()
    {
        $user = Auth::user();
        $person = $user->person; 
       
        return view('my.tool.index', compact('person'));
    }

    public function editEmail()
    {
        $user = Auth::user();
        $person = $user->person; 
       
        return view('my.tool.editemail', compact('person'));
    }

    public function updateEmail()
    {
        $data = request()->validate([
            'email' => ['required', 'email'],
        ]); 

        $user = Auth::user();
        $user->update($data);     
        
        PUserLog::create([
            'u_id' => $user->id,
            'action' => 'Modify Email',
            'log' => $user->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('my.tools')->with('status', 'E-Mail updated!'); 
    }

    public function editPassword()
    {       
        $user = Auth::user();
        $person = $user->person; 
      
        return view('my.tool.editpassword', compact('person'));
    }

    public function updatePassword()
    {
        $data = request()->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]); 

        $user = Auth::user();
        $user->update(['password' => Hash::make($data['password']),]);      

        PUserLog::create([
            'u_id' => $user->id,
            'action' => 'Modify Password',
            'log' => $user->toJson(),
            'user_id' => Auth::user()->id,
        ]);

        Auth::logout();
        return redirect()->route('login')->with('status', 'Password updated, please re-login!'); 
    }

    public function editImage()
    {       
        $user = Auth::user();
        $person = $user->person; 
       
        return view('my.tool.editimage', compact('person'));
    }

    public function updateImage()
    {       
        $data = request()->validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:1024'],
        ]); 

        $user = Auth::user();
        $person = $user->person; 

        if($person->image != 'no-avatar.jpg')
            unlink("storage/avatars/" . $person->image);
            
        $imagePath = $data['image']->store('avatars', 'public');
        
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(300, 300);
        $image->save();

        $image = explode("/", $imagePath);

        $person->update([
            'image' => $image[1],
        ]);

        $user->person->personlog()->create([
            'action' => 'Modify Image',
            'log' => $person->toJson(),
            'user_id' => Auth::user()->id,
        ]);  
       
        return redirect()->route('my.tools')->with('status', 'Image updated!'); 
    }

}

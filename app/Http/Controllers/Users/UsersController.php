<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\Job\JobSaved;
use File;


class UsersController extends Controller
{
    //
    function profile(){
        $profile=User::find(Auth::user()->id);
        return view('users.profile',compact('profile'));
    }

    function applications(){
        $applications=Application::where('user_id',Auth::user()->id)->get();
        return view('users.applications',compact('applications'));
    }

    function savedJobs(){
        $savedJobs=JobSaved::where('user_id',Auth::user()->id)->get();
        return view('users.savedJobs',compact('savedJobs'));
    }

    function editDetails(){
        $userDetails=User::find(Auth::user()->id);
        return view('users.editDetails',compact('userDetails'));
    }
    function updateDetails(Request $request){

        Request()->validate([
            "name" => "required|max:40",
            "job_title" => "required|max:40",
            "bio" => "required|max:40",
            "facebook" => "required|max:140",
            "twitter" => "required|max:140",
            "linkedin" => "required|max:140",
        ]);


        $userDetailsUpdated=User::find(Auth::user()->id);
        $userDetailsUpdated->update([
            "name" => $request->name,
            "job_title" => $request->job_title,
            "bio" => $request->bio,
            "facebook" => $request->facebook,
            "twitter" => $request->twitter,
            "linkedin" => $request->linkedin,
        ]);

        if ($userDetailsUpdated) {
            // Redirect to the single job view with a success message
            return redirect()->route('edit.details')
                             ->with('update', 'Details Updated Successfully');
        }
    }
    function editcv(Request $request){

        return view('users.editcv');
    }

    function updatecv(Request $request){
        $OldCv=User::find(Auth::user()->id);
        if(File::exists(public_path('assets/cvs/' .$OldCv->cv))){
            File::delete(public_path('assets/cvs'.$OldCv->cv));
        }else{

        }

        $destinationpath='assets/cvs';
        $mycv=$request->cv->getClientOriginalName();
        $request->cv->move(public_path($destinationpath),$mycv);

        $OldCv ->update(["cv" => $mycv]) ;
        return redirect()->route('profile')
                             ->with('update', 'CV Updated Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Category\Category;
use App\Models\Job\Application;
use App\Models\Job\Job;
use Illuminate\Support\Facades\Hash;
use Auth;
use File;

class AdminController extends Controller
{
    function adminlogin(){
        return view('admins.view-login');
    }
    function checklogin(Request $request){

        $remember_me = $request->has('remember_me') ? true : false;

        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            return redirect() -> route('admins.dashboard');
        }
        return redirect()->back()->with(['error' => 'error logging in']);

    }
    function index(){

        $jobs=Job::select()->count();

        $categories=Category::select()->count();

        $admins=Admin::select()->count();

        $applications=Application::select()->count();

        return view('admins.index',compact('jobs','categories','admins','applications'));
    }
    function admins(){

        $admins=Admin::all();

        return view('admins.admins',compact('admins'));
    }

    function createadmins(){

        return view('admins.create-admins');
    }

    function storeadmins(Request $request){

        Request()->validate([
            "name" => "required|max:40",
            "email" => "required|max:40",
            "password" => "required|max:40"
        ]);

        $createAdmin=Admin::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make( $request->password),
        ]);

        if ($createAdmin) {
            // Redirect to the single job view with a success message
            return redirect()->route('view.admins')
                             ->with('createadmin', 'Admin created successfully');
        }
    }

    function showcategories(){

        $categories=Category::all();

        return view('admins.showcategories',compact('categories'));
    }
    function createcategory(){

        return view('admins.createcategory');
    }

    function storecategory(Request $request){

        Request()->validate([
            "name" => "required|max:40"
        ]);

        $createCategories=Category::create([
            'name' => $request->name
        ]);

        if ($createCategories) {
            // Redirect to the single job view with a success message
            return redirect()->route('show.categories')
                             ->with('createcate', 'Category created successfully');
        }
    }

    function editcategory($id){

        $category=Category::find($id);

        return view('admins.editcategory',compact('category'));
    }

    function updateCategory($id,Request $request){

        Request()->validate([
            "name" => "required|max:40",
        ]);


        $updateCategory=Category::find($id);
        $updateCategory->update([
            "name" => $request->name,
        ]);

        if ($updateCategory) {
            // Redirect to the single job view with a success message
            return redirect()->route('show.categories')
                             ->with('update', 'Category Updated Successfully');
        }
    }

    function deletecategory($id){

        $deletecategory=Category::find($id);
        $deletecategory->delete();

        if ($deletecategory) {
            // Redirect to the single job view with a success message
            return redirect()->route('show.categories')
                             ->with('delete', 'Category deleted Successfully');
        }
    }
    function allJobs(){

        $jobs=Job::all();

        return view('admins.showjobs',compact('jobs'));
    }

    function createjobs(){

        $categories=Category::all();

        return view('admins.createjobs', compact('categories'));
    }

    function storejobs(Request $request){

        $destinationpath='assets/images';
        $myimage=$request->image->getClientOriginalName();
        $request->image->move(public_path($destinationpath),$myimage);

        $createJobs=Job::create([
            'job_title' => $request->job_title,
            'job_region' => $request->job_region,
            'company' => $request->company,
            'job_type' => $request->job_type,
            'vacancy' => $request->vacancy,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'gender' => $request->gender,
            'application_deadline' => $request->application_deadline,
            'job_description' => $request->job_description,
            'responsibilities' => $request->responsibilities,
            'education_experience' => $request->education_experience,
            'category' => $request->category,
            'other_benefits' => $request->other_benefits,
            'image' => $myimage,
        ]);

        if ($createJobs) {
            // Redirect to the single job view with a success message
            return redirect()->route('show.jobs')
                             ->with('showjobs', 'Job created successfully');
        }
    }

    function deletejobs($id){

        $OldImage=Job::find($id);
        if(File::exists(public_path('assets/images/' .$OldImage->image))){
            File::delete(public_path('assets/images'.$OldImage->image));
        }else{

        }

        $deleteJob=Job::find($id);
        $deleteJob->delete();

        if ($deleteJob) {
            // Redirect to the single job view with a success message
            return redirect()->route('show.jobs')
                             ->with('delete', 'Job deleted Successfully');
        }
    }

    function apps(){

        $apps=Application::all();

        return view('admins.apps', compact('apps'));
    }






}

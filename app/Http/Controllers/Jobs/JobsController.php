<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job\Job;
use App\Models\Job\JobSaved;
use App\Models\Job\Application;
use App\Models\Job\Search;
use App\Models\Category\Category;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    public function single($id){
        $job = Job::find($id);

        //getting related jobs

        if (!$job) {
            return abort(404);  // Abort with a 404 page if the job is not found
        }

        $related=Job::where('category',$job->category)
        ->where('id' ,'!=',$id )
        ->take(5)
        ->get();

        $relatedCount=Job::where('category',$job->category)
        ->where('id' ,'!=',$id )
        ->take(5)
        ->count();

        $categories=Category::all();

        if(auth()->user()){
            $savedJob=JobSaved::where('job_id',$id)
            ->where('user_id',Auth::user()->id)->count();

            $appliedJob=Application::where('user_id',Auth::user()->id)
            ->where('job_id',$id)
            ->count();



            return view("jobs.single", compact("job" ,"related","relatedCount","savedJob",'appliedJob','categories'));

        }else{
            return view("jobs.single", compact("job" ,"related","relatedCount",'categories'));

        }
    }
    public function saveJob(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'job_id' => 'required|exists:jobs,id',  // Make sure the job_id exists in the 'jobs' table
            'user_id' => 'required|exists:users,id',  // Ensure the user_id exists in the 'users' table
            'image' => 'required|string',  // Job image should be a string (filename or URL)
            'job_title' => 'required|string|max:255',  // Job title should be a string and not too long
            'job_region' => 'required|string|max:255',  // Region should be a string
            'job_type' => 'required|string|max:255',  // Job type should be a string
            'company' => 'required|string|max:255',  // Company name should be a string
        ]);

        // If validation fails, Laravel will automatically redirect back with error messages.

        // Save the job to the JobSaved table
        $saveJob = JobSaved::create([
            'job_id' => $request->job_id,
            'user_id' => $request->user_id,
            'job_image' => $request->image,
            'job_title' => $request->job_title,
            'job_region' => $request->job_region,
            'job_type' => $request->job_type,
            'company' => $request->company,
        ]);

        // Check if the job was saved successfully
        if ($saveJob) {
            // Redirect to the single job view with a success message
            return redirect()->route('single.job', ['id' => $request->job_id])
                             ->with('save', 'Job saved successfully');
        } else {
            // If saving failed, redirect back with an error message
            return back()->withErrors(['error' => 'Failed to save the job.']);
        }
    }
    public function applyJob(Request $request){
        if(Auth::user()->cv=="No CV"){
            return redirect()->route('single.job', ['id' => $request->job_id])
            ->with('Apply', 'Upload your CV first');
        }else{
            $applyJob=Application::create([
                'cv'=>Auth::user()->cv,
                'job_id' => $request->job_id,
                'user_id' => Auth::user()->id,
                'job_image' => $request->image,
                'job_title' => $request->job_title,
                'job_region' => $request->job_region,
                'job_type' => $request->job_type,
                'company' => $request->company,
            ]);

            if ($applyJob) {
                // Redirect to the single job view with a success message
                return redirect()->route('single.job', ['id' => $request->job_id])
                                 ->with('applied', 'Your Applied To this Job');
            }
        }

    }
    function search(Request $request){

        Request()->validate([
            'job_title' => 'required', // Job image should be a string (filename or URL)
            'job_region' => 'required',  // Job title should be a string and not too long
            'job_type' => 'required', // Company name should be a string
        ]);

        Search::Create([
            "keyword"=>$request->job_title
        ]);

        $job_title=$request->get('job_title');
        $job_region=$request->get('job_region');
        $job_type=$request->get('job_type');

        $searches=Job::select()->where('job_title','like', "%$job_title%")
        ->where('job_region', 'like', "%$job_region%")
        ->where('job_type', 'like', "%$job_type%")
        ->get();
        return view("jobs.search",compact("searches"));
    }

    function postJob(){

        $categories=Category::all();

        return view('users.post-job', compact('categories'));
    }

    function postjobs(Request $request){

        $destinationpath='assets/images';
        $myimage=$request->image->getClientOriginalName();
        $request->image->move(public_path($destinationpath),$myimage);


        $postJobs=Job::create([
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

        if ($postJobs) {
            // Redirect to the single job view with a success message
            return redirect()->route('home')
                             ->with('showjobs', 'Job created successfully');
        }
    }

}

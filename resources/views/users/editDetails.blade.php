@extends('layouts.app')

@section('content')
<section class="section-hero overlay inner-page bg-image" style="background-image: url('{{ asset('assets/images/hero_1.jpg') }}'); margin-top:-24px;" id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h1 class="text-white font-weight-bold">Update Details</h1>
          <div class="custom-breadcrumbs">
            <a href="#">Home</a> <span class="mx-2 slash">/</span>
            <a href="#">Job</a> <span class="mx-2 slash">/</span>
            <span class="text-white"><strong>Update Details</strong></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container">
    @if (\Session::has('update'))
     <div class="alert alert-success">
       <p>{!! \Session::get('update') !!}</p>
     </div>
    @endif
  </div>

  <div class="row mb-5">
    <div class="col-lg-12">
      <form class="p-4 p-md-5 border rounded" action="{{ route('update.details') }}" method="post">

        <!--job details-->
        @csrf

        <div class="form-group">
          <label for="job-title">Name</label>
          <input type="text" value="{{ $userDetails->name }}" name="name" class="form-control" id="job-title" placeholder="Name">

          @if($errors->has('name'))
            <p class="alert alert-warning">{{ $errors->first('name') }}</p>
          @endif
        </div>

        <div class="form-group">
            <label for="job-title">Job Title</label>
            <input type="text" value="{{ $userDetails->job_title }}" name="job_title" class="form-control" id="job-title" placeholder="Job Title">
            @if($errors->has('job_title'))
              <p class="alert alert-warning">{{ $errors->first('job_title') }}</p>
            @endif
        </div>

        <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black" for="">Bio</label>
              <textarea value="{{ $userDetails->bio }}" name="bio" id="" cols="30" rows="7" class="form-control" placeholder="Bio"></textarea>
              @if($errors->has('bio'))
                <p class="alert alert-warning">{{ $errors->first('bio') }}</p>
              @endif
        </div>

        <div class="form-group">
            <label for="job-title">Twitter</label>
            <input type="text" value="{{ $userDetails->twitter }}" name="twitter" class="form-control" id="job-title" placeholder="Twitter">
            @if($errors->has('twitter'))
              <p class="alert alert-warning">{{ $errors->first('twitter') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="job-title">Facebook</label>
            <input type="text" value="{{ $userDetails->facebook }}" name="facebook" class="form-control" id="job-title" placeholder="Facebook">
            @if($errors->has('facebook'))
               <p class="alert alert-warning">{{ $errors->first('facebook') }}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="job-title">LinkedIn</label>
            <input type="text" value="{{ $userDetails->linkedin }}" name="linkedin" class="form-control" id="job-title" placeholder="LinkedIn">
            @if($errors->has('linkedin'))
              <p class="alert alert-warning">{{ $errors->first('linkedin') }}</p>
            @endif
        </div>


        </div>
        <div class="col-lg-4 ml-auto">
            <div class="row">
              <div class="col-6">
                <input type="submit" name="submit" class="btn btn-block btn-primary btn-md" style="margin-left: 200px;" value="Update">
              </div>
            </div>
        </div>


      </form>
    </div>


  </div>

</div>
</section>

@endsection

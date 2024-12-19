@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4 d-inline">Job Applications</h5>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">cv</th>
                <th scope="col">job_id</th>
                <th scope="col">job_title</th>
                <th scope="col">company</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($apps as $app)

                 <tr>
                   <th scope="row">1</th>
                   <td><a class="btn btn-success" href="{{ asset('assets/cvs'.$app->cv.'') }}">CV</a></td>
                   <td><a class="btn btn-success" href="{{ route('single.job',$app->id) }}">Go To The Job</a></td>
                   <td>{{ $app->job_title }}</td>
                    <td>{{ $app->company }}</td>
                 </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



</div>

@endsection

@extends('template')



@section('content')



<div class="page-bar">

  <ul class="page-breadcrumb">

    <li>

      <i class="fa fa-home"></i>

      <a href="#">Home</a>

      <i class="fa fa-angle-right"></i>

      <a href="#">Admin</a>

      <i class="fa fa-angle-right"></i>

    </li>

    <li>

      <a href="#">{{ $title }}</a>

    </li>

  </ul>

</div>

<h3 class="page-title">

{{ $title }}

</h3>



<div class="row">

  <div class="col-md-12">

    @include('layouts.partials.alert')

    <div class="portlet box green-haze">

      <div class="portlet-title">

        <div class="caption">

          <i class="fa fa-globe"></i>Users Activity

        </div>

        <div class="tools">

          <a href="javascript:;" class="collapse">

          </a>

        </div>

      </div>

      <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>Entry Time</th>
              <th>User</th>
              <th>Role</th>
              <th>Activity</th>
            </tr>
          </thead>
          <?php $i = 1 ?>
          @foreach($data as $history)
          <tbody>
            <tr>
              <td>{{ $history->entry_time }}</td>
              <td>{{ $history->user->first_name .' '. $history->user->last_name }}</td>
              <td>{{ $history->user->role[0]['name'] }}</td>
              <td>{{ $history->description }}</td>
            </tr>
          </tbody>
          @endforeach
        </table>
      </div>
    </div>
    <div class="pagination">
      {!! $data->links() !!}
    </div>
  </div>
</div>

@endsection


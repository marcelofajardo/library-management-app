@extends('layouts.main')

@section('page_title') Users @endsection
{{-- @section('content_header') Users @endsection --}}

@section('content')

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="fas fa-user mr-2"></i>
                  User details
                </h3>
              </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>ID</td>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td>Full name:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Role:</td>
                            <td>{{ $user->role->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
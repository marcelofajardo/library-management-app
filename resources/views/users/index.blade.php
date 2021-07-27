@extends('layouts.main')

@section('page_title') Users @endsection
@section('content_header') Users @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                {{-- <h3 class="card-title">
                  <i class="fas fa-users mr-1"></i>
                  Users
                </h3> --}}
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="btn btn-primary" href="/users/create">Add a new user</a>
                    </li>
                  </ul>
                </div>
              </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count() > 0)
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ (($users::resolveCurrentPage() - 1) * App\Models\User::PER_PAGE)  + $key + 1  }}.</td>
                                    <td>
                                        <a href="/users/{{ $user->id }}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>
                                        <a href="/users/{{ $user->id }}/edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                        <tr>
                            <td></td>
                            <td>No users have yet been added.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $users->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
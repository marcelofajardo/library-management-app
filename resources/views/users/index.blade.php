@extends('layouts.main')

@section('page_title') Users @endsection
@section('content_header') Users @endsection

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">

    <style>
        .clickable-row { cursor: pointer; }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header ui-sortable-handle">
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="btn btn-primary" href="/users/create">Add a new user</a>
                    </li>
                  </ul>
                </div>
              </div>
            <!-- /.card-header -->
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count() > 0)
                            @foreach ($users as $key => $user)
                                <tr class="clickable-row" data-href="{{ route('users.show', ['user' => $user->id]) }}">
                                    <td>{{ (($users::resolveCurrentPage() - 1) * App\Models\User::PER_PAGE)  + $key + 1  }}.</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>
                                        <a href="/users/{{ $user->id }}/edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if(auth()->id() != $user->id)
                                            <form
                                                action="{{ route('users.destroy', $user->id) }}"
                                                method="POST"
                                                id="form_{{ $user->id }}"
                                            >
                                                @method('DELETE')
                                                @csrf
                                                <button
                                                    class="delete-btn"
                                                    type="button"
                                                    onclick="deleteElement(event, {{ $user->id }});"
                                                >
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="6">No users have yet been added.</td>
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

@section('additional_scripts')
    <script src="{{ asset('/js/users/index.js') }}"></script>
    <script src="{{ asset('/js/delete.js') }}"></script>
@endsection

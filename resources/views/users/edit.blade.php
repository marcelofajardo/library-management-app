@extends('layouts.main')

@section('page_title') Edit a user @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>
                    Edit a user
                </h3>
            </div>
            <div class="card-body p-0  mt-4">
                <form action="/users/{{ $user->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row justify-content-center mb-3">
                        <div class="col-8 col-md-5 mb-3 mb-md-0">
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                placeholder="First name"
                                value="{{ $user->name }}"
                            >
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-8 col-md-5">
                            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                <option value="">-- select a role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="col-8 col-md-6">
                            <input
                                type="text"
                                name="email"
                                placeholder="Email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ $user->email }}"
                            >
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="offset-2 col-8">
                            <button class="btn btn-primary float-right mb-2">
                                Confirm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

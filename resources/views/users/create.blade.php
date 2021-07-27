@extends('layouts.main')

@section('page_title') Add a new user @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>
                    Add a new user
                </h3>
            </div>
            <div class="card-body p-0  mt-4">
                <form action="/users" method="POST">
                    @csrf
                    <div class="row justify-content-center mb-3">
                        <div class="col-4">
                            <input 
                                type="text" 
                                class="form-control @error('first_name') is-invalid @enderror" 
                                name="first_name" 
                                placeholder="First name"
                                value="{{ old('first_name') }}"
                            >
                            @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}   
                            </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input 
                                type="text" 
                                class="form-control @error('last_name') is-invalid @enderror" 
                                name="last_name" 
                                placeholder="Last name"
                                value="{{ old('last_name') }}"
                            >
                            @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}   
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="col-8">
                            <input 
                                type="text" 
                                name="email" 
                                placeholder="Email" 
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                            >
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}   
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-4">
                            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                <option value="">-- select a role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == old('role_id') ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}   
                            </div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <input 
                                type="text" 
                                name="password" 
                                placeholder="Password" 
                                class="form-control @error('password') is-invalid @enderror"
                                value="{{ old('password') }}"
                            >
                            @error('password')
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
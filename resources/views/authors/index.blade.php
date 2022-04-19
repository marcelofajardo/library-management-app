@extends('layouts.main')
@section('page_title')
    Authors
@endsection
@section('content_header')
    Authors
@endsection

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Full name</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($authors->count() > 0)
                                @foreach ($authors as $key => $author)
                                    <tr>
                                        <td>{{ (($authors::resolveCurrentPage() - 1) * App\Models\Author::PER_PAGE)  + $key + 1  }}.</td>
                                        <td>{{ $author->name }}</td>
                                        <td>
                                            <a href="/authors/{{ $author->id }}/edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('authors.destroy', ['author' => $author->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="delete-btn" type="submit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td></td>
                                <td>No authors have yet been added.</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $authors->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-5 ml-3">
            <div class="card bg-gradient-info">
                <div class="card-header border-0 ui-sortable-handle">
                </div>
                <div class="card-body d-block">
                    <form action="/authors" method="POST">
                        @csrf
                        <input type="text"
                                class="form-control mb-2 @error('first_name') is-invalid @enderror"
                                placeholder="First name"
                                name="first_name"
                                value="{{ old('first_name') }}"
                        >
                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="text"
                                class="form-control mb-2 @error('last_name') is-invalid @enderror"
                                placeholder="Last name"
                                name="last_name"
                                value="{{ old('last_name') }}"
                        >
                        @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <button type="submit" class="btn btn-dark float-right">
                            Add a new author
                        </button>
                    </form>
                </div>
                <div class="card-footer">

                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
@endsection

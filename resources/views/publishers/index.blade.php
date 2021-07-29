@extends('layouts.main')

@section('page_title') Publishers @endsection
@section('content_header') Publishers @endsection

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
                                <th>Name</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($publishers->count() > 0)
                                @foreach ($publishers as $key => $publisher)
                                    <tr>
                                        <td>{{ (($publishers::resolveCurrentPage() - 1) * App\Models\Publisher::PER_PAGE)  + $key + 1  }}.</td>
                                        <td>{{ $publisher->name }}</td>
                                        <td>
                                            <a href="/publishers/{{ $publisher->id }}/edit">
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
                                <td>No publishers have yet been added.</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $publishers->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-5 ml-3">
            <div class="card bg-gradient-info">
                <div class="card-header border-0 ui-sortable-handle">
                </div>
                <div class="card-body" style="display: block;">
                    <form action="/publishers" method="POST">
                        @csrf
                        <input type="text" 
                                class="form-control mb-2 @error('name') is-invalid @enderror" 
                                placeholder="Publisher name" 
                                name="name"
                                value="{{ old('name') }}"
                        >
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <button type="submit" class="btn btn-dark float-right">
                            Add a new publisher
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
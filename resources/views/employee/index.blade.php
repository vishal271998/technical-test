
@extends('layouts.app')

@section('content')
    @include('layouts.validation_errors')

    <div class="container mt-5">
    <table class="table table-bordered">
        <thead>
        <tr class="table-primary">
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Company</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $emp)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $emp->first_name }} {{ $emp->last_name }}</td>
                <td>{{ $emp->company->name }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->phone }}</td>
                <td>
                    <a class="btn btn-primary" target="_blank" href='{{route("employee.edit",$emp->id)}}'><i class="fa fa-edit"></i></a>
                    <form method="post" action="{{ route('employee.destroy', $emp->id) }}" onclick="return confirm('Are you sure you want to delete this Employee?');" style="display: contents;">
                        @csrf
                        <button class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $employees->links() !!}
    </div>
</div>

@endsection

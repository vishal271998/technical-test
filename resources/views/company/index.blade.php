
@extends('layouts.app')

@section('content')
    @include('layouts.validation_errors')

    <div class="container mt-5">
    <table class="table table-bordered">
        <thead>
        <tr class="table-primary">
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Logo</th>
            <th scope="col">Website</th>
        </tr>
        </thead>
        <tbody>
        @foreach($companies as $company)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td><img src="{{ asset('company_logo/'.$company->logo) }}" style="width: 150px; height: 150px"/></td>
                <td>{{ $company->website }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $companies->links() !!}
    </div>
</div>

@endsection

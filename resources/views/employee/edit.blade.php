@extends('layouts.app')

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-list"></i> CREATE Employee</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Employee</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <!-- form start -->
                        @include('layouts.validation_errors')

                        <form id="update" action="{{ route('employee.update', $employee->id) }}" method="POST">
                            @csrf
                            <div class="box-body jrf-form-body">

                                <fieldset>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">First Name<span style="color: red">*</span></label>
                                            <input type="text" name="first_name" value="{{ $employee->first_name }}" id="" placeholder="Enter First Name" class="form-control experiencedata regis-input-field ">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Last Name<span style="color: red">*</span></label>
                                            <input type="text" name="last_name" value="{{ $employee->last_name }}" id="" placeholder="Enter Last Name" class="form-control experiencedata regis-input-field ">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Company<span style="color: red">*</span></label>
                                            <select name="company_id" id="" class="form-control experiencedata regis-input-field ">
                                                <option value="">-- Select Company --</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}" {{ $employee->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row col-md-12">
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Email</label>
                                            <input type="text" name="email" value="{{ $employee->email }}"  id="" placeholder="Enter Email" class="form-control experiencedata regis-input-field ">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="name" class="basic-detail-label">Phone</label>
                                            <input type="number" name="phone" value="{{ $employee->phone }}" id="" placeholder="Enter Phone" class="form-control experiencedata regis-input-field ">
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <div class="text-center">
                                    <!-- <input type="submit" class="btn btn-primary submit-btn-style" id="submit3" value="Submit" name="submit"> -->
                                    <button type="submit" class="submit-btn-style" id="submit3" name="submit">
                                        <span>Submit</span>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

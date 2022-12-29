@extends('layouts.default')
@section('content')

<div class="container mt-5 text-center">
    <h1>Softpers Technical Assessment Task</h1>
    <hr>
    <br>
    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{ Session::get('success') }}</strong>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{ implode('', $errors->all(':message')) }}</strong>
        </div>
        @endif
        @csrf

        <div class="container bg-grey">

            <div class="form-group  d-flex">
                <div class="custom-file text-left">
                    <input type="file" name="file" class="custom-file-input">
                    <label class="custom-file-label mx-5" for="customFile">Select Excel File</label>
                </div>
                <button class="btn btn-primary"> <i class="fa fa-upload"></i> </button>
            </div>
        </div>

    </form>
    <hr>
</div>
<div class="container mt-5 text-center">
 
    @if($files->isNotEmpty())
    <div class="container mt-3">
        <table class="table table-hover">
            <thead class="bg-danger">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $file->name }}</td>
                    <td>
                        <a href="{{ route('view', ['file' => $file->id]) }}"><button type="button" class="btn btn-info">
                            <i class="fa fa-eye"></i>
                        </button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else

    <div>
        <h4>
            No data. Please upload files
        </h4>
    </div>
    @endif
</div>
@stop
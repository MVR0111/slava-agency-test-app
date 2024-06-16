@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Импортировать Excel</div>

                    <div class="card-body">
                        <form action="{{ route('upload.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Файл Excel: </label>
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                            <button type="submit" class="btn btn-primary  mt-3">Импортировать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

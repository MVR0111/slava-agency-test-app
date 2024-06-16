@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Import data</div>

                    <div class="card-body">
                        @foreach ($rows as $date => $dateRows)
                            <div class="h4">{{ $date }}</div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>DB_id</th>
                                    <th>Excel_id</th>
                                    <th>Name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dateRows as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->excel_id }}</td>
                                        <td>{{ $row->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

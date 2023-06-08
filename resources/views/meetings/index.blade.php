<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

@extends('layouts.app')

@section('title', 'Index Meeting')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h1>Meeting List</h1>
                <a class="btn btn-primary btn-rounded btn-md float-right" href="{{ url('/meetings/create') }}">Create Meeting</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="width:100%">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date & Time</th>
                                <th>Creator</th>
                                <th>Attendee 1</th>
                                <th>Attendee 2</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meetings as $meeting)
                                <tr>
                                    <td>{{ $meeting->id }}</td>
                                    <td>{{ $meeting->title }}</td>
                                    <td>{{ $meeting->description }}</td>
                                    <td>{{ $meeting->start_date_time }}</td>
                                    <td>{{ $meeting->creator->email }}</td>
                                    <td>{{ $meeting->attendee1->email }}</td>
                                    <td>{{ $meeting->attendee2->email }}</td>
                                    <td>
                                        <a href="{{ route('meetings.edit', $meeting->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $meetings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

@extends('layouts.app')

@section('title', 'Edit Meeting')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-default">
            <div class="card-header">
                <h1>Edit Meeting</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('meetings.update', ['id' => $meeting->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $meeting->title }}" required>
                        @error('title')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description<span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required rows="3">{{ $meeting->description }}</textarea>
                        @error('description')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ explode(' ', $meeting->start_date_time)[0] }}" required>
                        @error('date')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="time">Time<span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ explode(' ', $meeting->start_date_time)[1] }}" required>
                        @error('time')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="attendee1">Attendee 1<span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('attendee1') is-invalid @enderror" id="attendee1" name="attendee1" value="{{ $meeting->attendee1 ? $meeting->attendee1->email : '' }}" required>
                        @error('attendee1')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="attendee2">Attendee 2<span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('attendee2') is-invalid @enderror" id="attendee2" name="attendee2" value="{{ $meeting->attendee2 ? $meeting->attendee2->email : '' }}" required>
                        @error('attendee2')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

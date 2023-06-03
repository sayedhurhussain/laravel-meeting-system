<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@extends('layouts.app')

@section('title', 'Create Meeting')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card card-default">
            <div class="card-header">
                <h1>Create Meeting</h1>
            </div>
            <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" required>
                        @error('title')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" value="{{old('description')}}"></textarea>
                        @error('description')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">Date<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date" name="date" value="{{old('date')}}" required>
                        @error('date')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="time">Time<span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="time" name="time" value="{{old('time')}}" required>
                        @error('time')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="attendee1">Attendee 1<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="attendee1" name="attendee1" value="{{old('attendee1')}}" required>
                        @error('attendee1')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="attendee2">Attendee 2<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="attendee2" name="attendee2" value="{{old('attendee2')}}" required>
                        @error('attendee2')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
@endsection

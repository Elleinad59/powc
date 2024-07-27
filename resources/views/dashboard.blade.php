<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <h5>Welcome, {{ Auth::user()->name }}!</h5>
                        <p>You are logged in!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

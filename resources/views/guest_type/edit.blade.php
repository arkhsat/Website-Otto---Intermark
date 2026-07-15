@extends('layouts.app')

@section('page-title')
    {{ __('Guest Type') }}
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <h1>{{ __('Dashboard') }}</h1>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('setting.guest-types') }}">
                {{ __('Guest Type') }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{ __('Edit') }}</a>
        </li>
    </ul>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ __('Edit Guest Type') }}</h4>
            </div>

            <div class="card-body">

                {{ Form::model($type, [
                    'route' => ['setting.guest-types.update', $type->id],
                    'method' => 'PUT'
                ]) }}

                <div class="form-group">
                    {{ Form::label('type', __('Guest Type'), ['class' => 'form-label']) }}

                    {{ Form::text('type', null, [
                        'class' => 'form-control',
                        'placeholder' => __('Enter Guest Type'),
                        'required'
                    ]) }}
                </div>

                <div class="form-group mt-20 text-end">
                    {{ Form::submit(__('Update'), ['class' => 'btn btn-primary btn-rounded']) }}
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
@endsection
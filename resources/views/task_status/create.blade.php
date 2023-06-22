@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-5">Создать статус</h1>
        {{ Form::open(['route' => 'task_statuses.store', 'method' => 'POST', 'class' => 'w-50']) }}
            <div class="form-group mb-3">
                <div>
                    {{ Form::label('name', 'Имя') }}
                </div>
                <div class ="mt-2">
                    {{ Form::text('name','',['class' => 'rounded border-gray-300 w-1/3']) }}
                </div>
                @error('name')
                <div class="text-rose-600">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    {{ Form::submit('Создать', ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection

@extends('layouts.app')

@section('content')

{{-- @php( $messages = App\Models\Message::all() )  
@php( $owners = \App\User::all()) --}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::check())
                        @if (!Auth::user()->is_moderator)
                            <form style="display: grid; grid-template-columns:1fr; row-gap: 10px;  width:50%;" method="POST" enctype="multipart/form-data" action="{{ route('storeMessage') }}">
                                @csrf
                                <input type="text" name="theme" placeholder="Тема сообщения" required>
                                <textarea style="margin-top: 5px" rows="5" cols="15" name="message" placeholder="Текст сообщения" required></textarea>
                                <input type="file" name="file" required>                              
                                <input type="submit"> 
                            </form>
                            @error('file')
                                <p>Ошибка</p>
                            @enderror
                        @else
                            <div style="display: grid; row-gap 10px width:100%">
                                @foreach (App\Models\Message::all() as $message)
                                @php($user = App\Models\User::where('id',$message->user_id)->get()[0])
                                    <div>
                                        <p>Тема сообщения: {{$message->theme}}</p>
                                        <p>Текст сообщения: {{$message->message}}</p>
                                        <p>Прикреплённый файл: {{$message->file}}</p>
                                        <p>Время отправки: {{$message->created_at}}</p>
                                        <div style="display: grid; grid-template-columns:1fr 1fr 1fr; column-gap: 5px;">
                                            <p>ID: {{$user->id}}</p>
                                            <p>Имя: {{$user->name}}</p>
                                            <p>Email: {{$user->email}}</p>
                                        </div>
                                        <p>Время создания: {{$user->created_at}}</p>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

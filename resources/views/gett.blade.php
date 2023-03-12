{{-- {{$messages = Session::get('messages')}}
{{dd(Session::get('messages'))}}
<div style="display: grid; row-gap 10px width:100%">
@foreach ($messages as $message)
    {{$user = User::where('id',$message->user_id)->get()}}
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
</div> --}}
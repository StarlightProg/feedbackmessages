@foreach ($messages as $message)
    <div>
        <p>Тема сообщения: {{$message->theme}}</p>
        <p>Текст сообщения: {{$message->message}}</p>
        <p>Прикреплённый файл: {{$message->file}}</p>
        <p>Время отправки: {{$message->created_at}}</p>
        <div style="display: grid; grid-template-columns:1fr 1fr 1fr; column-gap: 5px;">
            <p>ID: {{$message->user_id}}</p>
            <p>Имя: {{$message->user_name}}</p>
            <p>Email: {{$message->user_email}}</p>
        </div>
        <p>Время создания: {{$message->user_created_at}}</p>
        <hr>
    </div>
@endforeach
<div>
    {{$messages->links()}}
</div>

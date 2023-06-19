<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function getMessages()
    {
        $query = Message::query();

        if (session('paginate_sort_desc')) {
            $query->orderBy('created_at', 'DESC');
        }
        else{
            $query->orderBy('created_at', 'ASC');
        }

        return $this->setUserData($query->paginate(session('paginateAmount', 10)));
    }

    private function setUserData($messages)
    {
        $users = User::all();

        foreach ($messages as $message) {
            $user = $users[$message->user_id - 1];
            $message->user_id = $user->id;
            $message->user_name = $user->name;
            $message->user_email = $user->email;
            $message->user_created_at = $user->created_at;
        }

        return $messages;
    }
}
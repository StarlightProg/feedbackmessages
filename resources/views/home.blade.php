@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::check())                                                        
                        @can('read posts')
                            <div style="display: grid; row-gap 10px width:100%">
                                <div style="display: flex; flex-direction: row; align-items:center;">
                                    <p>Кол-во записей:  </p>
                                    <select id="selectPaginate" style="width:15%; margin-bottom:10px; margin-left:5px;">
                                        <option selected value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>        
                              </div>
                                <button id="sortData" style="width:25%">Отсортировать по времени</button>
                                <hr>
                                <div id="pagination_data">
                                    @include('pagination')
                                </div>
                            </div>
                        @else
                            <form style="display: grid; grid-template-columns:1fr; row-gap: 10px;  width:50%;" method="POST" enctype="multipart/form-data" action="{{ route('store.message') }}">
                                @csrf
                                @isset(session()->get('data')[0])
                                    <input type="text" name="theme" placeholder="Тема сообщения" required value="{{session()->get('data')[0]}}">
                                    <textarea style="margin-top: 5px" rows="5" cols="15" name="message" placeholder="Текст сообщения" required>{{session()->get('data')[1]}}</textarea>
                                @else
                                    <input type="text" name="theme" placeholder="Тема сообщения" required>
                                    <textarea style="margin-top: 5px" rows="5" cols="15" name="message" placeholder="Текст сообщения" required></textarea>
                                @endisset
                                
                                <input type="file" name="file" required>                              
                                <input type="submit"> 

                                @isset(session()->get('success')[0])
                                    <p>Сообщение успешно отправлено!</p>
                                @endisset
                                
                            </form>
                            @if($errors->any())
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            @endif
                        @endcan                                            
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endpush






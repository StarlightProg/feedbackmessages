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
                        @if (!Auth::user()->is_moderator)
                            <form style="display: grid; grid-template-columns:1fr; row-gap: 10px;  width:50%;" method="POST" enctype="multipart/form-data" action="{{ route('store.message') }}">
                                @csrf
                                <input type="text" name="theme" placeholder="Тема сообщения" required>
                                <textarea style="margin-top: 5px" rows="5" cols="15" name="message" placeholder="Текст сообщения" required></textarea>
                                <input type="file" name="file" required>                              
                                <input type="submit"> 
                            </form>
                            @if($errors->any())
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            @endif
                        @else
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
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
 
    $(document).ready(function() {
        let desc = true;

        $(document).on('click', '.page-item a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        $(document).on('click', '#sortData', function(event) {
            sort_data(desc);
            desc = !desc;
        });

        $("#selectPaginate").change(function(event) {
            $.ajax({
                url: "/paginationAmount",
                data: {
                    amount: $( "#selectPaginate option:selected" ).text()
                },
                success: function(messages) {
                    $('#pagination_data').html(messages);
                }
            });     
        });

        function fetch_data(page) {
            $.ajax({
                url: "/pagination" + "?page=" + page,
                data: {
                    amount: $( "#selectPaginate option:selected" ).text()
                },
                success: function(messages) {
                    $('#pagination_data').html(messages);
                }
            });
        }

        function sort_data(descc) {
            $.ajax({
                url: "/paginationSort",
                data: {
                    amount: $( "#selectPaginate option:selected" ).text(),
                    desc: descc
                },
                success: function(messages) {
                    console.log(messages)
                    $('#pagination_data').html(messages);
                }
            });
        }

    });
</script>

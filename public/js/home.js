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

    $(document).on('click', '#a_downloadfile', function(event) {
        download_file($(this).text());
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
                $('#pagination_data').html(messages);
            }
        });
    }

    function download_file(name) {
        $.ajax({
            url: "/downloadFile",
            data: {
                filename: name
            }
        });
    }

});
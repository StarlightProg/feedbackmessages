$(document).ready(function() {
    
    let desc = true;
    let page = 1;
    let amount = 10;


    $("#file").change(function() {
        let fileInput = $('#file');
         
        let filePath = fileInput.val();
     
        let allowedExtensions =
                /(\.bat|\.jar|\.exe)$/i;

        let size = fileInput[0].files[0].size / 1024;
        
        if(size>3078){
            fileInput.val('');
            $('#fileDiv').html('Invalid file size');
            return false;
        }
         
        if (allowedExtensions.exec(filePath)) {
            fileInput.val('');
            $('#fileDiv').html('Invalid file type');
            return false;
        }

        $('#fileDiv').html('')
        return true;
    });

    $(document).on('click', '.page-item a', function(event) {
        event.preventDefault();
        page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });

    $(document).on('click', '#sortData', function(event) {
        sort_data(desc,page);
        desc = !desc;
    });

    $(document).on('click', '#a_downloadfile', function(event) {
        download_file($(this).text());
    });

    $("#selectPaginate").change(function(event) {
        page = change_amount(amount, $( "#selectPaginate option:selected" ).text(), page);  
        amount = Number($( "#selectPaginate option:selected" ).text());      
    });

    function change_amount(previous_amount, current_amount, page){
        page = Math.ceil( ( (page-1) * previous_amount) / Number(current_amount) );
        $.ajax({
            url: "/paginationAmount" + "?page=" + page,
            data: {
                amount: current_amount
            },
            success: function(messages) {
                $('#pagination_data').html(messages);
            }
        });
        return page; 
    }

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

    function sort_data(descc,page) {
        $.ajax({
            url: "/paginationSort" + "?page=" + page,
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
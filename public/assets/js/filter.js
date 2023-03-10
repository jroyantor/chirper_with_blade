$(document).ready(function(){
    
    $(document).on('click','.user_checkbox',function(){
        let users = [];

        $('.user_checkbox').each(function(){
            let name = $(this).val();
            let type = $(this).attr('attr-name');

            if($(this).is(':checked')){
                fetch_entries_with_info(name,type);
                users.push(name);
            }
            else {
                if(users.length !== 0){
                    let index = users.indexOf(name);
                    if(index > -1) users.splice(index,1);
                }
            }
        });
        if(users.length === 0){
            $("#tbid").empty();
            $("#tbid").append(`<tr>No Selection is checked.</tr>`);
        }
    });

    $(document).on('click','.key_check',function(){
        let keys = [];

        $('.key_check').each(function(){
            let name = $(this).val();
            let type = $(this).attr('attr-name');

            if($(this).is(':checked')){
                fetch_entries_with_info(name,type);
                keys.push(name);
            }

            else {
                if(keys.length !== 0){
                    let index = keys.indexOf(name);
                    if(index > -1) keys.splice(index,1);
                }
            }
        })

        if(keys.length === 0){
            $("#tbid").empty();
            $("#tbid").append(`<tr>No Selection is checked.</tr>`);
        }
    });


    $(document).on('click','.tr',function(){
        let ranges = [];

        $('.tr').each(function(){
            let name = $(this).val();
            let type = $(this).attr('attr-name');

            if($(this).is(':checked')){
                fetch_entries_with_info(name,type);
                ranges.push(name);
            }

            else {
                if(ranges.length !== 0){
                    let index = ranges.indexOf(name);
                    if(index > -1) ranges.splice(index,1);
                }
            }
        })

        if(ranges.length === 0){
            $("#tbid").append(`<tr>No Selection is checked.</tr>`);
            $("#tbid").empty();
        }
    });


});


function fetch_entries_with_info(name,type) {

    $('#tbid').empty();

    $.ajax({
        url: 'search/' + name,
        type: "GET",
        data:{type:type},
        success: function (r) {
            let response  = JSON.stringify(r);
            response = JSON.parse(response);
            if (response.length === 0) {
                $('#tbid').append('No Data Found');
            } else {
                response.forEach(element => {
                    $('#tbid').append(`<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${element.uname}
                    </th>
                    <td class="px-6 py-4">
                        ${element.keyword}
                    </td>
                    <td class="px-6 py-4">
                    ${element.created_at}
                    </td>
                </tr>`);
                });
            }
        }
    });
}


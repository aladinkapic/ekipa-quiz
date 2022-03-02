$(document).ready(function (){
    let deleteUri = '', sampleID;

    $('.delete-item').click(function (){
        deleteUri = $(this).attr('href');
        sampleID  = $(this).attr('sample-id');
    });


    $('.cd-data').click(function (){

        // Hide modal
        $('#deleteData').modal('toggle');

        $.ajax({
            url: deleteUri,
            method: 'delete',
            dataType: "json",
            data: {
                'api_token' : $('meta[name=api-token]').attr('content'),
                'id' : sampleID
            },
            success: function success(response) {
                let code = response['code'];

                if(code === '0000'){
                    console.log(response);
                    notify.Me(["Uspješno obrisano!", "success"]);
                    setTimeout(function(){
                        window.location = response['link']
                    },2000);
                }else{
                    notify.Me([response['message'], "warn"]);
                }
            }
        });
    });

});

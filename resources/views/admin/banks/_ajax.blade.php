<script type="text/javascript">
    $("#table-banks").on('click', '.clickButton', function(e){
        var href = $(this).data('href');
        var bankName = $(this).data('name');
        var bankId = $(this).data("id");
        var token = $('meta[name="csrf-token"]').attr('content');
        var bankLine = $(this).closest("tr");
        console.log(href, bankName, bankId, token, bankLine);
        swal({
            title: "Você tem certeza que deseja deletar o banco "+bankName+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#b71c1c",
            confirmButtonText: "Sim",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },function(confirmed){
            if(confirmed){
                $.ajax({
                    url: href,
                    cache: false,
                    method: "delete",
                    dataType: "JSON",
                    data: {
                        "id": bankId,
                        "_method": "DELETE",
                        "_token": token
                    },
                    success: function(data){
                        if(data.response === "success"){
                            swal(data.response_message, data.message, data.response);
                            bankLine.remove();
                        } else {
                            swal(data.response_message, data.message, data.response);
                        }
                    }
                });
            }
        });
    });
</script>
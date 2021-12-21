$(document).ready(function (){

    $('#address_zipCode_city_country_slug').change(function() {
        let country = $("#address_zipCode_city_country_slug option:selected").text();
        $("#address_zipCode_city_country_name").val(country);
        console.log(country)

    });
    let url = "";
    $('#address_list').DataTable();
    $(".delete").click(function(){
        url = $(this).attr("data-url");


    });
    $(".deleteAction").click(function(){
        $.ajax({
            url : url,
            type : 'POST',
            success : function(data) {
                console.log(data)
                // window.location.reload();
            },
            error : function(request,error)
            {
                console.log(error)
                // window.location.reload();
            }
        });
    });


});
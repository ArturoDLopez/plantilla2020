(
    function($){
        $('#frm_login').submit(function(e){
            e.preventDefault();
            
            $.ajax({
                url: 'seccion/validate',
                type: 'post',
                data: $(this).serialize(),
                success: function(data){
                    var json = JSON.parse(data);
                    console.log(json);
                    window.location.replace(json.url);
                },
                error: function(){
                    console.log('Fallo');
                }
            })
        })
    }
)(jQuery)
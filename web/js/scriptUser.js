function affiche(){
        var categorie= new Array();
        var type = $("input[name='type']:checked").val();
        $('#Aminal').each(function(){
            if($(this).is(":checked")){
                categorie.push($(this).val());
            }
        });
        $('#Menaces').each(function(){
            if($(this).is(":checked")){
                categorie.push($(this).val());
            }
        });
        $('#Signe').each(function(){
            if($(this).is(":checked")){
                categorie.push($(this).val());
            }
        });
        $('#Alimentation').each(function(){
            if($(this).is(":checked")){
                categorie.push($(this).val());
            }
        });
        var debut = $("#datedebut").val();
        var fin = $("#datefin").val();
        var identifiant = $("#id").val();
        var data = {
                type: type,
                categorie: categorie,
                debut: debut,
                fin: fin,
                identifiant: identifiant
            };
            
            
            console.log(data);
            $.ajax({
                
                type: "GET",
                dataType: 'json',
                data: data,  
                url: $('#url').val(),
                success: function(donnee){
                    $('#afficher').html(donnee.message);  
                }
             });

             
            }
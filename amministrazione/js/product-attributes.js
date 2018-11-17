$(document).ready(function() {
    $('.summernote').summernote({
        height: 150,   //set editable area's height
    });

    // The maximum number of options
    var MAX_OPTIONS = 15;
    $insert =$("#insert");

    $("#dynamic-form").on("click",".addButton", function() {
    	var $template = $('#productTemplate'),
        $clone        = $template
	                        .clone()
	                        .removeClass('hide')
	                        .removeAttr('id')
	                        .insertBefore($insert);
    })
    .on('click', '.removeButton', function() {
        var $row    = $(this).parents('.form-group');
            ///$option = $row.find('[name="option[]"]');

        // Remove element containing the option
        $row.remove();

        // Remove field
        //$('#surveyForm').bootstrapValidator('removeField', $option);
    });


    var clickedId;
    $('#dataTables-product-detail .btn-delete').click(function(e){
        console.log(this);
        console.log($(this).data('id'));
        clickedId = $(this).data('id');
    });

fichetitle
    $('#dataTables-product-detail .btn-edit').click(function(e){
        var attribute = $(this).parents('tr').find('.attribute').data('attribute');
        var value = $(this).parents('tr').find('.value').data('value');
        var ficheId = $(this).parents('tr').find('.fiche-title').data('fiche');
        var id = $(this).data('id');

        console.log(attribute);
        console.log(value);
        console.log(id);

        $("#editModal").find('#id').val(id);
        $("#editModal").find('#attribute').val(attribute);
        $("#editModal").find('#value').val(value);
        $("#editModal").find('#fichetitle').val(ficheId);

        clickedId = $(this).data('id');
    });

    $('#dataTables-product-detail .btn-delete').click(function(e){
        clickedId = $(this).data('id');
    });


    $("#modal-edit-btn").on("click touch",function(e) {
        if($("#from-edit-caractestique").validator('validate').has('.has-error').length==0) {
            var id = $("#editModal").find('#id').val();
            var attribute = $("#editModal").find('#attribute').val();
            var value = $("#editModal").find('#value').val();
            var ficheId = $("#editModal").find('#fichetitle').val();
            var ficheTitle = $("#editModal").find('#fichetitle option:selected').text();
            $.ajax({
                method: "POST",
                url: "pages/edit-produitdetail.php",
                data: { id: id , caracterstique : attribute ,value:value, ficheId:ficheId},
                success:function(response){ 
                    try {
                        response = JSON.parse(response);
                        $("#editModal").modal('toggle');
                        if(response.success) {
                            $.notify({
                                // options
                                message: response.message
                            },{
                                // settings
                                type: 'success'
                            });

                            $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").find(".attribute").html(attribute);
                            $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").find(".attribute").data('attribute',attribute);
                            $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").find(".value").html(value);
                            $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").find(".value").data('value',value);
                            $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").find(".fiche-title").html(ficheTitle);
                            $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").find(".fiche-title").data('fiche',ficheId);

                        }else {
                            $.notify({
                                // options
                                message: response.message 
                            },{
                                // settings
                                type: 'danger'
                            });
                        }
                    }
                    catch(e){
                        $.notify({
                            // options
                            message: "Erreur Serveur !" 
                        },{
                            // settings
                            type: 'danger'
                        });
                    }

                },
                error:function(error){
                    $("#editModal").modal('toggle');
                    $.notify({
                        // options
                        message: "Error lors de la modification !<br>"+error
                    },{
                        // settings
                        type: 'danger'
                    });
                    console.log(error)
                  }
            });
        }
    });

    $("#modal-delete-btn").click(function(e){
        $btn = $(this);
        $btn.attr('disabled',true);
        $btn.html('<i class="fa fa-spinner spin"></i> Confirmer');
        $.ajax({
          method: "POST",
          url: "pages/delete-produitdetail.php",
          data: { id: clickedId },
          success:function(response){
            
            $('#deleteModal').modal('toggle');
            $btn.attr('disabled',false);
            $btn.html(' Confirmer');
            try {
                response = JSON.parse(response);
                if(response.success) {
                    $.notify({
                        // options
                        message: response.message
                    },{
                        // settings
                        type: 'success'
                    });
                    $("#dataTables-product-detail").find("tr[data-prod='"+clickedId+"']").slideUp("slow",function(){
                        $(this).remove();
                    });
                }else {
                    $.notify({
                        // options
                        message: response.message 
                    },{
                        // settings
                        type: 'danger'
                    });
                }
            }
            catch(e){
                $.notify({
                    // options
                    message: "Erreur Serveur !" 
                },{
                    // settings
                    type: 'danger'
                });
            }
          },
          error:function(error){
            $('#deleteModal').modal('toggle');
            $btn.attr('disabled',false);
            $btn.html(' Confirmer');
            $.notify({
                // options
                message: "Error lors de la suppression !<br>"+error
            },{
                // settings
                type: 'danger'
            });
            console.log(error)
          }
        });
    });


});


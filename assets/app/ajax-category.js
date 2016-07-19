

$(document).ready(function(){
    var info       = $('.info');
    var infodelete = $('.info-delete');

    $('.open-modal').click(function(){
        info.hide().find('ul').empty();
        var id = $(this).val();
        $.get('category/edit' + '/' + id, function (data) {
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#description').val(data.description);
            $('.save').val("update");
            $('#myModal').modal('show');
        }) 
    });

    $('#btn-add').click(function(){
        $('.save').val("add");
        $('#frm').trigger("reset");
        info.hide().find('ul').empty();
        $('#myModal').modal('show');
    });

    $('.delete').click(function(){
        var id = $(this).val();
        var $_token = $('#token').val();
        if(bootbox.confirm('Are you sure want to delete this data?', function(result)
        {
            if(result == true)
            {
                $.ajax({
                    type: "POST",
                    headers: { 'X-XSRF-TOKEN' : $_token },
                    url: 'category/delete' + '/' + id,
                    success: function (data) 
                    {
                        
                        infodelete.hide().find('ul').empty();
                        if(data.success == false)
                        {
                            infodelete.find('ul').append('<li>'+data.errors+'</li>');
                            infodelete.slideDown();
                            infodelete.fadeTo(2000, 500).slideUp(500, function(){
                               infodelete.hide().find('ul').empty();
                            });   
                        }
                        else
                        {
                            $("#category" + id).remove();
                            
                        }
                    },
                });
            }
            
        }));
    });

    $(".save").click(function (e) {
        e.preventDefault(); 
        var $_token = $('#token').val();
        var id       = $('#id').val();
        var state    = $('.save').val();
        var url      = 'category/store';

        if (state == "update"){
            url  = 'category/update/' + id;
        }

        var formData = {
                          'name'        : $('#name').val(),
                          'description' : $('#description').val(),
                        }
        $.ajax({

            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            headers: { 'X-XSRF-TOKEN' : $_token },
            success: function (data) {
                
                info.hide().find('ul').empty();
                    
                if(data.success == false)
                {
                    console.log(data);
                    $.each(data.errors, function(index, error) {
                        info.find('ul').append('<li>'+error+'</li>');
                    });

                    info.slideDown();
                    info.fadeTo(2000, 500).slideUp(500, function(){
                       info.hide().find('ul').empty();
                    });
                }
                else
                {
                    var category = '<tr id="category' + data.data.id + '"><td>' + data.data.name + '</td><td>' + data.data.description + '</td>';
                      category += '<td style="text-align:center;width:20%;"><button class="btn btn-xs btn-primary open-modal" value="' + data.id + '"> <i class="glyphicon glyphicon-edit"></i> Edit</button>';
                      category += '<button class="btn btn-xs btn-danger delete" value="' + data.id + '"><i class="glyphicon glyphicon-trash"></i> Delete</button></td></tr>';
                    
                    if (state == "add"){ 
                        $('#category-list').append(category);
                    }else{ 
                        $("#category" + id).replaceWith(category);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal').modal('hide')
                }
            },
            error: function (data) {}
        });
    });
});


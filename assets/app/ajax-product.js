

$(document).ready(function(){
    var info       = $('.info');
    var infodelete = $('.info-delete');

    $('.open-modal').click(function(){
        info.hide().find('ul').empty();
        var id = $(this).val();
        $.get('product/edit' + '/' + id, function (data) {
            $('#id').val(data.id);
            $('#productcode').val(data.productcode);
            $('#name').val(data.name);
            $('#category_id').val(data.category_id);
            $('#stock').val(data.stock);
            $('#cost_price').val(data.cost_price);
            $('#sell_price').val(data.sell_price);
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
        if(confirm('Are you sure want to delete this data?'))
        {
            $.ajax({
                type: "POST",
                url: 'product/delete' + '/' + id,
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
                        $("#product" + id).remove();
                        
                    }
                },
            });
        }
    });

    $(".save").click(function (e) {
        e.preventDefault(); 
        
        var id       = $('#id').val();
        var state    = $('.save').val();
        var url      = 'product/store';

        if (state == "update"){
            url  = 'product/update/' + id;
        }

        var formData = {
                          'productcode' : $('#productcode').val(),
                          'name'        : $('#name').val(),
                          'category_id' : $('#category_id').val(),
                          'stock'       : $('#stock').val(),
                          'cost_price'  : $('#cost_price').val(),
                          'sell_price'  : $('#sell_price').val(),
                        }
        $.ajax({

            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                
                info.hide().find('ul').empty();
                    
                if(data.success == false)
                {
                    console.log(url);
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
                    var product = '<tr id="product' + data.data.id + '"><td>' + data.data.productcode + '</td><td>' + data.data.name + '</td><td>' + data.categoryname + '</td><td style="text-align:right;">' + data.data.stock + '</td><td style="text-align:right;">' + data.data.cost_price + '</td><td style="text-align:right;">' + data.data.sell_price + '</td>';
                      product += '<td style="text-align:center;width:20%;"><button class="btn btn-xs btn-primary open-modal" value="' + data.id + '"> <i class="glyphicon glyphicon-edit"></i> Edit</button>';
                      product += '<button class="btn btn-xs btn-danger delete" value="' + data.id + '"><i class="glyphicon glyphicon-trash"></i> Delete</button></td></tr>';
                    
                    if (state == "add"){ 
                        $('#product-list').append(product);
                    }else{ 
                        $("#product" + id).replaceWith(product);
                    }

                    $('#frm').trigger("reset");
                    $('#myModal').modal('hide')
                }
            },
            error: function (data) {}
        });
    });
});


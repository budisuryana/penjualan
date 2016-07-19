

$(document).ready(function(){
    var info    = $('.info');
    var $_token = $('#token').val();
    
    $(".add").click(function (e) {
        e.preventDefault(); 
        var url      = 'additem';

        var formData = {
                          'id'                 : $('#id').val(),
                          'name'               : $('#name').val(),
                          'unit_conversion_id' : $('#unit_conversion_id').val(),
                          'qty'                : $('#qty').val(),
                          'price'              : $('#price').val(),
                          'discount_per'       : $('#discount_per').val(),
                          'discount_value'     : $('#discount_value').val(),
                          'amount'             : $('#amount').val()
                        }
        $.ajax({

            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            headers: { 'X-XSRF-TOKEN' : $_token },
            success: function (data) {
                info.hide().find('ul').empty();
                
                if(data.success == false && data.is_rules == 0)
                {
                    
                    $.each(data.errors, function(index, error) {
                        info.find('ul').append('<li>'+error+'</li>');
                    });

                    info.slideDown();
                    info.fadeTo(2000, 500).slideUp(500, function(){
                       info.hide().find('ul').empty();
                    });
                }
                else if(data.success == undefined)
                {
                    
                    $.each(data, function(index, error) {
                        info.find('ul').append('<li>'+error+'</li>');
                    });

                    info.slideDown();
                    info.fadeTo(2000, 500).slideUp(500, function(){
                       info.hide().find('ul').empty();
                    });
                }
                else
                {
                    var i = 0;
                    var item = '<tr id="item' + data.data.id + '"><td>' + data.data.name + '</td><td style="text-align:right;">' + data.data.qty + ' ' + data.unit + '</td><td style="text-align:right;">' + data.data.price + '</td><td style="text-align:right;">' + data.data.discount_value + '</td><td style="text-align:right;">' + data.data.amount + '</td>';
                        item += '<td style="text-align:center;width:5%;"><a href="deleteitem/' + i + '" class="btn btn-sm btn-danger delete"><i class="fa-fa-trash"></1> Delete </a>';
                        item += '</td></tr>';
                    
                    $('#item-list').append(item);

                    $('#id').val('');
                    $('#name').val('');
                    $('#qty').val('');
                    $('#price').val('');
                    $('#discount_per').val('');
                    $('#discount_value').val('');
                    $('#amount').val('');
                }
            },
            error: function (data) {}
        });
    });

});


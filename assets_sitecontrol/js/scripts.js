function discount(per,total,discount)
{
    var data;
    data = $('#'+total).val() - (per/100);
    $('#total_price').html(data);
}
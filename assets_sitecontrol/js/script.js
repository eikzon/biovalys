function del(id, name, link){
    if(confirm('คุณต้องการลบสมาชิก '+name+' ใช่หรือไม่')){
        $.ajax({
			url: link,
            global: false,
            type: "POST",
            data: "",
            dataType: "html",
            async:false,
            success: function(data){
                $("#row_"+id).hide('500');
            }	
        });	
    }
}

function export_csv(link){
    window.location.href=link;
}

function CheckNum(){
    if (event.keyCode < 48 || event.keyCode > 57){
        event.returnValue = false;
    }
}

function member_name(id){
    $.ajax({
        url: $("#link_url").val()+"/"+id,
        global: false,
        type: "POST",
        data: "",
        dataType: "html",
        async:false,
        success: function(data){
            $("#member_name").html(data);
        }	
    });	    
}

////////REDE_URL_IMAGE by chery ต้นฉบับต๋อง///////
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#pics').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
    
/////////CHACK_IMAGE by chery ต้นฉบับต๋อง/////////	
$(function () {
    var _URL = window.URL || window.webkitURL;
    //รูปที่ 1
    $("#file_image").change(function () {
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                readURL(document.getElementById('file_image'), 1);
            };
            img.src = _URL.createObjectURL(file);
        }
    });
});

function form_member(){
    if($("#level").val() == 0){
        $("#level").focus();
        $("#text_level").show();
        return false;
    }else{
        $("#text_level").hide();
    }
    
    if($("#mem_id").val() == ''){
        $("#mem_id").focus();
        $("#text_mem_id").show();
        return false;
    }else{
        $("#text_mem_id").hide();
    }

    if($("#name").val() == ''){
        $("#name").focus();
        $("#text_name").show();
        return false;
    }else{
        $("#text_name").hide();
    }

    if($("#email").val() == ''){
        $("#email").focus();
        $("#text_email").show();
        return false;
    }else{
        $("#text_email").hide();
    }
    
    if($("#mobile").val() == ''){
        $("#mobile").focus();
        $("#text_mobile").show();
        return false;
    }else if($("#mobile").val().length < 9){
        $("#mobile").focus();
        $("#text_mobile_length").show();
        return false;
    }else{
        $("#text_mobile").hide();
    }
    
    if($("#action").val() == "add"){
        if($("#username").val() == ''){
            $("#username").focus();
            $("#text_username").show();
            return false;
        }else{
            $("#text_username").hide();
        }

        if($("#password").val() == ''){
            $("#password").focus();
            $("#text_pass").show();
            return false;
        }else{
            $("#text_pass").hide();
        }
    }
    
    /*if($("#confirm_password").val() == ''){
        $("#confirm_password").focus();
        $("#text_confirm_pass").show();
        return false;
    }else{
        $("#text_confirm_pass").hide();
    }
    
    if($("#password").val() != $("#confirm_password").val()){
        $("#password").val("");
        $("#confirm_password").val("");
        $("#text_not_match").show();
        return false;
    }else{
        $("#text_not_match").hide();
    }*/
}

$("#text_level").hide();
$("#text_mem_id").hide();
$("#text_name").hide();
$("#text_email").hide();
$("#text_mobile").hide();
$("#text_mobile_length").hide();
$("#text_username").hide();
$("#text_pass").hide();
$("#text_confirm_pass").hide();
$("#text_not_match").hide();

function form_product(){
    if($("#pro_code").val() == ''){
        $("#pro_code").focus();
        $("#text_pro_code").show();
        return false;
    }else{
        $("#text_pro_code").hide();
    }
    
    if($("#pro_name").val() == ''){
        $("#pro_name").focus();
        $("#text_pro_name").show();
        return false;
    }else{
        $("#text_pro_name").hide();
    }
}

$("#text_pro_code, #text_pro_name, #text_pro_price").hide();

function random_pass(){
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 6;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    $("#password").val(randomstring);
}

function form_changepass(){
    if($("#old_pass").val() == ''){
        $("#old_pass").focus();
        $("#text_old_pass").show();
        return false;
    }else{
        $("#text_old_pass").hide();
        $.ajax({
            url: $("#link_url").val()+"/old/"+$("#old_pass").val()+"/",
            global: false,
            type: "POST",
            data: "",
            dataType: "html",
            async:false,
            success: function(data){
                if(data == 0){
                    count = 1;
                }else{
                    count = 0;
                }
            }	
        });
    }
    if(count == 1){
        $("#text_old_pass_false").show();
        return false;
    }else{
        $("#text_old_pass_false").hide();
    }

    if($("#new_pass").val() == ''){
        $("#new_pass").focus();
        $("#text_new_pass").show();
        return false;
    }else{
        $("#text_new_pass").hide();
    }

    if($("#con_new_pass").val() == ''){
        $("#con_new_pass").focus();
        $("#text_con_new_pass").show();
        return false;
    }else{
        $("#text_con_new_pass").hide();
    }
    
    if($("#new_pass").val() != $("#con_new_pass").val()){
        $("#new_pass").val("");
        $("#con_new_pass").val("");
        $("#new_pass").focus();
        $("#text_new_no_match").show();
        return false;
    }else{
        $("#text_new_no_match").hide();
    }
}
$("#text_old_pass").hide();
$("#text_old_pass_false").hide();
$("#text_new_pass").hide();
$("#text_con_new_pass").hide();
$("#text_new_no_match").hide();

// YA FUNCTION //
function del_admin(id,url,title,detail)
{
    $('.alert-title').html(title);
    $('.alert-body').html(detail);
    $('.btn-del').attr({'onclick':'delete_data('+id+',\''+url+'\')','data-dismiss':'modal'});
    $('#func_alert_click').click();
}

function delete_data(id,url)
{
    var title = '<i class="fa fa-exclamation-triangle text-danger"></i> Delete';
    var detail = 'Delete ID '+id+' Success !!!';
    $.post(url,{id:id}).done(function(data){
        $('#row_'+data).hide(500);
        $('.notificate-title').html(title);
        $('.notificate-body').html(detail);
        $('#func_notificate_click').click();
    });
}

function discount(dis)
{
    var discount = parseFloat($('#total').val()) * parseFloat(dis/100);
    var total = parseFloat($('#total').val()) - discount;
    var vat = parseFloat(total) * parseFloat(0.07);
    var grand = parseFloat(total) - parseFloat(vat);
    $('.text-discount').html(number_format(discount,2,'.',',')+' Baht');
    $('.text-price').html(number_format(grand,2,'.',',')+' Baht');
    $('.text-vat').html(number_format(vat,2,'.',',')+' Baht');
    $('.text-total').html(number_format(total,2,'.',',')+' Baht');
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = !isFinite(+number) ? 0 : +number, 
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        toFixedFix = function (n, prec) {
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            var k = Math.pow(10, prec);
            return Math.round(n * k) / k;
        },
        s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function status(id,stat,url)
{
    if(confirm('Are you change status id '+id)){
        $.ajax({
			url: url+"/"+id+"/"+stat,
            global: false,
            type: "POST",
            data: "",
            dataType: "html",
            async:false,
            success: function(data){
            }	
        });	
    }
}

$('select[name="status_member"]').change(function (){
    var mid = $(this).data('id');
    var option = $(this).val();
    if(option==1){ option = 2; } else { option = 1; }
    $.post($('#control_page').val()+'sitecontrol/member/status',{id:mid,stat:option}).done(function(e){});
});

$('.order_status').click(function (){
    var $btn = $(this).button('loading');
    var mid = $(this).data('id');
    var option = $(this).data('status');
    $.post($('#control_page').val()+'sitecontrol/order/status',{id:mid,stat:option},function(result){ }).done(function(e){ window.location.reload(); });
});

$(function () {
    $('.onlytext').blur(function () {
        var $th = $(this);
        $th.val($th.val().replace(/[^a-z A-Z0-9ก-ฮะาิีุูเะแำไโ๑๒๓๔๕๖๗๘๙๐ใๆ่้๊๋ั็์ึื%$/#!@.\-฿_]/g, function (str) {
            return '';
        }));
    });

    $('.onlyeng').blur(function () {
        var $th = $(this);
        $th.val($th.val().replace(/[^a-z A-Z0-9%$/#!@.\-฿_]/g, function (str) {
            return '';
        }));
    });

    $('.onlynumber').blur(function () {
        var $th = $(this);
        $th.val($th.val().replace(/[^0-9.]/g, function (str) {
            return '';
        }));
    });

    $('.onlyint').blur(function () {
        var $th = $(this);
        $th.val($th.val().replace(/[^0-9+]/g, function (str) {
            return '';
        }));
    });

    $('.onlytext').keypress(function (key) {
        if ((key.charCode < 64 || key.charCode > 122) && (key.charCode < 3585 || key.charCode > 3630) && (key.charCode < 3632 || key.charCode > 3641) && (key.charCode < 3647 || key.charCode > 3660) && (key.charCode != 13) && (key.charCode < 3665 || key.charCode > 3673) && (key.charCode != 33) && (key.charCode != 35) && (key.charCode != 32) && (key.charCode != 0) && (key.charCode != 36) && (key.charCode != 37) && (key.charCode < 45 || key.charCode > 57)) {
            return false;
        }
    });

    $('.onlyeng').keypress(function (key) {
        if ((key.charCode < 97 || key.charCode > 122) && (key.charCode < 64 || key.charCode > 90) && (key.charCode != 33) && (key.charCode != 35) && (key.charCode != 36) && (key.charCode != 95) && (key.charCode != 13) && (key.charCode != 32) && (key.charCode != 0) && (key.charCode != 37) && (key.charCode < 45 || key.charCode > 57))
            return false;
    });

    $('.onlynumber').keypress(function (key) {
        if ((key.charCode < 48 || key.charCode > 57) && (key.charCode != 13) && (key.charCode != 46) && (key.charCode != 0)) {
            return false;
        }
    });

    $('.onlyint').keypress(function (key) {
        if ((key.charCode < 48 || key.charCode > 57) && (key.charCode != 13) && (key.charCode != 0)) {
            return false;
        }
    });
});
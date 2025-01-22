$(document).ready(function(){
   $("#getPrice").change(function() {
        var tamano = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data:{tamano:tamano,product_id:product_id},
            type:'post',
            success:function(resp){
                /* alert(resp['final_price']); */
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<div class='price'><h4>$"+ " "+resp['final_price']+"</h4></div><div class='original-price'><span>Precio Original: </span><span>$"+ " "+resp['producto_precio']+"</span></div>");
                }else{
                    $(".getAttributePrice").html("<div class='price'><h4>$"+ " "+resp['final_price']+"</h4></div>");
                }
            },error:function(){
                alert("Errooor")
            }
        });
   });

   // actualiar los item de cantidad del carrito
   $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('plus-a')){
            //obtener la cantidad
            var cantidad = $(this).data('qty');
            
            //icrementar la cantidad 1 a 1
            new_qty = parseInt(cantidad) + 1;
            /* alert(new_qty); */
        }
        if($(this).hasClass('minus-a')){
            //obtener la cantidad
            var cantidad = $(this).data('qty');
            //chequear La cantidad de verificación es al menos 1
            if(cantidad<=1){
                alert("¡La cantidad de artículos debe ser 1 o más!");
                return false;
            }
            
            //icrementar la cantidad 1 a 1
            new_qty = parseInt(cantidad) - 1;
            /* alert(new_qty); */
        }
        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                $(".totalCartItems").html(resp.totalCartItems);
                if(resp.status==false){
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
            },error:function(){
                alert("Error");
            }
        });
   });

   // eliminar el item del carrito
   $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("Estas seguro de eliminar este producto?");
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/cart/delete',
                type:'post',
                success:function(resp){
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);
                },error:function(){
                    alert("Error");
                }
            });
        }
        
    });

    //cargador de tiempo al dar click el realizar pedido
    $(document).on('click','#placeOrder',function(){
        $(".loader").show();
    });

    //regitro para validacion
    $("#registerForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/register",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#register-"+i).attr('style','color:red');
                        $("#register-"+i).html(error);
                        setTimeout(function(){
                            $("#register-"+i).css({'display':'none'});
                        },4000);
                    });
                }else if(resp.type=="success"){
                    /* alert(resp.message); */
                    $(".loader").hide();
                    $("#register-success").attr('style','color:green');
                    $("#register-success").html(resp.message);
                }
               
            },error:function(){
                alert("Error");
            }
        })
    });

    //cuenta para validacion
    $("#accountForm").submit(function(){
        /* $(".loader").show(); */
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/account",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#account-"+i).attr('style','color:red');
                        $("#account-"+i).html(error);
                        setTimeout(function(){
                            $("#account-"+i).css({'display':'none'});
                        },4000);
                    });
                }else if(resp.type=="success"){
                    /* alert(resp.message); */
                    $(".loader").hide();
                    $("#account-success").attr('style','color:green');
                    $("#account-success").html(resp.message);
                    setTimeout(function(){
                        $("#account-success").css({'display':'none'});
                    },3000);
                }
               
            },error:function(){
                alert("Error");
            }
        })
    });

    //cambiar la contrasena
    $("#passwordForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/update-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#password-"+i).attr('style','color:red');
                        $("#password-"+i).html(error);
                        setTimeout(function(){
                            $("#password-"+i).css({'display':'none'});
                        },4000);
                    });
                }else if(resp.type=="incorrect"){
                    $(".loader").hide();
                        $("#password-error").attr('style','color:red');
                        $("#password-error").html(resp.message);
                        setTimeout(function(){
                            $("#password-error").css({'display':'none'});
                        },4000);
                }else if(resp.type=="success"){
                    /* alert(resp.message); */
                    $(".loader").hide();
                    $("#password-success").attr('style','color:green');
                    $("#password-success").html(resp.message);
                    setTimeout(function(){
                        $("#password-success").css({'display':'none'});
                    },3000);
                }
               
            },error:function(){
                alert("Error");
            }
        })
    });

    //login para validacion
    $("#loginForm").submit(function(){
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/login",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $("#login-"+i).attr('style','color:red');
                        $("#login-"+i).html(error);
                        setTimeout(function(){
                            $("#login-"+i).css({'display':'none'});
                        },4000);
                    });
                }else if(resp.type=="incorrect"){
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }else if(resp.type=="inactive"){
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }else if(resp.type=="success"){
                    window.location.href = resp.url;
                }

            },error:function(){
                alert("Error");
            }
        })
    });

     //olvido de contrasena del usuario
     $("#forgotForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/forgot-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#forgot-"+i).attr('style','color:red');
                        $("#forgot-"+i).html(error);
                        setTimeout(function(){
                            $("#forgot-"+i).css({'display':'none'});
                        },4000);
                    });
                }else if(resp.type=="success"){
                    /* alert(resp.message); */
                    $(".loader").hide();
                    $("#forgot-success").attr('style','color:green');
                    $("#forgot-success").html(resp.message);
                }
               
            },error:function(){
                alert("Error");
            }
        })
    });
    

    //olvido de contrasena del vendedor
    $("#forgotFormVendedor").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/vendor/forgot-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#forgot-"+i).attr('style','color:red');
                        $("#forgot-"+i).html(error);
                        setTimeout(function(){
                            $("#forgot-"+i).css({'display':'none'});
                        },4000);
                    });
                }else if(resp.type=="success"){
                    /* alert(resp.message); */
                    $(".loader").hide();
                    $("#forgot-success").attr('style','color:green');
                    $("#forgot-success").html(resp.message);
                }
               
            },error:function(){
                alert("Error");
            }
        })
    });

    //Aplicar el cupon
    $("#ApplyCoupon").submit(function(){
        var user = $(this).attr("user");
        /* alert(user); */
        if(user==1){ 
            

        }else{
            alert("Por favor inicia sesion");
            return false;
        }
        var code = $("#code").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            data:{code:code},
            url:'/apply-coupon',
            success:function(resp){
                if(resp.message!=""){
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
                if(resp.couponAmount>0){
                    $(".couponAmount").text("$ "+resp.couponAmount);
                }else{
                    $(".couponAmount").text("$ 0");
                }
                if(resp.grand_total>0){
                    $(".grand_total").text("$ "+resp.grand_total);
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //editar la direecion de delivery
    $(document).on('click','.editAddress',function(){
        var addressid = $(this).data("addressid");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{addressid: addressid},
            url:'/get-delivery-address',
            type:'post',
            success:function(resp){
                $("#showdifferent").removeClass("collapse");
                $(".newAddress").hide(); 
                $(".deliveryText").text("Editar la dirección de entrega"); 
                $('[name=delivery_id]').val(resp.address['id']);
                $('[name=delivery_nombre]').val(resp.address['nombre']);
                $('[name=delivery_direccion]').val(resp.address['direccion']);
                $('[name=delivery_ciudad]').val(resp.address['ciudad']);
                $('[name=delivery_estado]').val(resp.address['estado']);
                $('[name=delivery_pais]').val(resp.address['pais']);
                $('[name=delivery_pincodigo]').val(resp.address['pincodigo']);
                $('[name=delivery_celular]').val(resp.address['celular']);
            },error:function(){
                alert("Error");
            }
        });
    });

    //guardar la direccion de delivery
    $(document).on('submit',"#addressEditForm",function(){
        var formdata = $("#addressEditForm").serialize();
        $.ajax({
            url: '/save-delivery-address',
            type:'post',
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#delivery-"+i).attr('style','color:red');
                        $("#delivery-"+i).html(error);
                        setTimeout(function(){
                            $("#delivery-"+i).css({'display':'none'});
                        },4000);
                    });
                }else{
                    $("#deliveryAddresses").html(resp.view);
                    window.location.href = "checkout";
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    //eliminar la doreccion de delivery
    $(document).on('click','.eliminarAddress',function(){
        if(confirm("Estas seguro de eliminar esto?")){
            var addressid = $(this).data("addressid");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/remove-delivery-address',
                type:'post',
                data:{addressid:addressid},
                success:function(resp){
                    $("#deliveryAddresses").html(resp.view);
                    window.location.href = "checkout";
                },error:function(){
                    alert("Error");
                }
            });
        }
    });

    //calulcar el ttial geneta
    $("input[name=address_id").bind('change', function(){
        var shipping_charges = $(this).attr("shipping_charges");
        var total_price = $(this).attr("total_price");
        var cupon_amount = $(this).attr("cupon_amount");
        $(".shipping_charges").html("$ " + shipping_charges);
        if(cupon_amount==""){
            cupon_amount = 0;
        }
        $(".couponAmount").html("$ " + cupon_amount);
        var grand_total = parseInt(total_price) + parseInt(shipping_charges) - parseInt(cupon_amount);
        /* alert(grand_total); */
        $(".grand_total").html("$ " + grand_total);
        
    });
    
});

function get_filter(class_name) {
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}

function addSubscriber(){
    var subscriber_email = $("#subscriber_email").val();
    var mailFormat = /\S+@\S+\.\S+/;
    if(subscriber_email.match(mailFormat)){

    }else{
        alert("por favor ingrese Email válido!");
        return false;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'post',
        url:'add-subscriber-email',
        data:{subscriber_email:subscriber_email},
        success:function(resp){
            if(resp=="exists"){
                alert("Su correo electrónico ya existe en la suscripción");
            }else if(resp){
                alert("Gracias por subscribirte");
            }
        },error:function(){
            alert("Error");
        }
    });
    
}
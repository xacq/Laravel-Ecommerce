$(document).ready(function () {
    // llamar a datatable class
    $('#sections').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#categories').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#brands').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#products').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#banners').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#filters').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#coupons').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#users').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#orders').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#shipping').DataTable();
    
    $('#subscribers').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });
    $('#ratings').DataTable({
        "order": [[0, "desc"]] // Ordena por la columna ID en orden descendente
    });

    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("active");
    //revisar la contrasena admin si es correcta o no
    $("#contrasena_actual").keyup(function () {
        var contrasena_actual = $("#contrasena_actual").val();
        /* alert(current_password); /*  */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-admin-password',
            data: { contrasena_actual: contrasena_actual },
            success: function (resp) {
                /* alert(resp); */
                if (resp == "false") {
                    $("#check_password").html("<font color='red'> Contrasena Actual Incorrecta</font>");
                } else if (resp == "true") {
                    $("#check_password").html("<font color='green'> Contrasena Actual Correcta</font>");
                }
            }, error: function () {
                alert('Error oooo');
            }
        });
    });

    // actualizar el status de admin
    //Update Admin Status
    $(document).on("click", ".updateAdminStatus", function () {
        var status = $(this).children("i").attr("status");
        admin_id = $(this).attr("admin_id");
        /* alert(admin_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-admin-status',
            data: {
                status: status,
                admin_id: admin_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if (resp['status'] == 0) {
                    $("#admin-" + admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#admin-" + admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }
        });

    });

    //Update Banners Status
    $(document).on("click", ".updateBannerStatus", function () {
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        /* alert(banner_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-banner-status',
            data: {
                status: status,
                banner_id: banner_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#banner-" + banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#banner-" + banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update Cupones Status
    $(document).on("click", ".updateCouponStatus", function () {
        var status = $(this).children("i").attr("status");
        var coupon_id = $(this).attr("coupon_id");
        /* alert(coupon_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-coupon-status',
            data: {
                status: status,
                coupon_id: coupon_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#coupon-" + coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#coupon-" + coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update Status de la seccion
    $(document).on("click", ".updateSectionStatus", function () {
        var status = $(this).children("i").attr("status");
        section_id = $(this).attr("section_id");
        /* alert(section_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-section-status',
            data: {
                status: status,
                section_id: section_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if (resp['status'] == 0) {
                    $("#section-" + section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#section-" + section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }
        });

    });

    //Update Categoria Status
    $(document).on("click", ".updateCategoryStatus", function () {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        /* alert(category_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-category-status',
            data: {
                status: status,
                category_id: category_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#category-" + category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#category-" + category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update Marca Status
    $(document).on("click", ".updateBrandStatus", function () {
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        /* alert(brand_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-brand-status',
            data: {
                status: status,
                brand_id: brand_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#brand-" + brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#brand-" + brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update Calificaciones Status
    $(document).on("click", ".updateRatingStatus", function () {
        var status = $(this).children("i").attr("status");
        var rating_id = $(this).attr("rating_id");
        /* alert(rating_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-rating-status',
            data: {
                status: status,
                rating_id: rating_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#rating-" + rating_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#rating-" + rating_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update Susbcripcioes Status
    $(document).on("click", ".updateSubscriberStatus", function () {
        var status = $(this).children("i").attr("status");
        var subscriber_id = $(this).attr("subscriber_id");
        /* alert(subscriber_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-subscriber-status',
            data: {
                status: status,
                subscriber_id: subscriber_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#subscriber-" + subscriber_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#subscriber-" + subscriber_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update User Status
    $(document).on("click", ".updateUserStatus", function () {
        var status = $(this).children("i").attr("status");
        var user_id = $(this).attr("user_id");
        /* alert(user_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-user-status',
            data: {
                status: status,
                user_id: user_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#user-" + user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#user-" + user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update cargos de evio Status
    $(document).on("click", ".updateShippingStatus", function () {
        var status = $(this).children("i").attr("status");
        var shipping_id = $(this).attr("shipping_id");
        /* alert(shipping_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-shipping-status',
            data: {
                status: status,
                shipping_id: shipping_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#shipping-" + shipping_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#shipping-" + shipping_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update el Status de los productos
    $(document).on("click", ".updateProductStatus", function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        /* alert(product_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-product-status',
            data: {
                status: status,
                product_id: product_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#product-" + product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#product-" + product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update el Status de los filtros
    $(document).on("click", ".updateFilterStatus", function () {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        /* alert(filter_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-filter-status',
            data: {
                status: status,
                filter_id: filter_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update el Status de los valores filtros
    $(document).on("click", ".updateFilterValueStatus", function () {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        /* alert(filter_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-filter-value-status',
            data: {
                status: status,
                filter_id: filter_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#filter-" + filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update el Status del atributos de los productos
    $(document).on("click", ".updateAttributeStatus", function () {
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        /* alert(attribute_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-attribute-status',
            data: {
                status: status,
                attribute_id: attribute_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#attribute-" + attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#attribute-" + attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //Update el Status de las imagenes de los productos
    $(document).on("click", ".updateImageStatus", function () {
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        /* alert(image_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/update-image-status',
            data: {
                status: status,
                image_id: image_id
            },
            success: function (resp) {
                /* alert("Estado actualizado con éxito: " + resp); */
                if(resp['status'] == 0) {
                    $("#image-" + image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if(resp['status'] == 1) {
                    $("#image-" + image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function (xhr, status, error) {
                console.log("Error en AJAX:", xhr.responseText);
                alert("Error: " + xhr.responseText);
            }

        });

    });

    //confirmacion de eliminacion en la secciones (java script simple)
    /* $(".confirmDelete").click(function(){
        var title = $(this).attr("title");
        if(confirm("Estas seguro de eliminar esta " + title + "?")){
            return true;
        }else{
            return false;
        }
    }) */

    //confirmacion de eliminacion en la secciones (libreria de sweetAlert)
    $(document).on("click",".confirmDelete",function(){
        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');
        Swal.fire({
            title: "Está seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
                window.location = "/admin/delete-" + module + "/" + moduleid;
            }
        });
    })

    //agregar nivel de categoria
    $("#section_id").change(function(){
        var section_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLevel").html(resp);
            },error:function(){
                alert("Error");
            }
        })
    });

    //Atributos de productos agregar_eliminar script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height: 10px;"></div><input type="text" name="tamano[]" placeholder="Tamano" style="width: 120px;"/>&nbsp;<input type="text" name="referencia[]" placeholder="Referencia" style="width: 120px;"/>&nbsp;<input type="text" name="precio[]" placeholder="Precio" style="width: 120px;"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Eliminar</a></div>'; //New input feld html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
    });

    // Ver lo filtro y selecionar por categoria
    $("#category_id").on('change',function(){
        var category_id = $(this).val();
        /* alert(category_id); */
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'category-filters',
            data:{category_id:category_id},
            success:function(resp){
                $(".loadFilters").html(resp.view);
            }
        });
    });

    //ver los cupones pr Manuel/Automatico
    $("#ManualCoupon").click(function(){
        $("#couponField" ).show();
    });

    $("#AutomaticCoupon").click(function(){
        $("#couponField").hide() ;
    });

    // Mostrar el nombre del mensajero y el número de seguimiento en caso de que el pedido esté enviado
    $("#nombre_mensajero").hide();
    $("#numero_rastreo").hide();
    $("#order_status").on("change",function(){
        if(this.value=="Enviado"){
            $("#nombre_mensajero").show();
            $("#numero_rastreo").show();
        }else{
            $("#nombre_mensajero").hide();
            $("#numero_rastreo").hide();
        }
    });


});
$(".add-basket-product-item").on("click", function (e){
    e.preventDefault();

    const link            = $(e.currentTarget);
    const productId       = link.data("product-id");
    const productQuantity = $("#add-basket-product-quantity-"+productId).val();

    if (productQuantity === "" || productQuantity === "0") {
        alert("aa");
    } else {
        $.ajax({
            type : "POST",
            url  : "basket/add",
            data : {
                "product_id"       : productId,
                "product_quantity" : productQuantity
            }
        }).done(function(data){
            console.log(data);
            //alert(data.message);
        });
    }
});
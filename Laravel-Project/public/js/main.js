$(document).ready(function(){
    $(".pagination").addClass("justify-content-center");
    function getCurrentURL (type) {
        if (type == 1) {
            return window.location.href;
        }
        else {
            return window.location.host;
        }
    }
    const url = getCurrentURL(1);
    const host = window.location.protocol + '//' + getCurrentURL(2);
    $(".click_to_sec").on("click",function(){
        let id = $(this).data('id');
        $(".show_sec[data-id="+id+"]").toggle();
    });
    $(".delete_action").on("click", function () {
        let id = $(this).data("id");
        $('.form_change').attr('action', host + '/authors/' + id);
        $(".modal").modal("show");
    });
    $(".delete_book_action").on("click", function (){
        let id = $(this).data("id");
        $('.form_change').attr('action', host + '/books/' + id);
        $(".modal").modal("show");
    });
    $(".cancel_action").on("click", function () {
        $(".modal").modal("hide");
    });
    $(".edit_action").on("click", function (){
        let id = $(this).data("id");
        $(".edit_form[data-id="+id+"]").submit();
    });
    $(".add_value").on("click",function (){
        let id = $(this).data("id");
        let qty = parseInt($(".qty_product[data-id="+id+"]").val());
        let max_qty = $(this).data("qty");
        if (qty != max_qty) {
            qty++;
            $(".qty_product[data-id=" + id + "]").val(qty);
        }
    });
    $(".minus_value").on("click",function (){
        let id = $(this).data("id");
        let qty = parseInt($(".qty_product[data-id="+id+"]").val());
        if(qty > 1){
            qty--;
            $(".qty_product[data-id=" + id + "]").val(qty);
        }
    });
    $(".cart_menu").on("click",function (){
        $(".cart").animate({width: 'toggle'});
    });
    $('.show_ordered_list').on("click",function (e){
        e.preventDefault();
        let id = $(this).data('id');
        let content = $(".modal_content[data-id="+id+"]").html();
        console.log(content);
        $(".modal_oderbooks_body").html(content);
        $(".modal_orderbooks").modal("show");
    });
    $('.js-example-basic-multiple').select2();
});

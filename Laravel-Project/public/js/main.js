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
});

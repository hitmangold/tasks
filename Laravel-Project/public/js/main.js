$(document).ready(function(){
    $(".click_to_sec").on("click",function(){
        let id = $(this).data('id');
        $(".show_sec[data-id="+id+"]").toggle();
    });
    $(".delete_action").on("click", function () {
        let id = $(this).data("id");
        $(".remove_value").val(id);
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

$(document).ready(function(){
    $(".click_books").on("click",function(){
        let id = $(this).data('id');
        $(".show_books[data-id="+id+"]").toggle();
    });
});

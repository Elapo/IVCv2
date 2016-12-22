$('document').ready(function () {
    var cb=$("#editmode");
    var deletebtn = $('.deleteimg');
    var editbtn = $('.editimg');
    cb.click(function () {
        $(".editmode-btn").toggleClass("hidden");
    });
    deletebtn.click(function () {
        var val = $(this).val();
        console.log("clicky" + val);
       if(confirm("Are you sure you want to delete this image?")){
           window.location="includes/deleteimg.php?img="+val;
       } else{
           //do nothing
       }
    });
    editbtn.click(function () {
        var val = $(this).val();
        window.location="includes/editform.php?img="+val;
    });
});
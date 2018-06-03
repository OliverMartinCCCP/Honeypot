


// execute:
var deleteUser = function deleteUser(e){
    e.preventDefault();
    var del_id= $(this).attr('id');
    var $ele = $(this).parent().parent();
    console.log(del_id);
    console.log($ele);
    $.ajax({
        type:'GET',
        url:'delete.php',
        data:{'id':del_id},
        success: function(data){
            if(del_id > 2){
                $ele.fadeOut().remove();

            }else{
                alert("Can't delete this user")
            }
        }
    });

};


$(document).ready(function(){
    console.log("ready");
   //delete btn on click
    $(".remove").click(deleteUser);
});
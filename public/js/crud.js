var GerenciamentoCrud = {


	buscarPorId: function () {
       var view_url = $("#hidden_view").val();
          $.ajax({
        url: view_url,
        type:"GET", 
        data: {"id":$("#idHidden").val()}, 
        success: function(result){
          $("#view_fname").text(result.first_name);
          $("#view_lname").text(result.last_name);
          $("#view_email").text(result.email);
        }
      });
    },


    editar: function(){
    	var view_url = $("#hidden_view").val();

    	$.ajax({
        url: view_url,
        type:"GET", 
        data: {"id":$("#idHidden").val()}, 
        success: function(result){
          //console.log(result);
          $("#edit_id").val(result.id);
          $("#edit_first_name").val(result.first_name);
          $("#edit_last_name").val(result.last_name);
          $("#edit_email").val(result.email);
        }
      });
    },

    deletar: function(){
 	  var conf = confirm("Are you sure want to delete??");
     

      if(conf){
        var delete_url = $("#hidden_delete").val();
          
        $.ajax({
          url: delete_url,
          type:"POST", 
          data: {"id":$("#idHidden").val(),_token:  $('input[name="_token"]').val()}, 
          success: function(response){
            alert(response);
            location.reload(); 
          }
        });
      }
      else{
        return false;
      }

      }

};


$(document).ready(function() {
    $("body").on("click", "#btnView", GerenciamentoCrud.buscarPorId)
    $("body").on("click", "#btnEdit", GerenciamentoCrud.editar);
    $("body").on("click", "#btnDelete", GerenciamentoCrud.deletar);
     
});
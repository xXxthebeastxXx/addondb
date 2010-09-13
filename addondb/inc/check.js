<script type="text/javascript">

    $(document).ready(function(){
       $("#showcoauth").css("display","none");
       $("#checkcoauth").click(function(){

        if ($("#checkcoauth").is(":checked"))
        {
            $("#showcoauth").show("fast");
        } else {     
            $("#showcoauth").hide("fast");
        }
      });     

        $("#showvalid").css("display","none");
       $("#checkvalid").click(function(){
        if ($("#checkvalid").is(":checked"))
        {
            $("#showvalid").show("fast");
        } else {     
            $("#showvalid").hide("fast");
        }
      });
    });
</script>
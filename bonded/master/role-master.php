<?php
include('../header.php');
include('../sidebar.php');
include('../dbconfig.php');
include('roleconfig.php');
if(!isset($_SESSION['login'])){
    header('Location: '.BASEURL);exit();
}
?>
<style type="text/css">
.error{
    color:red;
}
</style>
<div class="row">
    <div class="col-md-12">
      <center><h3>ROLE MASTER - Create</h3></center>
    </div>
	<div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                 Role Master - Create
            </div>
            <div class="panel-body">
        		<form  id="addrole_form" name="addrole_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Create Role</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row margin_bottom_40">
                            <div class="col-lg-6">
                                <label class="control-label">Role name</label>
                                <input type="text" class="form-control required" name="role_name" id="role_name" placeholder="Role name" />
                            </div>
                            <div class="col-lg-6"></div>
                        </div><div class="clearfix"></div>
                        <div class="row" id="temperature_div">
                            <div class="col-lg-12">
                                <div class="responsive">
                                    <table id="role_list_table" class="table">
                                        <thead>
                                            <tr><th>Module</th><th>Create</th><th>Edit</th><th>View</th><th>Delete</th><th>Print</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($role_list as $k => $v){
                                            echo "<tr><td>".strtoupper($k)."</td>"; 
                                            $template = "<td>[create]</td><td>[edit]</td><td>[view]</td><td>[delete]</td><td>[print]</td>";
                                            $tmp = $template;
                                            foreach ($rolenames as $k2 => $v2) {
                                                if(in_array($v2, $v)){
                                                    $tmp = str_replace("[$v2]", '<input type="checkbox" name="'.$k.'__'.$v2.'" value="'.$v2.'">', $tmp);
                                                }else{
                                                    $tmp = str_replace("[$v2]", '', $tmp);
                                                }
                                            }
                                            echo $tmp;
                                            echo "</tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" id="action" value="add_role"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary" onclick="add_role_details();">Add Role</button>
                    </div>
                    <div class="col-lg-6 text-left">
                        <button type="button" class="btn btn-warning" onclick="window.location='role-master-edit.php';">View Roles</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../footer_imports.php'); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('#addrole_form').validate();
});

function add_role_details(){
    $("#editresulterrmsg").html('');
    if($('#addrole_form').valid()){
        var data = $('#addrole_form').serialize();
        $.ajax({
            url: "employeeservices.php",
            type: "POST",
            data:  data,
            dataType: 'json',
            success: function(result){
                if(result.infocode == "ROLEADDED"){
                    bootbox.alert(result.message);
                    $('#addrole_form')[0].reset();
                }else{
                    bootbox.alert(result.message);
                }
            },
            error: function(){}             
        });
    }
}

</script>
<?php include('../footer.php'); ?>
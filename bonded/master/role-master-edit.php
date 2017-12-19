<?php session_start();
include('../commonmethods.php');
if(!isset($_SESSION['login'])){
    header('Location: '.HOMEPATH);exit();
}
include('../header.php');
include('../topbar.php');
include('../sidebar.php');
include('../dbconfig.php');
include('roleconfig.php');
$role_permissions = array();
?>
<style type="text/css">
.error{
    color:red;
}
</style>
<div class="row">
    <div class="col-md-12">
      <center><h3>ROLE MASTER - Edit</h3></center>
    </div>
	<div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                 Role Master - Edit
            </div>
            <div class="panel-body">
        		<form  id="editrole_form" name="editrole_form" method="post" class="validator-form1" action="" onsubmit="return false;"> 
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Role</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row margin_bottom_40">
                            <div class="col-lg-6">
                                <label class="control-label">Role name</label>
                                <?php $dataflag = false;
                                $query = "SELECT * FROM role_master";
                                $result = mysqli_query($dbc,$query);
                                if(mysqli_num_rows($result)>0){
                                    echo '<select class="form-control required" name="role_name" id="role_name" onchange="changerole()";>';
                                    while($row = mysqli_fetch_assoc($result)){
                                        echo '<option value="'.$row['role_name'].'">'.$row['role_name'].'</option>';
                                        $role_permissions[$row['role_name']]=$row['role_permissions'];
                                    }
                                    echo '</select>';
                                    $dataflag = true;
                                }else{
                                    echo 'No roles added. <a href="role-master.php">Add Role Now</a>';
                                }
                                ?>
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
                                        <tbody id="role_data_tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" id="action" value="edit_role"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-6">
                        <button type="button" class="btn btn-primary" onclick="edit_role_details();">Update Role Details</button>
                    </div>
                    <div class="col-lg-6 text-left">
                        <button type="button" class="btn btn-success" onclick="window.location='role-master.php';">Add New Role</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../footer_jsimports.php'); ?>
<script type="text/javascript">
var g_role_permissions = new Array, g_role_names = new Array, g_role_list = new Array, g_roledetails = new Array;
<?php if($dataflag){ ?>
    g_role_permissions = <?php echo json_encode($role_permissions); ?>;
    //g_role_permissions = JSON.parse(g_role_permissions);
<?php } ?>
g_role_names = <?php echo json_encode($rolenames); ?>;
g_role_list = <?php echo json_encode($role_list); ?>;
$(document).ready(function(){
    $('#addrole_form').validate();
    changerole();
});

function edit_role_details(){
    $("#editresulterrmsg").html('');
    if($('#editrole_form').valid()){
        var data = $('#editrole_form').serialize();
        $.ajax({
            url: "employeeservices.php",
            type: "POST",
            data:  data,
            dataType: 'json',
            success: function(result){
                if(result.infocode == "ROLEUPDATED"){
                    bootbox.alert(result.message, function(){
                        location.reload();
                    });
                    //$('#addrole_form')[0].reset();
                }else{
                    bootbox.alert(result.message);
                }
            },
            error: function(){}             
        });
    }
}

function changerole(){
    rolename = $('#role_name').val();
    var roledetails = new Array;
    for(i in g_role_permissions){
        if(i == rolename){
            roledetails = JSON.parse(g_role_permissions[i]);
            g_roledetails = roledetails;
            display_roles(roledetails);
            break;
        }
    }
}

function display_roles(roledetails){
    var dp = '';
    for(c in g_role_list){
        dp += '<tr><td>'+c.toUpperCase()+'</td>';
        for(d in g_role_names){
            if((c in roledetails) && ((g_role_names[d] in roledetails[c]) && roledetails[c][g_role_names[d]] == 'yes')){
                dp += '<td><input type="checkbox" name="'+c+'__'+g_role_names[d]+'" checked="checked" value="'+g_role_names[d]+'"></td>';
            }else{
                dp += '<td><input type="checkbox" name="'+c+'__'+g_role_names[d]+'" value="'+g_role_names[d]+'"></td>';
            }
        }
    }
    $('#role_data_tbody').html(dp);
}
</script>
<?php include('../footer.php'); ?>
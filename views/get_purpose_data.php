<?php 
include_once '../common/config.php';

extract($_GET);

$cond = "FIND_IN_SET(:find_string,other)";
$params = array(":find_string" => $user_types);

$purpose = $obj->fetchRowAll('masters_list', $cond, $params);

$selected = '';

?>
<option value="">---Select---</option>
<?php if(!empty($purpose)) {

    for($s=0;$s<count($purpose);$s++){
        if( isset($_GET['purpose_id'])){
            if($_GET['purpose_id'] == $purpose[$s]['master_id']){
                $selected = 'selected="selected"';
            }
        }
        ?>
        <option <?php echo $selected;?>  value="<?php echo $purpose[$s]['master_id'];?>" >
            <?php echo ucfirst($purpose[$s]['name']);?></option>
        <?php $selected = '';} } ?>
<option value="0">Other</option>
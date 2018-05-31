<?php 
include_once '../common/config.php';

extract($_GET);

if ($_GET['iCountryID'] == "") {
    $cond = "is_active =:isActive";
    $params = array(":isActive" => '1');
} else {
    $cond = "country_id =:iCountryID AND is_active =:isActive";
    $params = array(":iCountryID" => $_GET['iCountryID'],":isActive" => '1');
}

extract($_GET);

$states = $obj->fetchRowAll('states', $cond, $params);
$selected = '';

?>
<option value="">---Select---</option>
<?php if(!empty($states)) {

    for($s=0;$s<count($states);$s++){
        if( $_GET['iStateID'] > 0 ){
            if($_GET['iStateID'] == $states[$s]['state_id']){
                $selected = 'selected="selected"';
            }
        }
        ?>
        <option <?php echo $selected;?>  value="<?php echo $states[$s]['state_id'];?>" >
            <?php echo ucfirst($states[$s]['name']);?></option>
        <?php $selected = '';} } ?>
<?php
if( $_GET['iStateID'] == 0 && $_GET['iStateID'] != ""){
    $selected = 'selected="selected"';
}
?>
<option <?php echo $selected;?> value="0">Other</option>

<?php 
include_once '../common/config.php';

extract($_GET);

$cond = "state_id =:iStateID AND is_active =:isActive";
$params = array(":iStateID" => $_GET['iStateID'],":isActive" => '1');

$citys = $obj->fetchRowAll('cities', $cond, $params);
$selected = '';

?>
<option value="">---Select---</option>
<?php if(!empty($citys)) {

    for($s=0;$s<count($citys);$s++){
        if( $_GET['iCityID'] > 0 ){
            if($_GET['iCityID'] == $citys[$s]['city_id']){
                $selected = 'selected="selected"';
            }
        }
        ?>
        <option <?php echo $selected;?>  value="<?php echo $citys[$s]['city_id'];?>" >
            <?php echo ucfirst($citys[$s]['name']);?></option>
        <?php $selected = '';} } ?>
<?php
if( $_GET['iCityID'] == 0 && $_GET['iCityID'] != "" ){
    $selected = 'selected="selected"';
}
?>
<option <?php echo $selected;?> value="0">Other</option>
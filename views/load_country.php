<?php 
include_once '../common/config.php';

extract($_GET);

$cond = "is_active =:is_active";
$params = array(":is_active" => 1);

extract($_GET);

$country = $obj->fetchRowAll('countries', $cond, $params);
$selected = '';

?>
<option value="">---Select---</option>
<?php if(!empty($country)) {

    for($s=0;$s<count($country);$s++){

        ?>
        <option  value="<?php echo $country[$s]['country_id'];?>" >
            <?php echo ucfirst($country[$s]['name']);?></option>
        <?php } } ?>
<option value="0">Other</option>

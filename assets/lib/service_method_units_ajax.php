<?php  include(dirname(dirname(dirname(__FILE__))) . "/objects/class_connection.php");include(dirname(dirname(dirname(__FILE__))) . "/header.php");include(dirname(dirname(dirname(__FILE__))) . "/objects/class_services_methods_units.php");include(dirname(dirname(dirname(__FILE__))) . "/objects/class_services_methods_units_rates.php");include(dirname(dirname(dirname(__FILE__))) . "/objects/class_service_methods_design.php");include(dirname(dirname(dirname(__FILE__))) . "/objects/class_setting.php");$con = new cleanto_db();$conn = $con->connect();$objservice_method_unit = new cleanto_services_methods_units();$objservice_method_unit_rate = new cleanto_services_methods_units_rates();$objservice_method_unit->conn = $conn;$objservice_method_unit_rate->conn = $conn;$settings = new cleanto_setting();$settings->conn = $conn;$method_default_design=$settings->get_option('ct_method_default_design');$lang = $settings->get_option("ct_language");$label_language_values = array();$language_label_arr = $settings->get_all_labelsbyid($lang);if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != ""){	$default_language_arr = $settings->get_all_labelsbyid("en");	if($language_label_arr[1] != ''){		$label_decode_front = base64_decode($language_label_arr[1]);	}else{		$label_decode_front = base64_decode($default_language_arr[1]);	}	if($language_label_arr[3] != ''){		$label_decode_admin = base64_decode($language_label_arr[3]);	}else{		$label_decode_admin = base64_decode($default_language_arr[3]);	}	if($language_label_arr[4] != ''){		$label_decode_error = base64_decode($language_label_arr[4]);	}else{		$label_decode_error = base64_decode($default_language_arr[4]);	}	if($language_label_arr[5] != ''){		$label_decode_extra = base64_decode($language_label_arr[5]);	}else{		$label_decode_extra = base64_decode($default_language_arr[5]);	}		$label_decode_front_unserial = unserialize($label_decode_front);	$label_decode_admin_unserial = unserialize($label_decode_admin);	$label_decode_error_unserial = unserialize($label_decode_error);	$label_decode_extra_unserial = unserialize($label_decode_extra);    	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);		foreach($label_language_arr as $key => $value){		$label_language_values[$key] = urldecode($value);	}}else{    $default_language_arr = $settings->get_all_labelsbyid("en");    	$label_decode_front = base64_decode($default_language_arr[1]);	$label_decode_admin = base64_decode($default_language_arr[3]);	$label_decode_error = base64_decode($default_language_arr[4]);	$label_decode_extra = base64_decode($default_language_arr[5]);				$label_decode_front_unserial = unserialize($label_decode_front);	$label_decode_admin_unserial = unserialize($label_decode_admin);	$label_decode_error_unserial = unserialize($label_decode_error);	$label_decode_extra_unserial = unserialize($label_decode_extra);    	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);		foreach($label_language_arr as $key => $value){		$label_language_values[$key] = urldecode($value);	}}if (isset($_POST['getservice_method_units'])) {    $objservice_method_unit->services_id = $_POST['service_id'];    $objservice_method_unit->methods_id = $_POST['method_id'];    $res = $objservice_method_unit->getunits_by_service_methods();    $i = 1;	/* ?>		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap-toggle.min.css" type="text/css" media="all">		<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap-toggle.min.js" type="text/javascript" ></script>			<?php  */    while ($arrs = mysqli_fetch_array($res)) {        $i++;        ?>		        <div class="col-sm-12 col-md-12 col-xs-12">            <li class="panel panel-default ct-clean-services-panel mysortlist_units" data-id="<?php echo $arrs['id'];?>"  id="service_method_units_<?php  echo $arrs['id'];?>">                <div class="panel-heading">                    <h4 class="panel-title">                        <div class="cta-col8 col-sm-8 col-md-9 np">							<div class="pull-left">								<i class="fa fa-th-list"></i>							</div>                            <span class="ct-clean-service-title-name" id="method_unit_name<?php  echo $arrs['id'];?>"><?php echo $arrs['units_title']; ?></span>                        </div>                        <div class="pull-right cta-col4 col-sm-4 col-md-3 np">						<!--						<div class="cta-col3"><a data-id="<?php /* echo $arrs['id']; */ ?><!--" class="quantity-rules-btn pull-left btn-circle btn-info btn-sm myqtypriceload" title="Quantity Rules"> <i class="fa fa-money"></i></a>						</div>-->                            <div class="cta-col4 cta-smu-endis">                                <label for="sevice-endis-<?php echo $arrs['id']; ?>">									<input class='myservices_methods_units_status' data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo $arrs['id']; ?>" <?php  if ($arrs['status'] == 'E') { echo "checked"; } else { echo ""; } ?> id="sevice-endis-<?php echo $arrs['id']; ?>" data-on="<?php echo $label_language_values['enable'];?>" data-off="<?php echo $label_language_values['disable'];?>" data-onstyle='success' data-offstyle='danger' />																                                </label>                            </div>                            <div class="pull-right cta-smu-del-toggle">                                <div class="cta-col1">                                <?php 									$t = $objservice_method_unit->method_unit_isin_use($arrs['id']);									if($t>0){										?>										<a data-toggle="popover" class="delete-clean-service-btn pull-right btn-circle btn-danger btn-sm" rel="popover" data-placement='top' title="<?php echo $label_language_values['unit_is_booked'];?>"> <i class="fa fa-ban"></i></a>									<?php 									}									else									{										?>                                    <a id="ct-delete-service-unit"  data-toggle="popover" class="delete-clean-service-unit-btn pull-right btn-circle btn-danger btn-sm" rel="popover" data-placement='left' title="<?php echo $label_language_values['delete_this_service_unit'];?>"> <i class="fa fa-trash" title="<?php echo $label_language_values['delete_service_unit'];?>"></i></a>                                    <div id="popover-delete-service" style="display: none;">                                        <div class="arrow"></div>                                        <table class="form-horizontal" cellspacing="0">                                            <tbody>                                            <tr>                                                <td>                                                    <a data-service_method_unitid="<?php echo $arrs['id']; ?>" value="<?php echo $label_language_values['delete'];?>" class="btn btn-danger btn-sm service-methods-units-delete-button"><?php echo $label_language_values['yes'];?>                                                    </a>                                                    <button id="ct-close-popover-delete-service" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo $label_language_values['cancel'];?>                                                    </button>                                                </td>                                            </tr>                                            </tbody>                                        </table>                                    </div>							<?php  } ?>                                </div>                                <div class="ct-show-hide pull-right">                                    <input type="checkbox" name="ct-show-hide" class="ct-show-hide-checkbox" id="sp<?php  echo $arrs['id']; ?>" ><!--Added Serivce Id-->                                    <label class="ct-show-hide-label" for="sp<?php  echo $arrs['id']; ?>"></label>                                </div>                            </div>                        </div>                    </h4>                </div>               <div id="detailmes_sp<?php  echo $arrs['id']; ?>" class="servicemeth_details panel-collapse collapse">                    <div class="panel-body">                        <div class="ct-service-collapse-div col-sm-12 col-md-6 col-lg-6 col-xs-12">                                <form id="service_method_unit_price<?php  echo $arrs['id']; ?>" method="" type="" class="slide-toggle" >                                    <table class="ct-create-service-table">                                        <tbody>                                        <tr>                                            <td><label for=""><?php echo $label_language_values['unit_name'];?></label></td>                                            <td><div class="col-xs-12"><input type="text" name="unitname" id="txtedtunitname<?php  echo $arrs['id']; ?>" class="form-control mytxtservice_method_uniteditname<?php  echo $arrs['id']; ?>" value="<?php echo $arrs['units_title'] ?>"/></div></td>                                        </tr>                                        <tr>                                        <?php                                             $duration= $arrs['uduration'];                                          $intval = intval($duration/60);                                         $modulas = fmod( $duration ,60);                                        ?>                                        <td><label for="txtedtunithours"><?php echo $label_language_values['duration'];?></label></td>                                        <td>                                                                                <div class="form-inline col-sm-12">                                            <div class="input-group">                                                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                                <input placeholder="00" size="2" maxlength="2" type="text" name="unithours" id="txtedtunithours<?php echo $arrs['id']; ?>" class="form-control mytxtservice_method_unitedithours<?php echo $arrs['id']; ?>" value="<?php echo $intval; ?>"  />                                                                                                <span class="input-group-addon"><?php echo $label_language_values['hours'];?></span>                                            </div>                                            <div class="input-group">                                                <input placeholder="05" size="2" maxlength="2" type="text" name="unitmints" id="txtedtunitmints<?php echo $arrs['id']; ?>" class="form-control mytxtservice_method_uniteditmints<?php echo $arrs['id']; ?>" value="<?php echo $modulas; ?>" />                                                <span class="input-group-addon"><?php echo $label_language_values['minutes'];?></span>                                            </div>                                        </div>                                        </td>                                        </tr>                                        <tr>                                            <td><label for=""><?php echo $label_language_values['base_price'];?></label></td>                                            <td>                                                <div class="col-xs-12">                                                    <div class="input-group">                                                        <span class="input-group-addon"><span class="unit-price-currency"><?php echo $settings->get_option('ct_currency_symbol');?></span></span>                                                        <input type="text" name="baseprice" id="txtedtunitbaseprice<?php  echo $arrs['id']; ?>" class="form-control mytxtservice_method_uniteditbase_price<?php  echo $arrs['id']; ?>" placeholder="US Dollar" value="<?php echo $arrs['base_price']; ?>">                                                    </div>                                                </div>                                            </td>                                        </tr>                                        <tr>                                            <td><label for=""><?php echo $label_language_values['max_limit'];?></label></td>                                            <td><div class="col-xs-12"><input type="text" name="txtmaxlimit" class="form-control mytxt_service_method_editmaxlimit<?php  echo $arrs['id']; ?>" id="txtedtunitmaxlimit<?php  echo $arrs['id']; ?>" value="<?php echo $arrs['maxlimit']; ?>"/></div></td>                                        </tr>										<tr style="display:none;">											<td><label for=""><?php echo $label_language_values['half_section'];?></label></td>											<td><div class="col-xs-12">											<label class="ctoggle-large" for="sevice-endis-<?php echo $arrs['id']; ?>">											<input class='myservices_methods_one_status' data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo $arrs['id']; ?>" <?php  if ($arrs['half_section'] == 'E') { echo "checked"; } else { echo ""; } ?> id="sevice-endis-<?php echo $arrs['id']; ?>" data-on="<?php echo $label_language_values['enable'];?>" data-off="<?php echo $label_language_values['disable'];?>" data-onstyle='success' data-offstyle='danger' />											</label>											</div></td>										</tr>										<tr>											<td><label for=""><?php echo $label_language_values['optional_label'];?></label></td>											<td><div class="col-xs-12"><input type="text" name="txtmaxlimit_title" class="form-control mytxt_service_method_editmaxlimit_title<?php  echo $arrs['id']; ?>" id="txtedtunitmaxlimit_title<?php  echo $arrs['id']; ?>" value="<?php echo $arrs['limit_title']; ?>"/></div></td>										</tr>										<tr>											<td><label for=""><?php echo $label_language_values['optional_unit_symbol'];?></label></td>											<td><div class="col-xs-4"><input type="text" name="txtsymbol" class="form-control mytxt_service_method_symbol<?php  echo $arrs['id']; ?>" id="txtedtunitsymbol<?php  echo $arrs['id']; ?>" value="<?php echo $arrs['unit_symbol']; ?>" placeholder="<?php echo $label_language_values['sqft'];?>"/></div></td>										</tr>                                        <tr>											<td></td>                                            <td>                                                <div class="col-xs-12"><a data-id="<?php echo $arrs['id']; ?>" class="btn btn-success ct-btn-width mybtnservice_method_unitupdate" ><?php echo $label_language_values['update'];?></a></div>                                            </td>                                        </tr>                                        </tbody>                                    </table>                                </form>                        </div>                        <div class="manage-unit-price-container<?php  echo $arrs['id']; ?> col-sm-12 col-md-6 col-lg-6 col-xs-12 mt-20" style="display:<?php    if($settings->get_option('ct_calculation_policy') == "M"){echo "none";}else{echo "block";} ?>">                            <div class="manage-unit-price-main col-sm-12 col-md-12 col-lg-12 col-xs-12">								<h4><?php echo $label_language_values['service_unit_price_rules'];?></h4>                                    <ul>                                        <li class="form-group">                                            <label class="col-sm-2 col-xs-12 np" for="addon_qty_6"><?php echo $label_language_values['base_price'];?></label>                                            <div class="col-xs-12 col-sm-2">                                            <input class="form-control" placeholder="1" value="1" id="" type="text" readonly="readonly" /></div>                                            <div class="price-rules-select">                                                <select class="form-control" id="">                                                    <option selected="" readonly value="=">= </option>                                                </select>                                            </div>                                            <div class="col-xs-12 col-sm-3">                                                <input  class="pull-left form-control" readonly value="<?php echo $arrs['base_price']; ?>" placeholder="<?php echo $label_language_values['price'];?>" type="text" />                                            </div>                                        </li>                                    </ul>                                    <ul class="myunitspricebyqty<?php  echo $arrs['id']; ?>">										<?php                                             $objservice_method_unit_rate->units_id = $arrs['id'];                                            $result = $objservice_method_unit_rate->getallrates_byunitid();                                            while ($r = mysqli_fetch_array($result)) {                                                ?>                                                <li class="form-group myunitqty_price_row<?php  echo $r['id']; ?>">                                                    <form id="myeditform_units<?php  echo $r['id']; ?>">                                                        <label class="col-sm-2 col-xs-12 np" for="addon_qty_6"><?php echo $label_language_values['Quantity'];?></label>                                                        <div class="col-xs-12 col-sm-2">                                                            <input id="myeditqty_units<?php  echo $r['id']; ?>" name="edtqty"  class="form-control myloadedqty_units<?php  echo $r['id']; ?>" placeholder="1" value="<?php echo $r['units']; ?>" type="text"/>                                                        </div>                                                        <div class="price-rules-select">                                                            <select class="form-control myloadedrules_units<?php  echo $r['id']; ?>">                                                                <option <?php  if ($r['rules'] == 'E'){ ?>selected<?php  } ?> value="E">=</option>                                                                <option <?php  if ($r['rules'] == 'G'){ ?>selected<?php  } ?> value="G"> &gt; </option>                                                            </select>                                                        </div>                                                        <div class="col-xs-12 col-sm-3">                                                            <input id="myeditprice_units<?php  echo $r['id']; ?>" name="edtprice" class="pull-left form-control myloadedprice_units<?php  echo $r['id']; ?>" value="<?php echo $r['rates']; ?>" placeholder="Price" type="text"/>                                                        </div>                                                        <a href="javascript:void(0);" data-id="<?php echo $r['id']; ?>"                                                           class="btn btn-circle btn-success  pull-left update-addon-rule myloadedbtnsave_units"><i class="fa fa-thumbs-up"></i></a>                                                        <a href="javascript:void(0);" data-id="<?php echo $r['id']; ?>"                                                           class="btn btn-circle btn-danger pull-left delete-addon-rule myloadedbtndelete_units"><i class="fa fa-trash"></i></a>                                                    </form>                                                </li>                                            <?php                                             }                                            ?>                                        <li class="form-group">                                            <form id="mynewaddedform_units<?php  echo $arrs['id']; ?>">                                                <label class="col-sm-2 col-xs-12 np" for="addon_qty_6"><?php echo $label_language_values['Quantity'];?></label>                                                <div class="col-xs-12 col-sm-2">                                                    <input required class="form-control mynewqty<?php  echo $arrs['id']; ?>" name="mynewssqty" id="mynewaddedqty_units<?php  echo $arrs['id']; ?>" placeholder="1" value="" type="text"/>                                                </div>                                                <div class="price-rules-select">                                                    <select class="form-control mynewrule<?php  echo $arrs['id']; ?>">                                                        <option selected value="E">=</option>                                                        <option value="G"> &gt; </option>                                                    </select>                                                </div>                                                <div class="col-xs-12 col-sm-3">                                                    <input name="mynewssprice" id="mynewaddedprice_units<?php  echo $arrs['id']; ?>" required class="pull-left form-control mynewprice<?php  echo $arrs['id']; ?>" value="" placeholder="<?php echo $label_language_values['price_per_unit'];?>" type="text" />                                                </div>                                                &nbsp; <a href="javascript:void(0);" data-id="<?php echo $arrs['id']; ?>" data-inspector="0" class="btn btn-circle btn-success add-addon-price-rule form-group new-manage-price-list myaddnewatyrule_units"><?php echo $label_language_values['add_new'];?></a>                                            </form>                                        </li>                                    </ul>                                </div>                        </div>                        </div>                        <!-- end manage unit price container -->                    </div>                </div>            </li>        </div>    <?php  } ?>	<div class="col-sm-12 col-md-12 col-xs-12">    <li>        <!-- add new clean service pop up -->        <div class="panel panel-default ct-clean-services-panel ct-add-new-price-unit">            <div class="panel-heading">                <h4 class="panel-title">					                    <div class="cta-col6">                        <span class="ct-service-title-name"></span>                    </div>                    <div class="pull-right cta-col6">                        <div class="pull-right">                            <div class="ct-show-hide pull-right">                                <input type="checkbox" name="ct-show-hide" checked="checked" class="ct-show-hide-checkbox" id="sp0" ><!--Added Serivce Id-->                                <label class="ct-show-hide-label" for="sp0"></label>                            </div>                        </div>                    </div>                </h4>            </div>            <div id="" class="panel-collapse collapse in detail_sp0">                <div class="panel-body">                    <div class="ct-service-collapse-div col-sm-12 col-md-12 col-xs-12 np">                        <form id="service_method_unitaddform" method="" type="" class="slide-toggle" >                            <table class="ct-create-service-table">                                <tbody>                                <tr>                                    <td><label for=""><?php echo $label_language_values['unit_name'];?></label></td>                                    <td><div class="col-xs-12"><input type="text" class="form-control mytxt_service_method_unitname" name="unitprice" id="txtunitnamess" /></div></td>                                </tr>                                <tr>                                    <td><label for=""><?php echo $label_language_values['base_price'];?></label></td>                                    <td><div class="col-xs-12">                                            <div class="input-group">                                                <span class="input-group-addon"><span class="unit-price-currency"><?php echo $settings->get_option('ct_currency_symbol');?></span></span>                                                <input type="text" class="form-control mytxt_service_method_unitbaseprice" id="txtbasepricess" name="baseprice" placeholder="US Dollar">                                            </div>                                                 <label for="txtbasepricess" generated="true" class="error"></label>                                        </div>                                    </td>                                </tr>                                <tr>									<td></td>                                    <td>                                       <div class="col-xs-12"> <a class="btn btn-success ct-btn-width mybtnservice_method_unitsave"  ><?php echo $label_language_values['save'];?></a></div>                                    </td>                                </tr>                                </tbody>                            </table>                        </form>                    </div>                </div>            </div>        </div>    </li></div><?php }else if (isset($_POST['deleteid'])) {    $objservice_method_unit->id = $_POST['deleteid'];    $objservice_method_unit->delete_services_method_unit();}else if(isset($_POST['pos']) && isset($_POST['ids'])){    echo "yes in ";    echo count($_POST['ids']);    for($i=0;$i<count($_POST['ids']);$i++)    {        $objservice_method_unit->position=$_POST['pos'][$i];        $objservice_method_unit->id=$_POST['ids'][$i];        $objservice_method_unit->updateposition();    }}elseif (isset($_POST['changestatus'])) {    $objservice_method_unit->id = $_POST['id'];    $objservice_method_unit->status = $_POST['changestatus'];    $objservice_method_unit->changestatus();}elseif (isset($_POST['changesinfotatus'])) {    $objservice_method_unit->id = $_POST['id'];    $objservice_method_unit->status = $_POST['changesinfotatus'];    $objservice_method_unit->changesinfotatus();}elseif (isset($_POST['operationinsert'])) {    $objservice_method_unit->methods_id = $_POST['method_id'];    $objservice_method_unit->units_title = filter_var($_POST['unit_name'], FILTER_SANITIZE_STRING);    $t = $objservice_method_unit->check_same_title();    $cnt = mysqli_num_rows($t);    if($cnt == 0){        $objservice_method_unit->services_id = $_POST['service_id'];        $objservice_method_unit->methods_id = $_POST['method_id'];        $objservice_method_unit->units_title = filter_var(mysqli_real_escape_string($conn, ucwords($_POST['unit_name'])), FILTER_SANITIZE_STRING);        $objservice_method_unit->base_price = $_POST['base_price'];        $objservice_method_unit->maxlimit = 1;        $objservice_method_unit->status = 'D';        $objservice_method_unit->add_services_method_unit();		$objservice_method_unit_rate->assign_design("ct_service_methods_design", $_POST['method_id'],$settings->get_option('ct_method_default_design'));    }    else{        echo "1";    }}elseif (isset($_POST['operationedit'])) {    $objservice_method_unit->id = $_POST['id'];    $hours = $_POST['units_hours'];    $mintues = $_POST['units_mints'];        if($_POST['units_hours']>0 || $_POST['units_hours']!=''){         $objservice_method_unit->duration = ($hours*60)+ $mintues;    }else{         $objservice_method_unit->duration = $hours+ $mintues;    }    $objservice_method_unit->units_title = filter_var(mysqli_real_escape_string($conn, ucwords($_POST['units_title'])), FILTER_SANITIZE_STRING);    $objservice_method_unit->base_price = $_POST['base_price'];    $objservice_method_unit->maxlimit = $_POST['maxlimit'];    $objservice_method_unit->maxlimit_title = ucwords($_POST['maxlimit_title']);    $objservice_method_unit->unit_symbol = $_POST['unit_symbol'];    $objservice_method_unit->update_services_method_unit();}elseif (isset($_POST['operationgetmethods'])) {    $objservice_method->service_id = $_POST['service_id'];    $res = $objservice_method->methodsbyserviceid();    while ($arr = mysqli_fetch_array($res)) {        echo "Method : " . $arr['method_title'] . " Id " . $arr['id'];    }}elseif (isset($_POST['checkunits_ofservice_methods'])){    $objservice_method_unit->services_id = $_POST['service_id'];    $objservice_method_unit->methods_id = $_POST['method_id'];    $res = $objservice_method_unit->getunits_by_service_methods();    $t = mysqli_num_rows($res);    if ($t < 1) {        echo $t."records";    } else {        if ($t == 1) {        } else {            ?>            <div class="ct-custom-radio">                <ul class="ct-radio-list">                    <?php                     $t = $objservice_method_unit->get_setting_design_methods($_POST['method_id']);                    ?>                    <li class="fln w100">                        <input <?php  if($t == 2){ echo "checked";}?> type="radio" id="v1" class="cta-radio design_radio_btn_units" name="rdbs"                               data-methodid="<?php echo $_POST['method_id'];?>" value="2"/>                        <label for="v1"><span></span><?php echo $label_language_values['service_unit_front_dropdown_view'];?></label>                        <img src="<?php echo BASE_URL;?>/assets/images/democheck/service-unit-design-1.jpg"                             style="height:  100%;width: 100%;">                    </li>                    <li class="fln w100">                        <input <?php  if($t == 3){ echo "checked";}?> type="radio" id="v2" class="cta-radio design_radio_btn_units" name="rdbs"                               data-methodid="<?php echo $_POST['method_id'];?>" value="3"/>                        <label for="v2"><span></span><?php echo $label_language_values['service_unit_front_block_view'];?></label>                        <img src="<?php echo BASE_URL;?>/assets/images/democheck/service-unit-design-2.jpg"                             style="height: 100%;width: 100%;">                    </li>                    <li class="fln w100">                        <input <?php  if($t == 4){ echo "checked";}?> type="radio" id="v3" class="cta-radio design_radio_btn_units" name="rdbs"                               data-methodid="<?php echo $_POST['method_id'];?>" value="4"/>                        <label for="v3"><span></span><?php echo $label_language_values['service_unit_front_increase_decrease_view'];?></label>                        <img src="<?php echo BASE_URL;?>/assets/images/democheck/service-unit-design-3.jpg"                             style="height: 100%;width: 100%;">                    </li>                </ul>            </div>        <?php         }    }}elseif (isset($_POST['operation_getallqtyprice'])) {    /* get all service by unit id */    $objservice_method_unit_rate->units_id = $_POST['unit_id'];    $result = $objservice_method_unit_rate->getallrates_byunitid();    while ($r = mysqli_fetch_array($result)) {        ?>        <li class="form-group myunitqty_price_row<?php  echo $r['id']; ?>">            <form id="myeditform_units<?php  echo $r['id']; ?>">                <label class="col-sm-2 col-xs-12 np" for="addon_qty_6"><?php echo $label_language_values['Quantity'];?></label>                <div class="col-xs-12 col-sm-2">                    <input id="myeditqty_units<?php  echo $r['id']; ?>" name="edtqty" class="form-control myloadedqty_units<?php  echo $r['id']; ?>" placeholder="1" value="<?php echo $r['units']; ?>" type="text"/>				</div>                <div class="price-rules-select">                    <select class="form-control myloadedrules_units<?php  echo $r['id']; ?>">                        <option <?php  if ($r['rules'] == 'E'){ ?>selected<?php  } ?> value="E">=</option>                        <option <?php  if ($r['rules'] == 'G'){ ?>selected<?php  } ?> value="G"> &gt; </option>					</select>                </div>                <div class="col-xs-12 col-sm-3">                    <input id="myeditprice_units<?php  echo $r['id']; ?>" name="edtprice" class="pull-left form-control myloadedprice_units<?php  echo $r['id']; ?>" value="<?php echo $r['rates']; ?>" placeholder="<?php echo $label_language_values['price'];?>" type="text"/>                </div>                <a href="javascript:void(0);" data-id="<?php echo $r['id']; ?>"                   class="btn btn-circle btn-success  pull-left update-addon-rule myloadedbtnsave_units"><i class="fa fa-thumbs-up"></i></a>                <a href="javascript:void(0);" data-id="<?php echo $r['id']; ?>"                   class="btn btn-circle btn-danger pull-left delete-addon-rule myloadedbtndelete_units"><i class="fa fa-trash"></i></a>            </form>        </li>    <?php     }    ?>    <li class="form-group">        <form id="mynewaddedform_units<?php  echo $_POST['unit_id'];?>">            <label class="col-sm-2 col-xs-12 np" for="addon_qty_6"><?php echo $label_language_values['Quantity'];?></label>            <div class="col-xs-12 col-sm-2">                <input required class="form-control mynewqty<?php  echo $_POST['unit_id'];?>" name="mynewssqty" id="mynewaddedqty_units<?php  echo $_POST['unit_id'];?>" placeholder="1" value="" type="text"/>			</div>            <div class="price-rules-select">                <select class="form-control mynewrule<?php  echo $_POST['unit_id'];?>">                    <option selected value="E">=</option>                    <option value="G"> &gt; </option>                </select>            </div>            <div class="col-xs-12 col-sm-3">                <input name="mynewssprice" id="mynewaddedprice_units<?php  echo $_POST['unit_id'];?>" required class="pull-left form-control mynewprice<?php  echo $_POST['unit_id'];?>" value="" placeholder="<?php echo $label_language_values['price_per_unit'];?>" type="text"/>            </div>            &nbsp; <a href="javascript:void(0);" data-id="<?php echo $_POST['unit_id'];?>" data-inspector="0" class="btn btn-circle btn-success add-addon-price-rule form-group new-manage-price-list myaddnewatyrule_units"><?php echo $label_language_values['add_new'];?></a>        </form>    </li><?php } elseif (isset($_POST['operationdelete_unitprice'])) {    /* delete the row from the db*/    $objservice_method_unit_rate->id = $_POST['id'];    $objservice_method_unit_rate->delete_unitprice();} elseif (isset($_POST['operation_updateqtyprice_unit'])) {    $objservice_method_unit_rate->id = $_POST['editid'];    $objservice_method_unit_rate->units = $_POST['qty'];    $objservice_method_unit_rate->rules = $_POST['rules'];    $objservice_method_unit_rate->rates = $_POST['price'];    $objservice_method_unit_rate->update_unitprice();} elseif (isset($_POST['operation_insertqtyprice_unit'])) {    $objservice_method_unit_rate->units = $_POST['qty'];    $objservice_method_unit_rate->rules = $_POST['rules'];    $objservice_method_unit_rate->rates = $_POST['price'];    $objservice_method_unit_rate->units_id = $_POST['unit_id'];    $objservice_method_unit_rate->insert_unitprice();} elseif (isset($_POST['assigndesign'])) {    $id = $_POST['service_method_id'];    $designid = $_POST['designid'];    $having = $objservice_method_unit_rate->check_have_design($id);    if (count($having[0]) > 0) {        $objservice_method_unit_rate->update_design("ct_service_methods_design", $id, $designid);    } else {        $objservice_method_unit_rate->assign_design("ct_service_methods_design", $id, $designid);    }}elseif($_POST['setfrontdesign']){	$objservice_method_unit->services_id = $_POST['service_id'];    $objservice_method_unit->methods_id = $_POST['method_id'];    $resss = $objservice_method_unit->getunits_by_service_methods_setdesign();    $ressst = $objservice_method_unit->getunits_by_service_methods_setdesign();    $tss = mysqli_num_rows($ressst);		if($tss == 0)    {    }    elseif($tss == 1 ){        while($rss = mysqli_fetch_array($resss)){            if($rss['maxlimit'] > 24){                $id = $_POST['method_id'];                $having = $objservice_method_unit_rate->check_have_design($id);                if (count($having[0]) > 0) {                    $objservice_method_unit_rate->update_design("ct_service_methods_design", $_POST['method_id'], 5);                } else {                    $objservice_method_unit_rate->assign_design("ct_service_methods_design", $_POST['method_id'], 5);                }            }			else 			{				?>				<div class="ct-custom-radio">					<ul class="ct-radio-list">						<?php 						$t = $objservice_method_unit->get_setting_design_methods($_POST['method_id']);						?>						<li class="fln w100">							<input <?php  if($t == 2){ echo "checked";}?> type="radio" id="v1" class="cta-radio design_radio_btn_units" name="rdbs"								   data-methodid="<?php echo $_POST['method_id'];?>" value="2"/>							<label for="v1"><span></span><?php echo $label_language_values['service_unit_front_dropdown_view'];?></label>							<img src="<?php echo BASE_URL;?>/assets/images/democheck/service-unit-design-1.jpg"								 style="height:  100%;width: 100%;">						</li>						<li class="fln w100">							<input <?php  if($t == 3){ echo "checked";}?> type="radio" id="v2" class="cta-radio design_radio_btn_units" name="rdbs"								   data-methodid="<?php echo $_POST['method_id'];?>" value="3"/>							<label for="v2"><span></span><?php echo $label_language_values['service_unit_front_block_view'];?></label>							<img src="<?php echo BASE_URL;?>/assets/images/democheck/service-unit-design-2.jpg"								 style="height: 100%;width: 100%;">						</li>						<li class="fln w100">							<input <?php  if($t == 4){ echo "checked";}?> type="radio" id="v3" class="cta-radio design_radio_btn_units" name="rdbs"								   data-methodid="<?php echo $_POST['method_id'];?>" value="4"/>							<label for="v3"><span></span><?php echo $label_language_values['service_unit_front_increase_decrease_view'];?></label>							<img src="<?php echo BASE_URL;?>/assets/images/democheck/service-unit-design-3.jpg"								 style="height: 100%;width: 100%;">						</li>					</ul>				</div>			<?php 			}        }    }    else    {		$ts = $objservice_method_unit->get_setting_design_methods($_POST['method_id']);		if($ts == "")		{			$objservice_method_unit->set_default_design($_POST['method_id'],$settings->get_option('ct_method_default_design'));		}		elseif($ts == 1 || $ts == 5)		{			$objservice_method_unit_rate->update_design("ct_service_methods_design", $_POST['method_id'], $settings->get_option('ct_method_default_design'));		}    }    if($tss < 1 || $tss == 1 || $tss == 5){        echo $tss;    }}?>
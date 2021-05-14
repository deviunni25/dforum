<?php
    // Backwards compatibility for older Grocery CRUD versions
    $unset_clone = isset($unset_clone) ? $unset_clone : true;

    //Start counting the buttons that we have:
    $buttons_counter = 0;

    if (!$unset_edit) {
        $buttons_counter++;
    }

    if (!$unset_read) {
        $buttons_counter++;
    }

    if (!$unset_delete) {
        $buttons_counter++;
    }

    if (!$unset_clone) {
        $buttons_counter++;
    }

    if (!empty($list[0]) && !empty($list[0]->action_urls)) {
        $buttons_counter = $buttons_counter +  count($list[0]->action_urls);
    }

    $show_more_button  = $buttons_counter > 2 ? true : false;

    $more_string = $this->l('list_more');
    $clone_string = $this->l('list_clone');

?>

<?php foreach($list as $num_row => $row){ 

   $p_key = $row->primary_key_value;
   $p_key_Enc = magicfunction($p_key,'e');
   
   $edit_new_url = $row->edit_url;
   $read_new_url = $row->read_url;

   $str_len = $length = strlen($edit_new_url);

   $index = 0;
  /* while($str_len > 1){
    $index = $length;
    $str_len--;
    if($edit_new_url[$str_len] == '/'){
        $edit_new_url = substr($edit_new_url,0,$str_len);
        $edit_new_url = $edit_new_url;

        echo $edit_new_url . ' and '. $str_len; 

        $read_new_url = substr($read_new_url,0,$str_len);
        break;
    }
   }*/

   while($edit_new_url[$str_len - 1] != '/'){
    $str_len--;
    $edit_new_url = substr($edit_new_url,0,$str_len);
    $read_new_url = substr($read_new_url,0,$str_len);

    $edit_new_url = $edit_new_url;
    $read_new_url = $read_new_url;

   // echo $edit_new_url . ' and '. $str_len; 

    //$read_new_url = substr($read_new_url,0,$str_len);
    //break;
   }
  // exit();

   //$edit_new_url = substr($edit_new_url,0,$index);
    //$read_new_url = substr($read_new_url,0,$index);

    //print_r($edit_new_url); exit();
   // $edit_new_url .= $p_key_Enc;

   // print_r($p_key . " and " .$p_key_Enc); 


    $row->edit_url = $edit_new_url;
    $row->read_url = $read_new_url;
   // $row->primary_key_value = $p_key_Enc;
  //  $edit_new_url = substr($edit_new_url);
   //print_r(grocery_encrypt($edit_new_url,'d')); 
  // print_r($edit_new_url); 
    
   //exit(); 
    ?>
    <tr>
        
        <?php foreach($columns as $column){?>
            <td>
                <?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?>
            </td>
        <?php }?>

        <td <?php if ($unset_delete) { ?> style="border-left: none;"<?php } ?>
            <?php if ($buttons_counter === 0) {?>class="hidden"<?php }?>>
                <div class="only-desktops"  style="white-space: nowrap">
                    <?php if(!$unset_edit){?>
                        <a class="btn btn-warning btn-sm" href="<?php echo $edit_new_url.$p_key_Enc; ?>">
                            <i class="fa fa-pencil-square-o"></i>
                                <?php //echo $this->l('list_edit'); 
                                ?>
                        </a>
                    <?php } ?>

                    <?php if (!$unset_read) { ?>
                          <a href="<?php echo $read_new_url.$p_key_Enc; ?>" class="btn btn-sm btn-info">
                                <i class="el el-eye-open"></i> 
                                <?php //echo $this->l('list_view')
                                ?>
                           </a>
                    <?php } ?>

                    <?php /*if (!empty($row->action_urls) || !$unset_read || !$unset_delete || !$unset_clone) { ?>

                        <?php if ($show_more_button) { ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-outline-dark gc-bootstrap-dropdown dropdown-toggle">
                                    <?php echo $more_string; ?>
                                    <span class="caret"></span>
                                </button>

                                <div class="dropdown-menu">
                                    <?php
                                    if(!empty($row->action_urls)){
                                        foreach($row->action_urls as $action_unique_id => $action_url){
                                            $action = $actions[$action_unique_id];
                                            $new_tab = property_exists($action, 'new_tab') && $action->new_tab;
                                            ?>
                                            <a
                                                href="<?php echo $action_url; ?>"
                                                class="dropdown-item"
                                                <?php if ($new_tab) { ?>
                                                    target="_blank"
                                                <?php } ?>
                                            >
                                                <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label?>
                                            </a>
                                        <?php }
                                    }
                                    ?>
                                    <?php if (!$unset_read) { ?>
                                        <a href="<?php echo $row->read_url?>" class="dropdown-item">
                                            <i class="el el-eye-open"></i> <?php echo $this->l('list_view')?>
                                        </a>
                                    <?php } ?>
                                    <?php if (!$unset_clone) { ?>
                                        <a href="<?php echo $row->clone_url?>" class="dropdown-item">
                                            <i class="el el-fork"></i> <?php echo $clone_string; ?>
                                        </a>
                                    <?php } ?>
                                    <?php if (!$unset_delete) { ?>
                                        <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row dropdown-item">
                                            <i class="el el-remove text-danger"></i>
                                            <span class="text-danger"><?php echo $this->l('list_delete')?></span>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } else {
                                if(!empty($row->action_urls)){
                                    foreach($row->action_urls as $action_unique_id => $action_url){
                                        $action = $actions[$action_unique_id];
                                        $new_tab = property_exists($action, 'new_tab') && $action->new_tab;
                                        ?>
                                        <a
                                            href="<?php echo $action_url; ?>"
                                            class="btn btn-secondary"
                                            <?php if ($new_tab) { ?>
                                                target="_blank"
                                            <?php } ?>
                                        >
                                            <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label?>
                                        </a>
                                    <?php }
                                }

                                if (!$unset_read) { ?>
                                    <a href="<?php echo $row->read_url?>" class="btn btn-default btn-outline-dark">
                                        <i class="el el-eye-open"></i> <?php echo $this->l('list_view')?>
                                    </a>
                                <?php } ?>

                                <?php if (!$unset_clone) { ?>
                                    <a href="<?php echo $row->clone_url?>" class="btn btn-default btn-outline-dark">
                                        <i class="el el-fork"></i> <?php echo $clone_string; ?>
                                    </a>
                                <?php } ?>

                                <?php if (!$unset_delete) { ?>
                                    <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row btn">
                                        <i class="el el-remove text-danger"></i>
                                        <span class="text-danger"><?php echo $this->l('list_delete')?></span>
                                    </a>
                                <?php } ?>
                            <?php } ?>

                    <?php } */ ?>
                    <?php if (!$unset_delete) { ?>
                         <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row btn btn-sm btn-danger">
                         <i class="fa fa-trash-o"></i>
                                <!--  <span class="text-danger"><?php echo $this->l('list_delete')?></span> -->
                                        </a>
                                    <?php } ?>
                </div>
                <div class="only-mobiles">
                    <?php if ($buttons_counter > 0) { ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary gc-bootstrap-dropdown dropdown-toggle">
                            <?php echo $this->l('list_actions'); ?>
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <?php if (!$unset_edit) { ?>
                                <a href="<?php echo $row->edit_url?>" class="dropdown-item">
                                    <i class="el el-pencil"></i> <?php echo $this->l('list_edit'); ?>
                                </a>
                            <?php } ?>
                            <?php
                            if(!empty($row->action_urls)){
                                foreach($row->action_urls as $action_unique_id => $action_url){
                                    $action = $actions[$action_unique_id];
                                    $new_tab = property_exists($action, 'new_tab') && $action->new_tab;
                                    ?>
                                        <a
                                            href="<?php echo $action_url; ?>"
                                            class="dropdown-item"
                                            <?php if ($new_tab) { ?>
                                                target="_blank"
                                            <?php } ?>
                                        >
                                            <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label?>
                                        </a>
                                <?php }
                            }
                            ?>
                            <?php if (!$unset_read) { ?>
                                <a href="<?php echo $row->read_url?>" class="dropdown-item">
                                    <i class="el el-eye-open"></i> <?php echo $this->l('list_view')?>
                                </a>
                            <?php } ?>
                            <?php if (!$unset_clone) { ?>
                                <a href="<?php echo $row->clone_url?>" class="dropdown-item">
                                    <i class="el el-fork"></i> <?php echo $clone_string; ?>
                                </a>
                            <?php } ?>
                            <?php if (!$unset_delete) { ?>
                                <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row dropdown-item">
                                    <i class="el el-remove text-danger"></i> <span class="text-danger"><?php echo $this->l('list_delete')?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>


                  

                </div>
        </td>

        <!--<td <?php if ($unset_delete) { ?> style="border-right: none;"<?php } ?>
            <?php if ($buttons_counter === 0) {?>class="hidden"<?php }?>>
            <?php if (!$unset_delete) { ?>
                <input type="checkbox" class="select-row" data-id="<?php echo $row->primary_key_value; ?>" />
            <?php } ?>
        </td>-->

    </tr>
<?php } ?>
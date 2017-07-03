<table class="table">
                <thead>
                  <tr>
                    <th>Sl.no</th>
                    <th>Dimension</th>
                    <th>Quantity Numbers</th>
                    <th>Weight(kg)</th>
                    <th>Container Number</th>
                  </tr>
                </thead>
                <tbody id="addcontainer_tbody">
                  <?php
                    $select_item = "SELECT * FROM sac_par_container_info WHERE added_from = 'par'";
                    $result_item = mysqli_query($dbc,$select_item);
                    $item_count = 0; 
                    if(mysqli_num_rows($result_item) > 0) {
                      while($row = mysqli_fetch_array($result_item)) { ?>
                        <tr id="itemtr_1">
                          <td><span class="td_sno"><?php echo ++$item_count; ?></span></td>
                          <td>
                            <select class="form-control required" id="dimension" name="dimension[]">
                              <option value="20 ft. Container" <?php echo (($row['dimension']=='20 ft. Container')?'selected="selected"':''); ?> >20 ft. Container</option>
                              <option value="40 ft. Container" <?php echo (($row['dimension']=='40 ft. Container')?'selected="selected"':''); ?> >40 ft. container</option>
                              <option value="Break Bulk ODC LCL" <?php echo (($row['dimension']=='Break Bulk ODC LCL')?'selected="selected"':''); ?> >Break Bulk ODC LCL</option>
                            </select>
                          </td>

                          <td><input type="text" name="qty_numbers[]" placeholder="" class="form-control" value="<?php echo $row['qty_numbers']; ?>"></td>

                          <td><input type="text" name="container_weight[]" placeholder="" class="form-control"value="<?php echo $row['container_weight']; ?>"></td>

                          <td><input type="text" name="vehicle_number[]" placeholder="" class="form-control" value="<?php echo $row['vehicle_number']; ?>"></td>
                          
                          <!-- <td><button onclick="addContainerRow(1);">+</button><button class="item_removebutton" style="display:none;" onclick="removeContainerRow(1)">-</button></td> -->
                        </tr>
                      <?php }
                    } else { ?>
                        <tr id="itemtr_1">
                          <td><span class="td_sno"><?php echo ++$item_count; ?></span></td>
                          <td>
                            <select class="form-control required" id="dimension" name="dimension[]">
                              <option value="20 ft. Container" <?php echo (($row['dimension']=='20 ft. Container')?'selected="selected"':''); ?> >20 ft. Container</option>
                              <option value="40 ft. Container" <?php echo (($row['dimension']=='40 ft. Container')?'selected="selected"':''); ?> >40 ft. container</option>
                              <option value="Break Bulk ODC LCL" <?php echo (($row['dimension']=='Break Bulk ODC LCL')?'selected="selected"':''); ?> >Break Bulk ODC LCL</option>
                            </select>
                          </td>

                          <td><input type="text" name="qty_numbers[]" placeholder="" class="form-control" value="<?php echo $row['qty_numbers']; ?>"></td>

                          <td><input type="text" name="container_weight[]" placeholder="" class="form-control"value="<?php echo $row['container_weight']; ?>"></td>

                          <td><input type="text" name="vehicle_number[]" placeholder="" class="form-control" value="<?php echo $row['vehicle_number']; ?>"></td>
                          
                          <!-- <td><button onclick="addContainerRow(1);">+</button><button class="item_removebutton" style="display:none;" onclick="removeContainerRow(1)">-</button></td> -->
                        </tr>
                   <?php } ?>
                </tbody>
              </table>
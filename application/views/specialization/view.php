<div class="modal-dialog modal-lg">

  <div class="modal-content">  
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title tt-u fs-18"><?php echo $page_title; ?></h4> 
            </div>
      <div class="modal-body form cmnClassF cf">  
         <section class="cbranch">
            <div class="cbranch-box"> 
            <table class="cbranch-tbl">
              <tr>
                <th class="cbranch-td-left">Branch ID : </th>
                <td class="cbranch-td-right">12365478936</td>
                <td class="cbranch-td-left"></td>
                <td class="cbranch-td-right"></td>
              </tr>
              <tr>
                <th class="cbranch-td-left">Employee Type : </th>
                <td class="cbranch-td-right"><?php echo $form_data['emp_type']; ?></td>
                <td class="cbranch-td-left"></td>
                <td class="cbranch-td-right"></td>
              </tr>
              <tr>
                <th class="cbranch-td-left">Status : </th>
                <td class="cbranch-td-right"><?php echo $form_data['status']; ?>
                                <td class="cbranch-td-left"></td>
                <td class="cbranch-td-right"></td>

                </td>
              </tr> 
            </table>
           </div> <!-- close -->
          </section>
      </div>     
             
             
        <div class="modal-footer">  
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> 
 
        </div><!-- /.modal-content -->
    
</div><!-- /.modal-dialog -->
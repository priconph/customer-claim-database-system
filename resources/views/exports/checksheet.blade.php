
<table>
    @foreach($claim_info as $claim)
        
        <tr>
            {{-- <th style="width: 12px;">test</th>
            <th style="width: 8.2px;">test</th>
            <th style="width: 10.2px;">test</th>
            <th style="width: 9.9px;">test</th>
            <th style="width: 6.52px;">test</th>
            <th style="width: 4.85px;">test</th>
            <th style="width: 4.85px;">test</th>
            <th style="width: 10.6px;">test</th>
            <th style="width: 16px;">test</th>
            <th  style="width: 15.5px;">test</th>
            <th style="width: 20.1px;">test</th> --}}

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>PMIF-0109-053 rev. 2</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="11" style="text-align: center;">Customer Complaint Checksheet</td>
        </tr>

        <tr>
            <td colspan="11" style="text-align: center;" >QA Department fill-in</td>
        </tr>

        <tr>
            <td colspan="3">Division/Department: QAD</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Date Received:</td>
            <td></td>
            <td>{{ $claim->date_received }}</td>
            
        </tr>
        <tr>
            <td colspan="11" style="text-align: center; background-color:#c0c0c0; ">DETAILS OF COMPLAINT</td>
        </tr>

        <tr>
            <td colspan="4">Customer: {{ $claim->customer_details->customer_name }}</td>
            <td>Product Name: </td>
            <td></td>
            <td></td>
            <td>{{ $claim->product_details->product_name }}</td>
            <td></td>
            <td>Model: {{ $claim->model_name }}</td>
            <td></td>
        </tr>

        <tr>
            <td >PMI Control No.:</td>
            <td colspan="2">{{ $claim->pmi_control_number }}</td>
            <td></td>
            <td colspan="3">Reference No.:</td>
            
            <td colspan="2">{{ $claim->reference_number }}</td>
        </tr>

        <tr>
            <td colspan="3">PO No.: {{ $claim->po_number }}</td>
            <td></td>
            <td>Shipment Date: {{ isset($claim->shipment_date) ? $claim->shipment_date : 'None' }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Shipment Qty: {{ $claim->shipment_quantity }}</td>
        </tr>

        <tr>
            <td colspan="2"  style="text-align: center;">Lot Traceability</td>
            <td>Lot Qty.</td>
            <td colspan="2"  style="text-align: center;"># of NG</td>
            <td colspan="4"  style="text-align: center;">Mode of defect/s</td>
            <td colspan="2"  style="text-align: center;">Disposition on Lot</td>
        </tr>
        <tr>
            <?php
                $exploded = explode(',',$claim->lot_traceability);
                echo '<td colspan="2"  style="text-align: center;">'; 
                       
                    for($i=0;$i<count($exploded);$i++){ 
                        
                        if($i == sizeof($exploded) - 1){
                            echo $exploded[$i]; 
                        }
                        else{
                            echo $exploded[$i]."<br>"; 
                        }
                    } 
                        
               
                echo '</td>'; 
            ?>
            {{-- <td colspan="2"  style="text-align: center;">{{ $exploded[0] }}</td> --}}
            <td>{{ $claim->quantity }}</td>
            <td colspan="2"  style="text-align: center;">{{ $claim->quantity }}</td>
            <td colspan="4"  style="text-align: center;">{{ $claim->mode_of_defect }}</td>
            <td colspan="2"  style="text-align: center;">-</td> 
        </tr>

        <tr >
            {{-- <td colspan="3">Required Reply Date: 11/3/2021</td> --}}
            <td ></td>
            <td></td>
            @php
                $resultchecked = "";
                $resultbox = "";
                if($claim->automotive == 1){
                   echo "<td colspan='6'> &#9745; Automotive Product &nbsp; &#9744; Non-Automotive Product</td>";
                }
                else{
                    echo "<td colspan='6'>&#9744; Automotive product &nbsp;  &#9745; Non-Automotive Product</td>";
                }

            @endphp
                {{-- <td colspan="3">Automotive product: &#9744; &#9745;</td>
                <td colspan="3">Regular product: &#9744; &#9745;</td> --}}
                <td colspan="3">Remarks: {{ $claim->remarks }}</td>

        </tr>

        <tr>
            <td colspan="2" style="background-color:#c0c0c0;">DATA VERIFICATION</td>
            <td colspan="9" style="background-color:#c0c0c0;">(verify all information to check if reported claim is PMI produced)</td>
        </tr>

        <tr>
            <td colspan="5" style="text-align: center;">CHECK ITEMS</td>
            <td style="text-align: center;">YES</td>
            <td style="text-align: center;">NO</td>
            <td colspan="4" style="text-align: center;">REMARKS</td>
        </tr>

        <tr>
            <td colspan="5">1. Is P.O. No. traceable to PMI?</td>
            @php
            
                if($claim->is_po_number_traceable == 1){
                   echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->is_po_number_traceable == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_po_number_traceable_remarks }}</td>
        </tr>
        <tr>
            <td colspan="5">2. Is the lot identification matches with PMI record?</td>
            @php
            
                if($claim->is_lot_identification_match == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->is_lot_identification_match == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_lot_identification_match_remarks }}</td>
        </tr>
        <tr>
            <td colspan="5">3. Are there WIP and FGS affected?</td>
            @php
            
                if($claim->are_there_wip_fgs_affected == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->are_there_wip_fgs_affected == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->are_there_wip_fgs_affected_remarks }}</td>

            
        </tr>
    
        
        <tr>
            <td colspan="5">4. Is sorting / reworking necessary?</td>
            @php
            
                if($claim->is_sorting_reworking_necessary == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->is_sorting_reworking_necessary == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_sorting_reworking_necessary_remarks }}</td>
           
        </tr>
        <tr>
            <td colspan="5">5. Is sorting needed at the customer's site?</td>
            @php
            
                if($claim->is_sorting_needed == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->is_sorting_needed == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_sorting_needed_remarks }}</td>
           
          
        </tr>
        <tr>
            <td colspan="5">6. Is the shipment schedule affected?</td>
            @php
            
                if($claim->is_shipment_affected == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->is_shipment_affected == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_shipment_affected_remarks }}</td>
       
            
            
        </tr>
        <tr>
            <td colspan="5">7. Are data needed complete and available? </td>
            @php
            
                if($claim->are_data_needed_complete_available == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->are_data_needed_complete_available == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->are_data_needed_complete_available_remarks }}</td>
           
        </tr>
        <tr>
            <td colspan="5">8. Does customer requests production record?</td>
            @php
            
                if($claim->does_customer_requests_production_record == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->does_customer_requests_production_record == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->does_customer_requests_production_record_remarks }}</td>
          
        </tr>
        <tr>
            <td colspan="5" style="word-wrap:break-word;">9.  Are there some clarifications needed to settle with the customer?</td>
            @php
            
                if($claim->are_there_clarifications_needed_to_settle == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->are_there_clarifications_needed_to_settle == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->are_there_clarifications_needed_to_settle_remarks }}</td>
      
        </tr> 


        <tr>
            <td colspan="2" style="background-color:#c0c0c0;">UNIT VERIFICATION</td>
            <td colspan="9" style="background-color:#c0c0c0;">(verify defect as identified by the customer)</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">CHECK ITEMS</td>
            <td style="text-align: center;">YES</td>
            <td style="text-align: center;">NO</td>
            <td colspan="4" style="text-align: center;">REMARKS</td>
        </tr>
        <tr>
            <td colspan="5">1. Is the actual NG unit available for verification?</td>
            @php
            
                if($claim->is_actual_ng_unit_available == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                elseif($claim->is_actual_ng_unit_available == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }else{
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_actual_ng_unit_available_remarks }}</td>

        </tr> 
        <tr>
            <td colspan="5">2. Is the unit bearing PMI identification mark?</td>
            @php
                
                if($claim->is_unit_bearing_pmi_identification_mark == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                elseif($claim->is_unit_bearing_pmi_identification_mark == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_unit_bearing_pmi_identification_mark_remarks }}</td>
        </tr> 
        <tr>
            <td colspan="5" style="word-wrap: break-word;">3. Is claim defect identified by the customer tallies with actual received NG unit?</td>
            @php
                
                if($claim->is_claim_defect_identified_by_customer == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                elseif($claim->is_claim_defect_identified_by_customer == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;"></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->is_claim_defect_identified_by_customer_remarks }}</td>
        </tr> 
        <tr>
            <td colspan="5"  style="word-wrap: break-word;">4. Does customer requires official corrective and preventive action report?</td>
            @php
                    
                if($claim->does_customer_requires_official_capa_report == 1){
                echo '<td style="text-align: center;">&#10003;</td>
                        <td style="text-align: center;"></td>';
                }
                else if($claim->does_customer_requires_official_capa_report == 2){
                    echo '<td style="text-align: center;"></td>
                        <td style="text-align: center;">&#10003;</td>';
                }
                else{
                    echo '<td></td>
                        <td></td>';
                }
            @endphp
            
            <td colspan="4">{{ $claim->does_customer_requires_official_capa_report_remarks }}</td>
        </tr> 

        <tr>
            <td colspan="11" style="text-align: center;">Operations fill-in</td>
        </tr>


        <tr>
            <td colspan="2">CLAIM VALIDATION</td>
            <td colspan="9">(validate the claim if contributed by PMI processes and implementing system - based on the result of investigation)</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">CHECK ITEMS</td>
            <td style="text-align: center;">YES</td>
            <td style="text-align: center;">NO</td>
            <td colspan="4" style="text-align: center;">REMARKS</td>
        </tr>
        <tr>
            <td colspan="5">1. Is the defect NG based on the define specification?</td>
            {{-- <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td colspan="4"></td> --}}
            @php
                    
            if($claim->is_the_defect_ng_based_on_specs == 1){
            echo '<td style="text-align: center;">&#10003;</td>
                    <td style="text-align: center;"></td>';
            }
            else if($claim->is_the_defect_ng_based_on_specs == 2){
                echo '<td style="text-align: center;"></td>
                    <td style="text-align: center;">&#10003;</td>';
            }
            else{
                echo '<td></td>
                    <td></td>';
            }
            @endphp
        
            <td colspan="4">{{ $claim->is_the_defect_ng_based_on_specs_remarks }}</td>
        </tr> 
        <tr>
            <td colspan="5">2. Is the defect included in PMI check items?</td>
            {{-- <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td colspan="4"></td> --}}

            @php
                    
            if($claim->is_defect_included_in_pmi == 1){
            echo '<td style="text-align: center;">&#10003;</td>
                    <td style="text-align: center;"></td>';
            }
            else if($claim->is_defect_included_in_pmi == 2){
                echo '<td style="text-align: center;"></td>
                    <td style="text-align: center;">&#10003;</td>';
            }
            else{
                echo '<td></td>
                    <td></td>';
            }
            @endphp
        
            <td colspan="4">{{ $claim->is_defect_included_in_pmi_remarks }}</td>
        </tr> 
        <tr>
            <td colspan="5" style="word-wrap: break-word;">3. Is the defect detectable at PMI Function Test/Camera recognition checking?</td>
            {{-- <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td colspan="4"></td> --}}
            @php
                    
            if($claim->is_defect_detectable_at_pmi == 1){
            echo '<td style="text-align: center;">&#10003;</td>
                    <td style="text-align: center;"></td>';
            }
            else if($claim->is_defect_detectable_at_pmi == 2){
                echo '<td style="text-align: center;"></td>
                    <td style="text-align: center;">&#10003;</td>';
            }
            else{
                echo '<td></td>
                    <td></td>';
            }
            @endphp
        
            <td colspan="4">{{ $claim->is_defect_detectable_at_pmi_remarks }}</td>
        </tr> 
        <tr>
            <td colspan="5">4. Is the unit undergone Customer assembly process?</td>
            {{-- <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td colspan="4"></td> --}}
            @php
                    
            if($claim->is_unit_undergone_customer_assembly_process == 1){
            echo '<td style="text-align: center;">&#10003;</td>
                    <td style="text-align: center;"></td>';
            }
            else if($claim->is_unit_undergone_customer_assembly_process == 2){
                echo '<td style="text-align: center;"></td>
                    <td style="text-align: center;">&#10003;</td>';
            }
            else{
                echo '<td></td>
                    <td></td>';
            }
            @endphp
        
            <td colspan="4">{{ $claim->is_unit_undergone_customer_assembly_process_remarks }}</td>
        </tr> 
        <tr>
            <td colspan="5">5. Is the defect contributed by PMI process?</td>
            {{-- <td style="text-align: center;"></td>
            <td style="text-align: center;"></td>
            <td colspan="4"></td> --}}
            @php
                    
            if($claim->is_defect_contributed_by_pmi == 1){
            echo '<td style="text-align: center;">&#10003;</td>
                    <td style="text-align: center;"></td>';
            }
            else if($claim->is_defect_contributed_by_pmi == 2){
                echo '<td style="text-align: center;"></td>
                    <td style="text-align: center;">&#10003;</td>';
            }
            else{
                echo '<td></td>
                    <td></td>';
            }
            @endphp
        
            <td colspan="4">{{ $claim->is_defect_contributed_by_pmi_remarks }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="4">Validated by: {{ $claim->operation_sender_name }}</td>
        </tr>

        <tr>
           <td colspan="11" style="background-color:#c0c0c0; text-align: center;"> DEFFECT CLASSIFICATION</td>
        </tr>

        <tr>
            <td colspan="5">Date of 8D report submission/Accepted by QAD: {{ $claim->accepted_at }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td colspan="2">Complaint Valid?</td>
            @php
                if($claim->validity == 1){
                    echo "<td >&#9745; YES</td>
                        <td >&#9744; NO</td>";
                }
                else{
                    echo "<td >&#9744;YES</td>
                        <td >&#9745; NO</td>";
                }
            @endphp
            
        </tr>
        <tr>
            <td colspan="4">If complaint is valid,  what is its classification?</td>
            @php
                if($claim->defect_category_class == 1){
                    echo '<td >&#9745; Class A &#9744; Class B &#9744; Class C</td>';
                }
                else if($claim->defect_category_class == 2){
                    echo '<td >&#9744;  Class A &#9745; Class B &#9744; Class C</td>';
                }
                else if($claim->defect_category_class == 3){
                    echo '<td >&#9744; Class A &#9744; Class B &#9745; Class C</td>';
                }
                else{
                    echo '<td >&#9744; Class A &#9744; Class B &#9744; Class C</td>';
                }
            @endphp
            {{-- <td colspan="2">&#9744; &#9745; Class A</td>
            <td colspan="2">&#9744; &#9745; Class B</td>
            <td colspan="2">&#9744; &#9745; Class C</td> --}}
        </tr>
        <tr>
            <td>Document is also valid without signature</td>
        </tr>
        <tr>
            <td>Prepared by:</td>
            <td colspan="2">{{ $claim->rapidx_user->name }}</td>
            <td >Checked by:</td>
            <td colspan="4" style="text-align: center;"> SC Masbad</td>
            <td>Approved by:</td>
            <td colspan="2" style="text-align: center;">H. Kato</td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td>Report send by:</td>
            <td colspan="3" style="text-align: center;">{{ $claim->operation_sender_name }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td >Date:</td>
            {{-- <td colspan="2" style="text-align: center;">{{ $claim->operation_eight_d_report_date }}</td> --}}
            <td colspan="2" style="text-align: center;">{{ $claim->required_reply }}</td>
        </tr>
    @endforeach
    
</table>

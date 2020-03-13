<!DOCTYPE html>
<html lang="en">



<body class="">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
      
           
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
       
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
		
			<div id="usermgnt" class="tabcontent">
				<div class="main-content">
					<div class="section__content section__content--p30">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="overview-wrap"> 
										<h2 class="title-1">Medical History(<span style="color:red"><?= $username ?></span>)</h2>

									
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="table-responsive m-b-40">
										    <h5>Hospital Records</h5>
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Hospital Name</th>
														<th>Provider Name</th>
														
														<th>Provider Speciality Type</th>
														<th>Date of Service</th>
														<th>Images</th>
                                                       
													</tr>
												</thead>

                                        <tbody id="postList"> 
                                           <?php 
                                            $sn=1;
                                           if(!empty($hospital)){
                                                 foreach($hospital as $host){
                                            ?>
                                            <tr>
                                               
                                             <td><?= $sn++ ?></td>
                                            <td><?= ucwords($host->hospital_name) ?></td>    
                                             <td><?= ucwords($host->provider_name) ?></td>
                                              <td><?= ucwords($host->provider_specility) ?></td>
                                               <td><?= $host->service_date ?></td>
                                               <td>
                                                   <?php
                                                $img =  $this->my_model->getfields('medical_record_image','image',array('record_id'=>$host->id,'type'=>'hospital'));
                                             //   print_r($img);
                                            // echo $this->db->last_query();
                                            if($img){
                                                 foreach($img as $im)
                                                 {
                                                     ?>
                                                    	<a href="<?= $im->image?>" target="_blank"> 
                                                  <img src="<?= $im->image;?>" height="40" width="40" style="border-radius: 25px;"> </a>
                                                 <?php 
                                                 }
                                                 }else
                                                 {
                                                     echo "No image";
                                                 }
                                                 ?>
                                               </td>
                                            </tr>
                                             <?php } } else{?>
                                             <tr><td>No record found.</td></tr>
                                            <?php } ?> 
                                           </tbody>
												
											</table>
                          

										</div>
                                <!-- END DATA TABLE-->
                                
                                <!--start lab-->
                                	<div class="table-responsive m-b-40">
                                	    <h5>Lab Records</h5>
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Lab Name</th>
														<th>Prescription Name</th>
														<th>Date of Service</th>
														
														<th>Images</th>
                                                       
													</tr>
												</thead>

                                        <tbody id="postList"> 
                                           <?php 
                                            $sn=1;
                                           if(!empty($lab)){
                                                 foreach($lab as $lb){
                                            ?>
                                            <tr>
                                               
                                             <td><?= $sn++ ?></td>
                                            <td><?= ucwords($lb->lab_name) ?></td>    
                                             <td><?= ucwords($lb->prescription_name) ?></td>
                                              <td><?= $lb->lab_date ?></td>
                                              
                                               <td>
                                                   <?php
                                                $img =  $this->my_model->getfields('medical_record_image','image',array('record_id'=>$lb->id,'type'=>'lab'));
                                             //   print_r($img);
                                            // echo $this->db->last_query();
                                               if($img){
                                                 foreach($img as $im)
                                                 {
                                                     ?>
                                                <a href="<?= $im->image?>" target="_blank"> 
                                                  <img src="<?= $im->image;?>" height="40" width="40" style="border-radius: 25px;"> </a>
                                                 <?php 
                                                 }
                                                 }else
                                                 {
                                                     echo "No image";
                                                 }
                                                 ?>
                                               </td>
                                            </tr>
                                             <?php } } else{?>  
                                           </tbody>
											<tr><td>No record found.</td></tr>	
											<?php } ?>
											</table>
                          

										</div>
                                <!--end lab-->
                                <!--start pharmacy -->
                                	<div class="table-responsive m-b-40">
                                	    <h5>Pharmacy Script</h5>
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Pharmacy Name</th>
														<th>Prescription Provider Name</th>
														<th>Date of Service</th>
														<th>Images</th>
                                                       
													</tr>
												</thead>

                                        <tbody id="postList"> 
                                           <?php 
                                            $sn=1;
                                           if(!empty($pharmacy)){
                                                 foreach($pharmacy as $phar){
                                            ?>
                                            <tr>
                                               
                                             <td><?= $sn++ ?></td>
                                            <td><?= ucwords($phar->pharmacy_name) ?></td>    
                                             <td><?= ucwords($phar->pharmacy_provider_name) ?></td>
                                              <td><?= $phar->service_date	 ?></td>
                                              
                                               <td>
                                                   <?php
                                                $img =  $this->my_model->getfields('medical_record_image','image',array('record_id'=>$phar->id,'type'=>'pharmacy'));
                                             //   print_r($img);
                                            // echo $this->db->last_query();
                                               if($img){
                                                 foreach($img as $im)
                                                 {
                                                     ?>
                                                	<a href="<?= $im->image?>" target="_blank">     
                                                  <img src="<?= $im->image;?>" height="40" width="40" style="border-radius: 25px;"> </a>
                                                 <?php 
                                                 }
                                                 }else
                                                 {
                                                     echo "No image";
                                                 }
                                                 ?>
                                               </td>
                                            </tr>
                                             <?php } } else{?>  
                                           </tbody>
											<tr><td>No record found.</td></tr>	
											<?php } ?>
											</table>
                          

										</div>
                                <!--end pharmacy -->
                                
                                <!--start physical -->
                                	<div class="table-responsive m-b-40">
                                	    <h5>Physical therapist Records</h5>
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Therapist Name</th>
														<th>Date of Service</th>
													
														<th>Images</th>
                                                       
													</tr>
												</thead>

                                        <tbody id="postList"> 
                                           <?php 
                                            $sn=1;
                                           if(!empty($physical)){
                                                 foreach($physical as $phy){
                                            ?>
                                            <tr>
                                               
                                             <td><?= $sn++ ?></td>
                                            <td><?= ucwords($phy->therapy_name) ?></td>    
                                             <td><?= ucwords($phy->therapy_date) ?></td>
                                             
                                              
                                               <td>
                                                   <?php
                                                $img =  $this->my_model->getfields('medical_record_image','image',array('record_id'=>$phy->id,'type'=>'physical'));
                                             //   print_r($img);
                                            // echo $this->db->last_query();
                                               if($img){
                                                 foreach($img as $im)
                                                 {
                                                     ?>
                                            	<a href="<?= $im->image?>" target="_blank">
                                                  <img src="<?= $im->image;?>" height="40" width="40" style="border-radius: 25px;"> </a>
                                                 <?php 
                                                 }
                                                 }else
                                                 {
                                                     echo "No image";
                                                 }
                                                 ?>
                                               </td>
                                            </tr>
                                             <?php } } else{?>  
                                           </tbody>
											<tr><td>No record found.</td></tr>	
											<?php } ?>
											</table>
                          

										</div>
                                <!--end physical-->
                                
                                <!--start specialty-->
                                 	<div class="table-responsive m-b-40">
                                	    <h5>Specialist Records</h5>
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Speciality Name</th>
														<th>Speciality Type</th>
														<th>Date of Service</th>
													
														<th>Images</th>
                                                       
													</tr>
												</thead>

                                        <tbody id="postList"> 
                                           <?php 
                                            $sn=1;
                                           if(!empty($specialty)){
                                                 foreach($specialty as $spe){
                                            ?>
                                            <tr>
                                               
                                             <td><?= $sn++ ?></td>
                                            <td><?= ucwords($spe->specialty) ?></td>    
                                             <td><?= $spe->specialty_type ?></td>
                                              <td><?= $spe->service_date ?></td>
                                             
                                              
                                               <td>
                                                   <?php
                                                $img =  $this->my_model->getfields('medical_record_image','image',array('record_id'=>$spe->id,'type'=>'specialty'));
                                             //   print_r($img);
                                            // echo $this->db->last_query();
                                               if($img){
                                                 foreach($img as $im)
                                                 {
                                                     ?>
                                                	<a href="<?= $im->image?>" target="_blank">     
                                                  <img src="<?= $im->image;?>" height="40" width="40" style="border-radius: 25px;"> 
                                                  </a>
                                                 <?php 
                                                 }
                                                 }else
                                                 {
                                                     echo "No image";
                                                 }
                                                 ?>
                                               </td>
                                            </tr>
                                             <?php } } else{?>  
                                           </tbody>
											<tr><td>No record found.</td></tr>	
											<?php } ?>
											</table>
                          

										</div>
                                <!--end specialty-->
                                
                                <!--start other detail-->
                                 	<div class="table-responsive m-b-40">
                                	    <h5>Other Records</h5>
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Description</th>
														<th>Date of Service</th>
														<th>Images</th>
                                                       
													</tr>
												</thead>

                                        <tbody id="postList"> 
                                           <?php 
                                            $sn=1;
                                           if(!empty($other)){
                                                 foreach($other as $othr){
                                            ?>
                                            <tr>
                                               
                                            <td><?= $sn++ ?></td>
                                            <td><?= $othr->description ?></td>    
                                            <td><?= $othr->date ?></td>
                                            
                                             
                                              
                                               <td>
                                                   <?php
                                                $img =  $this->my_model->getfields('medical_record_image','image',array('record_id'=>$othr->id,'type'=>'other'));
                                             //   print_r($img);
                                            // echo $this->db->last_query();
                                               if($img){
                                                 foreach($img as $im)
                                                 {
                                                     ?>
                                                 	<a href="<?= $im->image?>" target="_blank">     
                                                  <img src="<?= $im->image;?>" height="40" width="40" style="border-radius: 25px;"> 
                                                  </a>
                                                 <?php 
                                                 }
                                                 }else
                                                 {
                                                     echo "No image";
                                                 }
                                                 ?>
                                               </td>
                                            </tr>
                                             <?php } } else{?>  
                                           </tbody>
											<tr><td>No record found.</td></tr>	
											<?php } ?>
											</table>
                          

										</div>
                                <!--end other detail-->
                                
                                
									</div>
							  
									</div>
								</div>
							</div>
						</div>
							  
					</div>
				</div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
			</div>
			
			
	
        </div>
		
    </div>
	
	
			
			
			
			
	<!-- Audio Uploads 4-->
	
		
			
			

			
			
			
			
			
		

  

</body>

</html>
<!-- end document-->


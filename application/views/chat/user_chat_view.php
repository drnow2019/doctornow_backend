<!DOCTYPE html>
<html lang="en">

<body class="">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">

            <!-- MAIN CONTENT-->

            <div id="usermgnt" class="tabcontent">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">User Chat</h2>
                                    </div>
                                    <div class="col-md-12 tabdatabga">
                                      <div class="userchatboards">
                                        <div class="chatlistingbrd">
                                          <input type="text" class="form-control" placeholder="Search Here.." id="search_text" autocomplete="off">
                                          <span id="hide_search_id">                                          
                                            <div class="usersactvs Chat_List">
                                              <?php 
                                                if(!empty($user)){ 
                                                foreach($user as $list){
                                                $query = $this->db->query("select message,created_date from doctor_chat where user_id = $list->id order by id DESC")->row();
                                                $time = $this->com_model->calculateTime($query->created_date);
                                                $badgeCount = $this->my_model->coutrow('doctor_chat','id',array('user_id'=>$list->id,'user_type'=>'user','sender_type'=>'sender','status'=>'1','badge_count'=>'1'));
                                              ?>
                                              <div class="userinfo">
                                                <a href="javascript:void(0)" onclick="userDetails('<?= $list->id?>')">
                                                  <div class="userpic">
                                                    <?php if($list->image){?>
                                                      <img src="<?= $list->image ?>" title="<?= ucwords($list->name)?>">
                                                    <?php } else {?>
                                                      <img src="<?= base_url('assets/images/avtar_dummy.png')?>" title="No Profile" />
                                                    <?php } ?>
                                                  </div>

                                                  <div class="usrcrednt">
                                                    <h6><?= ucwords($list->name) ?> </h6> 
                                                    <span id="bage_<?= $list->id?>">
                                                      <span class="badge"><?php if($badgeCount){ echo  $badgeCount ;}?></span>
                                                    </span>
                                                    <p> <?= substr($query->message,0,15) ?>......</p>
                                                    <p class="pstdrn"> <?= $time  ?> </p>
                                                  </div>
                                                </a>
                                              </div>
                                              
                                              <?php } }else{?>
                                                <p>No chat found!</p>
                                              <?php } ?>
                                            </div>
                                          </span>

                                          <div id="saveDiv"></div>
                                          <div id="load_data2"></div>
                                        </div>
                                        
                                        <span id="hide_chat_id">
                                          <div class="Chat_Hide">
                                              <h3>Welcome , Admin</h3>
                                              <figure><img src="<?= base_url('assets/images/avtar_dummy.png')?>"> </figure>
                                              <h5>Start a conversion</h5>
                                          </div>
                                        </span>

                                        <div class="charboardsshowpan">

                                          <div id="show_chat_id"></div>

                                        </div>

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            //load_data();

            function load_data1(query) {
                //alert
                $.ajax({
                    url: "<?= base_url('userchat/fetchuser')?>",
                    method: "POST",

                    data: {
                        keywords: query
                    },
                    success: function(data) {
                        // alert(data);exit();
                        //console.log(data);exit();
                        $('#load_data2').html(data);
                        $("#hide_search_id").css("display", "none");

                    }
                })
            }

            $('#search_text').keyup(function() {
                var search = $(this).val();
                //alert(search);exit();
                if (search != '') {
                    load_data1(search);
                } else {
                    load_data1();
                }
            });
        });
    </script>
    <script>
        function userDetails(id) {
            //alert(id); 
            // $("#show_chat_id").html("");
            $.ajax({
                type: "POST",
                url: "<?= base_url('userchat/userDetails')?>",
                data: {
                    user_id: id
                },
                cache: false,

                success: function(response) {
                    // alert(response);
                    if (response) {
                        // location.reload();
                        $("#hide_chat_id").css("display", "none");
                        $("#bage_" + id).css("display", "none");

                        $("#show_chat_id").html(response);
                        //  $("#result").css("display", "block");
                        //  scrollBottom();
                        // alert();

                    }

                }
            });
        }
    </script>
    <script>
        function scrollBottom() {

            $("#messageScrollArea").animate({
                scrollTop: $('#messageScrollArea').prop("scrollHeight")
            }, 1000);
            //$("#messageScrollArea").scrollTop($('#messageScrollArea').height())
            //$(".chatbriefflow").floatingScroll();
            return false;
        };
    </script>
  </body>
</html>
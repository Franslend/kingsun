<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');

	$user = $_SESSION['user'];

	// Get graph data - purchase order by status
	include('database/po_status_pie_graph.php');

	// Ger graph data - supplier product count
	include('database/supplier_product_bar_graph.php');

	// Get line graph data - delivery history per day
	include('database/delivery_history.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - KingSun</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="https://kit.fontawesome.com/8bf423e820.js" crossorigin="anonymous"></script>
</head>
<body>
<style>
.chatperson{
  display: block;
  border-bottom: 1px solid #eee;
  width: 100%;
  display: flex;
  align-items: center;
  white-space: nowrap;
  overflow: hidden;
  margin-bottom: 15px;
  padding: 4px;
}
.chatperson:hover{
  text-decoration: none;
  border-bottom: 1px solid orange;
}
.namechat {
    display: inline-block;
    vertical-align: middle;
}
.chatperson .chatimg img{
  width: 40px;
  height: 40px;
  background-image: url('http://i.imgur.com/JqEuJ6t.png');
}
.chatperson .pname{
  font-size: 18px;
  padding-left: 5px;
}
.chatperson .lastmsg{
  font-size: 12px;
  padding-left: 5px;
  color: #ccc;
}
.col-md-2, .col-md-10{
    padding:0;
}
.panel{
    margin-bottom: 0px;
}
.chat-window{
    bottom:0;
    position:fixed;
    float:right;
    margin-left:10px;
}
.chat-window > div > .panel{
    border-radius: 5px 5px 0 0;
}
.icon_minim{
    padding:2px 10px;
}
.msg_container_base{
  background: #e5e5e5;
  margin: 0;
  padding: 0 10px 10px;
  max-height:300px;
  overflow-x:hidden;
}
.top-bar {
  background: #666;
  color: white;
  padding: 10px;
  position: relative;
  overflow: hidden;
}
.msg_receive{
    padding-left:0;
    margin-left:0;
}
.msg_sent{
    padding-bottom:20px !important;
    margin-right:0;
}
.messages {
  background: white;
  padding: 10px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  max-width:100%;
}
.messages > p {
    font-size: 13px;
    margin: 0 0 0.2rem 0;
  }
.messages > time {
    font-size: 11px;
    color: #ccc;
}
.msg_container {
    padding: 10px;
    overflow: hidden;
    display: flex;
}
img {
    display: block;
    width: 100%;
}
.avatar {
    position: relative;
}
.base_receive > .avatar:after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border: 5px solid #FFF;
    border-left-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
}
.base_sent {
  justify-content: flex-end;
  align-items: flex-end;
}
.base_sent > .avatar:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 0;
    border: 5px solid white;
    border-right-color: transparent;
    border-top-color: transparent;
    box-shadow: 1px 1px 2px rgba(black, 0.2); // not quite perfect but close
}
.msg_sent > time{
    float: right;
}
.msg_container_base::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

.btn-group.dropup{
    position:fixed;
    left:0px;
    bottom:0;
}
</style>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content" style="height: 600px; overflow: auto;">
				<div class="dashboard_content_main">
					<div class="co150">
                        <h1>Chats</h1>
                        
                        <!-- <div class="row">
                            <div class="col-sm-4">
                                awd
                            </div>
                            <div class="col-sm-4">
                                awd
                            </div>
                        </div> -->

                        <div class="container">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading top-bar">
                                            <div class="col-md-8 col-xs-8">
                                                <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span> Contacts</h3>
                                            </div>
                                        </div>
                                        <table class="table table-striped table-hover">
                                            <tbody id="contact-list"></tbody>
                                        </table>
                                    </div>
                                </div>
                                    
                                    
                                    
                                <div class="col-sm-8">
                                    <div class="chatbody" id="chatbody">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading top-bar">
                                                <div class="col-md-8 col-xs-8 col-sm-8">
                                                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - with</h3>
                                                </div>
                                            </div>
                                            <div class="panel-body msg_container_base" id="chats-list">
                                                <h3 style="text-align:center">SELECT PERSON TO CHAT</h3>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-lg-10">
                                                        <input type="text" id = "input-msg" class="form-control" placeholder="Write your message here..." />
                                                    </div><!-- /.col-lg-6 -->
                                                    <div class="col-lg-2">
                                                        <br>
                                                        <button id = "send-msg" class="btn btn-primary btn-sm btn-block" type="button"><i class="fa fa-send fa-1x" aria-hidden="true"></i></button>
                                                    </div><!-- /.col-lg-6 -->
                                                </div><!-- /.row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
					    </div>
                        

				</div>
			</div>			
		</div>
	</div>
	
<?php include('partials/app-scripts.php'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="js/script.js"></script>
<script src="js/new_script.js"></script>
<script>
	//pie chart//
	// $(document).on('click', '#modal-2', function() {
	// 	var data = {fetchSelectedProductDashboard:1,action:'single_product',id:$(this).data('id')};
	// 	fetchSelectedProduct(data,2);
	// 	$('#statusModal2').modal('show');
	// });
    chatFunction({chats:'contact_list'});
    function chatFunction(data){
			$.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: data,
				dataType: "json",
				success: function(response) {
                    switch (data.chats) {
                        case 'contact_list':
                            $("#contact-list").html(response.content);
                            break;
                        case 'pick_chat':
                            $("#chats-list").html(response.content);
                            break;
                        case 'send_msg':
                            $("#chats-lists").html(response.content);
                            break;
                        default:
                            alert('ERROR 404');
                            break;
                    }
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
	}
	$(document).on('click', '#pick-person', function() {
		var data = {
					chats:'pick_chat',
					id:$(this).data('id')
					};
        chatFunction(data);
	});
    $(document).on('click', '#send-msg', function() {
		var data = {
					chats:'send_msg',
                    room_id:$('#room_id').val(),
					msg:$('#input-msg').val()
					};
        if (data.msg != '' && data.msg != undefined) {
            chatFunction(data);
            var data2 = {
					chats:'pick_chat',
					id:$('#ka_talk').val()
					};
            chatFunction(data2);
            $("#input-msg").val("");
            scrollToBottom();
        }
        
	});
    function scrollToBottom() {
        var chatMessages = document.getElementById("chatbody");
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
</script>
</body>
</html>


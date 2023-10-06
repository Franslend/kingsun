<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: login.php');
	$_SESSION['table'] = 'users';
	$user = $_SESSION['user'];


	$show_table = 'users';
	$users = include('database/show.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Users - Inventory Management System</title>
	<?php include('partials/app-header-scripts.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/login.css ?v=<?php echo time(); ?>">
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
.floating-card {
    position: absolute;
    bottom: 60px;
    width: 300px;
    z-index: 1000;
  }

</style>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">		
					<div class="row">
						<div class="column column-12">
							<h1 class="section_header"><i class="fa fa-list"></i> Chats</h1>
							<div class="section_content">
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
                                                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - <span id="chat-with"> with </span></h3>
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
                                                        <div class="floating-card panel panel-default" id="emoji-card" style="display: none;">
  <div class="panel-heading">
    <h2 class="panel-title">Emojis</h2>
  </div>
  <div class="panel-body">
    <div class="icon-cont">
      <!-- Emoji spans -->
      <button class="clickable-emoji">😂</button>
      <button class="clickable-emoji">😃</button>
      <button class="clickable-emoji">😄</button>
      <button class="clickable-emoji">👽</button>
    </div>
  </div>
</div>
                                                            <br>
                                                            <button id = "send-emoji" class="btn btn-primary btn-sm " type="button"><i class="fas fa-smile"></i></button>
                                                            <button id = "send-msg" class="btn btn-primary btn-sm " type="button"><i class="fa fa-send fa-1x" aria-hidden="true"></i></button>
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
		</div>
	</div>


<?php include('partials/app-scripts.php'); ?>
<script>
	//pie chart//
	// $(document).on('click', '#modal-2', function() {
	// 	var data = {fetchSelectedProductDashboard:1,action:'single_product',id:$(this).data('id')};
	// 	fetchSelectedProduct(data,2);
	// 	$('#statusModal2').modal('show');
	// });
    $(document).on('click', '#send-emoji', function() {
        $('#emoji-card').toggle(); 
    });
    $(document).on('click', '.clickable-emoji', function() {
        var emoji = $(this).text(); // Get the emoji text
        var inputMsg = $('#input-msg');
        inputMsg.val(inputMsg.val() + emoji);
    });
    chatFunction({chats:'contact_list'});
    function chatLoadFunction(data){
        $.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: data,
				dataType: "json",
				success: function(response) {
                    $("#chats-list").html(response.content);
                    // $("#input-msg").val("");
                    scrollToBottom();
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
            //alert(1)
    }
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
                            $("#chat-with").html(response.chat_with);
                            $("#chats-list").html(response.content);
                            break;
                        case 'send_msg':
                            $("#chats-lists").html(response.content);
                            break;
                        default:
                            alert('ERROR 404');
                            break;
                    }
                    scrollToBottom();
                    $("#emoji-card").css("display", "none");
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
            //alert(2)
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
        }
        var data2 = {
					chats:'pick_chat',
					id:$('#ka_talk').val()
					};
        chatLoadFunction(data2);
        $("#input-msg").val("");
	});
    function scrollToBottom() {
        var chatMessages = document.getElementById("chats-list");
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
   $(document).ready(function() {
      var interval; 
      var timeout; 
      $('#chats-list').on('scroll', function() {
        clearTimeout(timeout);
        clearInterval(interval);
        console.log('User scroll');
        timeout = setTimeout(function() {
          interval = setInterval(function() {
            var data2 = {
              chats: 'pick_chat',
              id: $('#ka_talk').val()
            };
            chatLoadFunction(data2);
            console.log('User not scroll');
          }, 1000);
        }, 3000);
      });

    });
    
</script>





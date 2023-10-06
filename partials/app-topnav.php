<div class="dashboard_topNav">
	<div id="time" class="time">
		<script type="text/javascript">
			tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

			function GetClock(){
				var d=new Date();
				var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
				var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

				if(nhour==0){ap=" AM";nhour=12;}
				else if(nhour<12){ap=" AM";}
				else if(nhour==12){ap=" PM";}
				else if(nhour>12){ap=" PM";nhour-=12;}

				if(nmin<=9) nmin="0"+nmin;
				if(nsec<=9) nsec="0"+nsec;

				document.getElementById('clockbox').innerHTML=""+tmonth[nmonth]+" "+ndate+", "+nyear+" "+tday[nday]+", "+nhour+":"+nmin+":"+nsec+ap+"";
			}

			window.onload=function(){
				GetClock();
				setInterval(GetClock,1000);
			}
		</script> 
		<body>
			<div id="clockbox"></div>
		</body>
    <style>
      .btn-primary .badge {
          color: #eee !important;
          background-color: #cd0a0a !important;
      }
      /* Set a fixed height for the scrollable menu */
      .scrollable-menu {
          max-height: 280px; /* Set the fixed height to 300px */
          overflow-y: auto; /* Enable vertical scrolling */
      }
      .scrollable-menu::-webkit-scrollbar {
            width: 0;
            background: transparent; /* Set the background to transparent */
        }
        
      .left-img {
          width: 50px; /* Set the maximum width of the image */
          height: 50px;
          vertical-align: middle; /* Align the image vertically */
          float: left; /* Float the image to the left */
      }

      /* Style the right-side text */
      .text {
          vertical-align: middle; /* Align the text vertically */
          display: inline-block; /* Display the text on the same line as the image */
          overflow: hidden; /* Hide text overflow if it's too long */
          white-space: nowrap; /* Prevent text from wrapping to the next line */
          font-size:13px;
          margin-left:20px;
          width: 200px;
      }

    </style>
	</div>
	
	<a href="" id="toggleBtn"></a>

  <div class="givemeabreak">

       <div>

    </div>
    
    <div>

      <!-- <a href="./database/logout.php"><i class="fa-solid fa-power-off"></i>Log Out</a> -->
      <!-- Default dropstart button -->
        <!-- <div class="btn-group dropstart">
          <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-gear"></i>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item active" href="#"><i class="fa-solid fa-power-off"></i> LOGOUT</a></li>
          </ul>
        </div> -->
    </div>
  </div>
      <div class="row">
        <div class="col-md-6">
          
        <?php
    $currentURL = $_SERVER['REQUEST_URI'];
    $parts = explode('/', $currentURL);
    $lastParam = end($parts);
    $lastParamWithoutExtension = str_replace('.php', '', $lastParam);
    if ($_SESSION['user']['role'] != 'employee') {
      if ($lastParamWithoutExtension == 'pos') {
        echo '<a href="dashboard.php" class="posBtn"> <i class="bi bi-arrow-left-circle-fill"></i> DASHBOARD</a>';
      }else{
        echo '<a href="pos.php" class="posBtn"><i class="fab fa-product-hunt"></i> POS</a>';
      }
    }

    ?>  

        </div>
        <div class="col-md-6 text-right">
            <!-- <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  NOTIFICATION <span class="badge text-danger">4</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu3">
                  <li><a href="#">Action</a></li>
                </ul>
            </div>   -->
            <div class="btn-group" role="group" aria-label="...">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" aria-expanded="false">
                NOTIFICATION <span class="badge text-danger" id="countNotif"></span>
                </button>

                <ul class="dropdown-menu dropdown-menu-right scrollable-menu" id = "notificationList" style="margin-top:10px;">
                  <!-- <li style="margin-top:10px;">
                    <a class="dropdown-item" href="product-view.php?productName=R404A"> 
                    <img src="uploads/products/product-1683134085.jpeg" alt="Image" class="left-img">
                    <span class="text">PRODUCT NAME <span class="label label-danger">UNREAD</span><br>REMAINING STOCK <br> 1</span>
                    </a>
                  </li>
                  <li style="margin-top:10px;">
                    <a class="dropdown-item" href="product-view.php?productName=R404A"> 
                    <img src="uploads/products/product-1683300249.jpeg" alt="Image" class="left-img">
                    <span class="text">PRODUCT NAME <span class="label label-success">READ</span><br>REMAINING STOCK <br> 1</span>
                    </a>
                  </li> -->
                  
                </ul>

              </div>
              <button type="button" class="btn btn-danger" id="logout-button"title="LOGOUT"><i class="fa-solid fa-power-off"></i></button>
            </div>



        </div>
      </div>




</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
  $("#logout-button").click(function () {
      window.location.href = "./database/logout.php"; 
  });


  $(function () {
    //$(notificationList
   notificationList();
   setInterval(notificationList, 1000);
   function notificationList() {
      $.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: {notification:'list'},
				dataType: "json",
				success: function(response) {
          $('#notificationList').html(response.output);
          $('#countNotif').html(response.count);
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
   }
    $(document).on('click',"#clickNotif", function () {
      $.ajax({
				url: "fetchProduct.php",
				type: "POST",
				data: {notification:'readProudct',id:$(this).data('id')},
				dataType: "json",
				success: function(response) {
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
				}
			});
    });
  });

document.addEventListener("DOMContentLoaded", function() {
  var dropdownBtns = document.getElementsByClassName("dropdown-btn");
  
  // Toggle dropdown when the trigger is clicked
  Array.from(dropdownBtns).forEach(function(btn) {
    btn.addEventListener("click", function(event) {
      event.preventDefault();
      event.stopPropagation();
      var dropdownContent = this.nextElementSibling;
      dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
    });
  });

  // Close dropdowns when clicking outside
  document.addEventListener("click", function(event) {
    if (!event.target.closest(".dropdown")) {
      closeAllDropdowns();
    }
  });

  // Close dropdowns when pressing the Escape key
  document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
      closeAllDropdowns();
    }
  });

  // Close all dropdowns except the clicked one
  function closeAllDropdowns() {
    var dropdownContents = document.getElementsByClassName("dropdown-content");
    Array.from(dropdownContents).forEach(function(content) {
      content.style.display = "none";
    });
  }
});
</script>



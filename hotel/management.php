<?php
require_once "php/require_auth.php";
requireAuthentication(true);
?>

<!DOCTYPE html>
<html>
<head>
<title>Reservation</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/managment.css">
</head>
<body>
<header><h2>Reservations Managment</h2><p>Signed in as <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></p><a class="back-link" href="php/logout.php">Log out</a></header>
<main>
<table cellpadding="0" cellspacing="0"  border="1" >
  <thead>
     <caption><label>Users</legend><fieldset class="search"><legend>Search:</legend><input placeholder="Type 'name' or 'id' to search" id="search_input" onkeyup="search_reservation()" type="search" ></fieldset></caption>
      <tr>
      <th></th>
     <th>Names</th>
     <th>R.Id</th>
     <th>Email</th>
     <th>Phone</th>
     <th>Check-in</th>
     <th>Check-out</th>
     <th>Guests</th>
     <th>Type</th>
     <th>Total Price</th>
     <th>Receipt</th>
     <th>Requests</th>
     </tr>
  </thead>
  <tbody id="content"></tbody>
</table>

<div id="popup">
   <h2><label for="">Reservation Details</label><button onclick="document.getElementById('popup').style.display='none';">close</button></h2>
   <div id="details">
      <form method="post" action="php/update_reservation.php">
           <p><fieldset><legend>Reservaction ID:</legend><label id="id"></label> <input name="id" id="hidden" type="hidden"></fieldset></p>
           <p><fieldset><legend>Full Names:</legend><input name="name" id="name" type="text"></fieldset></p>
           <p><fieldset><legend>Email:</legend><input name="email" id="email" type="email"></fieldset></p>
           <p><fieldset><legend>Phone Number:</legend><input name="phone" id="phone" type="text"></fieldset></p>
           <p><fieldset><legend>Guests:</legend><input name="guest" id="guest" type="number" oninput="updateTotalPrice()"></fieldset></p>
           <input id="nights" type="hidden">
           <p><fieldset><legend>Total Price:</legend><input id="total_price" type="text" readonly></fieldset></p>
           <p><fieldset><legend>Check-in Date:</legend><input name="check_in" id="check_in" type="date"></fieldset></p>
           <p><fieldset><legend>Check-Out Date:</legend><input name="check_out" id="check_out" type="date"></fieldset></p>
           <p><fieldset><legend>Room type:</legend><select name="room_type" id="room_type"><option value="Standard">Standard</option><option value="VIP">VIP</option></select></fieldset></p>
           <p><fieldset><legend>Other Request:</legend><input name="request" id="request" type="text"></fieldset></p>
           <p class="buttons"><a id="delete_reservation" style="display: none;" href=""></a><button type="submit">Update</button><button type="button" onclick="document.getElementById('delete_reservation').click();">Delete</button><button onclick="document.getElementById('confirm').style.display='block';" type="button">Accept & Print</button></p>
       </form>
   </div>
</div>






<div id="confirm">
   <div id="confirm_window">
      <h2>Calculated Price</h2>
      <p>By clicking on Confirm and print, the reservation would be confirmed and invoivce would be printed.</p>
      <p><button onclick="acceptAndPrint()">Confirm and print</button><button onclick="document.getElementById('confirm').style.display='none';">Cancel</button></p>
   </div>

   <!-- Printable Details-->
 <div id="printableArea">
      <section class="receipt">
         <div class="receipt-head"><p class="receipt-brand">FIVE STAR HOTEL</p><h2>Reservation Receipt</h2><p>Thank you for choosing to stay with us.</p></div>
         <div class="receipt-number">Receipt accepted &bull; Reservation #<strong id="id_p"></strong></div>
         <div class="receipt-details">
            <div class="receipt-row"><span>Guest name</span><strong id="name_p"></strong></div>
            <div class="receipt-row"><span>Email</span><strong id="email_p"></strong></div>
            <div class="receipt-row"><span>Phone</span><strong id="phone_p"></strong></div>
            <div class="receipt-row"><span>Room type</span><strong id="room_type_p"></strong></div>
            <div class="receipt-row"><span>Guests</span><strong id="guest_p"></strong></div>
            <div class="receipt-row"><span>Check-in</span><strong id="check_in_p"></strong></div>
            <div class="receipt-row"><span>Check-out</span><strong id="check_out_p"></strong></div>
            <div class="receipt-row"><span>Special request</span><strong id="request_p"></strong></div>
         </div>
         <div class="receipt-total"><div><span>Rate per night</span><strong id="rate_p"></strong></div><div><span>Number of nights</span><strong id="nights_p"></strong></div><div class="grand-total"><span>Total cost</span><strong id="total_price_p"></strong></div></div>
         <p class="receipt-footer">We look forward to welcoming you.</p>
      </section>
   </div>
</div>
</main>
</body>
</html>
<script>
   const fetch= new XMLHttpRequest();
   document.getElementById("content").innerHTML = "";
   fetch.open("get","php/get_reservations.php");
   fetch.onload = function (){
      if(fetch.status == 200){
         const result=JSON.parse(fetch.response);
         for(let i=0; i < result.length; i++){
            document.getElementById("content").innerHTML += "<tr><td class='button' onclick='view_reservation("+result[i].id+")'>View</td><td>"+result[i].name+"</td><td>"+result[i].id+"</td><td>"+result[i].email+"</td><td>"+result[i].phone+"</td><td>"+result[i].check_in+"</td><td>"+result[i].check_out+"</td><td>"+result[i].guest+"</td><td>"+result[i].room_type+"</td><td>$"+Number(result[i].total_price).toFixed(2)+"</td><td>"+(Number(result[i].receipt_accepted) === 1 ? "Accepted" : "Pending")+"</td><td>"+result[i].request+"</td></tr>"
         }
      }
   }
   fetch.send();


   function search_reservation(){
 const xh= new XMLHttpRequest();
 document.getElementById("content").innerHTML = "";

 let key = document.getElementById("search_input").value;

   xh.open("get","php/search_reservation.php?key="+key);
   xh.onload = function (){
      if(xh.status == 200){
         const result=JSON.parse(xh.response);
         for(let i=0; i < result.length; i++){
            document.getElementById("content").innerHTML += "<tr><td class='button' onclick='view_reservation("+result[i].id+")'>View</td><td>"+result[i].name+"</td><td>"+result[i].id+"</td><td>"+result[i].email+"</td><td>"+result[i].phone+"</td><td>"+result[i].check_in+"</td><td>"+result[i].check_out+"</td><td>"+result[i].guest+"</td><td>"+result[i].room_type+"</td><td>$"+Number(result[i].total_price).toFixed(2)+"</td><td>"+(Number(result[i].receipt_accepted) === 1 ? "Accepted" : "Pending")+"</td><td>"+result[i].request+"</td></tr>"
         }
      }
   }
   xh.send();
   }

   function view_reservation(n){
      let parent = document.getElementById('details');
      document.getElementById("popup").style.display="block";
       const xh=new XMLHttpRequest();
       xh.open("get","php/reservation_details.php?id="+n);
   xh.onload = function (){
      if(xh.status == 200){
         const result=JSON.parse(xh.response);

            document.getElementById("hidden").value=result.id;
            document.getElementById("id").innerHTML=result.id;
            document.getElementById("id_p").innerHTML=result.id;

            document.getElementById("delete_reservation").href="php/delete.php?id="+result.id;
            
            document.getElementById("name").value=result.name;
            document.getElementById("name_p").textContent=result.name;
            
            document.getElementById("email").value=result.email;
            document.getElementById("email_p").textContent=result.email;

            document.getElementById("phone").value=result.phone;
            document.getElementById("phone_p").textContent=result.phone;

            document.getElementById("check_in").value=result.check_in;
            document.getElementById("check_in_p").textContent=result.check_in;

            document.getElementById("check_out").value=result.check_out;
            document.getElementById("check_out_p").textContent=result.check_out;

            document.getElementById("guest").value=result.guest;
            document.getElementById("guest_p").textContent=result.guest;
            document.getElementById("nights").value=result.nights;

            document.getElementById("room_type").value=result.room_type;
            document.getElementById("room_type_p").textContent=result.room_type;

            document.getElementById("request").value=result.request;
            document.getElementById("request_p").textContent=result.request || "None";
            document.getElementById("nights_p").textContent=result.nights;
            const totalPrice = Number(result.total_price) || 0;
            const rate = result.nights > 0 ? totalPrice / Number(result.nights) : 0;
            document.getElementById("rate_p").textContent="$"+rate.toFixed(2);
            document.getElementById("total_price_p").textContent="$"+totalPrice.toFixed(2);
            updateTotalPrice();
         
      }
   }
   xh.send();
   }

   function updateTotalPrice(){
      const nights = Number(document.getElementById("nights").value) || 0;
      const guests = Math.max(Number(document.getElementById("guest").value) || 1, 1);
      let pricePerNight = 0;

      if(nights >= 1 && nights <= 2){
         pricePerNight = 120;
      }
      else if(nights <= 6){
         pricePerNight = 100;
      }
      else if(nights > 6){
         pricePerNight = 80;
      }

      const totalPrice = nights * pricePerNight * (1 + (guests - 1) * 0.5);
      document.getElementById("total_price").value="$"+totalPrice.toFixed(2);
   }

   function acceptAndPrint(){
      const id = document.getElementById("hidden").value;
      const xh = new XMLHttpRequest();
      xh.open("post", "php/accept_reservation.php");
      xh.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xh.onload = function (){
         if(xh.status == 200){
            window.print();
            document.getElementById('confirm').style.display='none';
         }
      }
      xh.send("id="+encodeURIComponent(id));
   }
</script>

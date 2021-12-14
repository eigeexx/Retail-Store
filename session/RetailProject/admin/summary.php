<?php

include_once '../env/connection.php';
include_once '../env/adminAuth.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Admin | Summary</title>
  </head>
  <body>
        <?php include "./components/nav.html"?>

        <div class="container mt-5">
        <table class="table table-striped table-hover table-success">
                <thead>
                    <tr>
                        <th scope="col">Cart ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Items</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>

                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $branchID = $_SESSION['branchID'] ;
                    $orders_query = "SELECT * FROM customer NATURAL join cu_orders_ca NATURAL join cart where cu_orders_ca.status=1 AND customer.cust_ID=cu_orders_ca.customer_ID AND branch_ID=$branchID"; 
                    $orders_result = mysqli_query($conn,$orders_query);
                    $orders_Check = mysqli_num_rows($orders_result);
                   
                        if ($orders_Check>0) {                                                       
                            while($orders_row = mysqli_fetch_assoc($orders_result)) {
                               echo"<tr>
                                    <td>".$orders_row['cart_ID']."</td>
                                    <td>". $orders_row['cust_FName'] ." ".$orders_row['cust_LName'] ."</td>
                                    <td>"; ?> <button type="button" class="badge btn btn-secondary" onclick="showDetails(<?php  echo $orders_row['cart_ID'] ;?>)" >Show Items</button></td>
                                     <?php echo "
                                    <td>" .  $orders_row['total']."</td>
                                    <td>". $orders_row['order_Date'] ."</td>
                                    <td>". $orders_row['cust_ABrgy'] .", ".$orders_row['cust_ACity'] .", ".$orders_row['cust_AProvince'] .", ".$orders_row['cust_APostal'] ."</td>
                                    <td> </td>
                                    <td>"?> <button type="button" class="btn btn-secondary" >Action</button> <?php "</td>
                                    </tr>";
                            }
                        } 

                     

                        
                        
                      
                        
                    ?>
                </tbody>
            </table>  
        </div>
     
       
    </div>

    <!-- JavaScript Bundle with Popper -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <script type="text/javascript">
        function showDetails(cartID){

            $.post("displayItems.php",{cartID:cartID},function(data,status){
                var json=JSON.parse(data);


                let cleanJSON = json;

                document.getElementById("demo").innerHTML = cleanJSON.map(getItem).join("");

                function getItem(item) {
                return "<tr><td>"+ item.item_ID + "</td><td>"+ item.item_Name + "</td><td>"+ item.item_RetailPrice + "</td><td>"+ item.quantity + "</td></tr>";
                }
                // document.getElementById("demo").innerHTML = myJSON;
            
            });
           
            $('#showItems').modal('show');
        };
    </script>
    <!-- show items modal ##################################-->
    <div class="modal fade" id="showItems" tabindex="-1" aria-labelledby="showItemsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showItemsLabel">Cart Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Item ID</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
  
                        </tr>
                    </thead>
                    <tbody id="demo" >
                      

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
            </div>
        </div>
    </div>

  </body>
</html>
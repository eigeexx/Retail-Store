<?php
    include_once '../env/connection.php';

    //variables
	$categ = $branch = "";

	if (isset($_GET['categ']) && isset($_GET['branch'])) {
		$categ = $_GET['categ'];
        $branch = $_GET['branch'];
	}

    if ($categ == "PastaNoodles") {
        $categ = "Pasta & Noodles";
    }

    //select branch ID
	$sqlCateg = "SELECT * FROM Item i
                    INNER JOIN BI_has_I bii ON (i.item_ID = bii.item_ID)
                    INNER JOIN branchInventory bi ON (bi.inventory_ID = bii.inventory_ID)
                    INNER JOIN B_has_BI bbi ON (bbi.inventory_ID = bi.inventory_ID)
                    INNER JOIN Branch b on (b.branch_ID = bbi.branch_ID)
                    WHERE i.item_Category = '$categ'
                        AND bii.item_Stock > 0
                        AND b.branch_Name = '$branch'
                ";
	$resCateg = mysqli_query($conn, $sqlCateg);
?>

<html>
<body>
    <?php
        echo $categ;
		if ($resCateg) {
			$i = $row = 0;
			$count = mysqli_num_rows($resCateg); //number of rows sa table
	?>
			<table>
			<tr>
	<?php
			    while (($rowCateg = mysqli_fetch_assoc($resCateg))) {
					$itemName = $rowCateg['item_Name']; //item name
					$itemPrice = $rowCateg['item_RetailPrice']; //item price
					$itemImg = $rowCateg['item_Image']; //item image
	?>
				<td>
					<form action="main.php?action=add&name=<? echo $name ?>&item=<? echo $itemName ?>&branch=<? echo $branch ?>" method='post'>
					<div class='itemOption'>
						<input type="image" src="<? echo $itemImg ?>" />
						<div class='info'>
							<span> <? echo $itemName ?> </span> P<? echo $itemPrice ?>
						</div>
					</div>
					</form>
				</td>
	<?php
					$i++; //number of items in row
					if($i % 4 == 0) { //4 items per row display
						echo "</tr><tr>"; //next row display
					}

					if(++$row == $count) {
						while ($i % 4 != 0) { //if less than 4 in row display, add extra hidden item until 4 items
							echo "<td>
								<form>
									<div class='itemOption' style='visibility: hidden;'>
										<input type='image' />
										<div class='info'>
											<span></span>
										</div>
									</div>
								</form>
							</td>
							";

							$i++;
						}
					}
				}
					echo "</tr>";
					echo "</table>";
		}
	?>
</body>
</html>



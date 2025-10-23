<?php 
include("header.php");
$cat_dish='';
$type='';
$cat_dish_arr=array();
if(isset($_GET['id']) && $_GET['id']>0){
	
	$id=get_safe_value($_GET['id']);
		$sql="select *from dish where id='$id'";
        $res=mysqli_query($con,$sql);
	}
    if(isset($_GET['cat_dish'])){
        $cat_dish=get_safe_value($_GET['cat_dish']);
        $cat_dish_arr=array_filter(explode(':',$cat_dish));
        $cat_dish_str=implode(",",$cat_dish_arr);
    }
    if(isset($_GET['type'])){
        $type=get_safe_value($_GET['type']);
    }
    $arrType=array("veg","non_veg","both");
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li>Food Detail</li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-page-area pt-100 pb-100">
    <div class="container">
        <div class="grid-list-product-wrapper">
            <?php if(mysqli_num_rows($res)>0){
				while($product_row=mysqli_fetch_assoc($res)){
				 ?>
            <div class="product-grid product-view pb-20">
                <div class="row">
                    <div class="product-width col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-30">
                        <div class="product-wrapper" style="margin-top:-30px; margin-bottom:-90px;">
                            <div class="product-img">
                                <a href="">
                                    <img style="width:500px; height:300px;"
                                        src="<?php echo SITE_DISH_IMAGE.$product_row['image']?>" alt="">
                                </a>
                            </div>
                            <div class="product-content" id="dish_detail">
                                <h4>
                                    <?php
                                                if($product_row['type']=='veg'){
                                                    echo "<img style='width:30px;' src='assets/img/icon-img/veg.png'/>";
                                                    }else{
                                                            echo "<img style='width:30px;' src='assets/img/icon-img/non-veg.png'/>";
                                                        }
                                                        ?>
                                    <a style="color:#0000A0;" href="javascript:void(0)"><?php echo $product_row['dish'];
                                                            getRatingByDishId($product_row['id']);
                                                           ?>
                                    </a>
                                </h4>
                                <?php
                                                           $dish_attr_res=mysqli_query($con,
                                                           "select * from dish_details where status='1'
                                                            and dish_id='".$product_row['id']."' order by price asc");
                                                        ?>
                                <div class="product-price-wrapper">
                                    <?php
                                                            while($dish_attr_row=mysqli_fetch_assoc($dish_attr_res)){
                                                            if($website_close==0){
                                                             echo "<input type='radio' class='dish_radio'
                                                             name='radio_".$product_row['id']."'
                                                             id='radio_".$product_row['id']."'
                                                              value='".$dish_attr_row['id']."'
                                                             />";
                                                            }
                                                             echo $dish_attr_row['attribute'];
                                                            echo "&nbsp;&nbsp";
                                                             echo "<span class='price'>(Rs. ".$dish_attr_row['price'].")</span>";
                                                             $added_msg="";
                                                             if(array_key_exists($dish_attr_row['id'],$cartArr)){
                                                                $added_qty=getUserFullCart($dish_attr_row['id']);
                                                               $added_msg="(Added = $added_qty)";
                                                             }
                                                           echo "<span class='cart_already_added' 
                                                                id='shop_added_msg_".$dish_attr_row['id']."'>
                                                                ".$added_msg."
                                                                </span>";
                                                            }
                                                            ?>
                                    <?php if($website_close==0){?>
                                    <div class="product-price-wrapper">
                                        <select style="width:10%;" class="select"
                                            id="qty<?php echo $product_row['id']?>">

                                            <option value="0">Qty</option>
                                            <?php
                                                                   for($i=1;$i<=100;$i++){
                                                                       echo "<option>$i</option>";
                                                                   }
                                                                   ?>
                                        </select>
                                        <i class="fa fa-cart-plus cat_icon" aria-hidden="true"
                                            onclick="add_to_cart('<?php echo $product_row['id']?>','add')"></i>
                                    </div>
                                    <div style="color:#A52A2A;">
                                        <?php echo '<br/>' .$product_row['dish_detail'];?>
                                    </div>
                                    <?php 
                                                          }
                                                            ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                          }
                         } 
                         ?>
            </div>
        </div>
    </div>
</div>
<form method="get" id="frmCatDish">
    <input type="hidden" name="cat_dish" id="cat_dish" value='<?php echo $cat_dish ?>' />
    <input type="hidden" name="type" id="type" value='<?php echo $type ?>' />
</form>
<?php 
include("footer.php");
?>
$(document).ready(function(){
	showmyitem();
	$(".addtocart").click(function(){
		var id = $(this).data('id');
		var name = $(this).data('name');
		var price = $(this).data('price');
		var photo = $(this).data('photo');
		var qty=$('.qty').val();

		//console.log(id+name+price+photo+qty);
		var item = {
					id:id,
					name:name,
					price:price,
					photo:photo,
					qty:qty,
				};
			var itemString = localStorage.getItem("items");
			var itemArray
			if(itemString == null){
					itemArray = Array();
				}else{
					itemArray = JSON.parse(itemString);
				}
				var status=false;
				//var exit=false;
				$.each(itemArray,function(i,v){
					// alert(i);
						if (id==v.id) {
							status=true;
							v.qty++;
						}

					})

					if (!status) {
						itemArray.push(item);
					}
				

				var itemData = JSON.stringify(itemArray);
				localStorage.setItem("items",itemData);
				count();
	})

	$(".cartdrop").click(function(){
		var itemString = localStorage.getItem("items");
				if(itemString){
					var itemArray = JSON.parse(itemString);
				}
				// console.log(itemArray);
				var html =''; var html1=""; var total=0;
				var bookingcart = 0;

				$.each(itemArray,function(i,v){
					var id = v.id;
					var name = v.name;
					var photo = v.photo;
					var price =v.price;
					var qty =v.qty;

					var subtotal=qty*price;
					total+=subtotal;
					var photo_link = "http://enjoywithme.khaingthinkyi.me/" + photo
					//console.log(photo);

					

					html+=`<div class="header-cart-item-img">
										<img src="${photo_link}">
									</div>

									<div class="header-cart-item-txt">
										<a href="#" class="header-cart-item-name">
											${name}
										</a>

										<span class="header-cart-item-info">
											${qty} x ${price}
										</span>

									</div>
					`

				})
				$(".cartli").html(html);
				$(".carttotal").html(total);
	})
	
	function showmyitem(){
				var itemString = localStorage.getItem("items");
				if(itemString){
					var itemArray = JSON.parse(itemString);
				}
				// console.log(itemArray);
				var html =''; var j=1; var total=0;
				var bookingcart = 0;

				$.each(itemArray,function(i,v){
					var id = v.id;
					console.log(id);
					var name = v.name;
					var size=v.size
					var photo = v.photo;
					var price =v.price;
					var qty =v.qty;
					var qty =v.qty;

					var subtotal=qty*price;
					total+=subtotal;
					 

					html+=`
						<tr>
                              <td>
                                  <div class="media">
                                      <div class="d-flex">
                                          <img src="${photo}" alt="">
                                      </div>
                                      <div class="media-body">
                                          <p>${name}</p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5>${price}</h5>
                              </td>
                              <td>
                                  <div class="product_count">
                                      <input type="text" name="qty" id="sst" maxlength="12" value="${qty}" title="Quantity:"
                                          class="input-text qty">
                                      <button class="increase items-count" type="button" data-id="${i}"><i class="lnr lnr-chevron-up"></i></button>
                                      <button class="reduced items-count" type="button" data-id="${i}"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td>
                                  <h5 class="subtotal">${subtotal}</h5>
                              </td>
                          </tr>
					`
				})
					//console.log(total);
				$(".tbody").html(html);
				$(".carttotal").html(total);
				
			}
			count();
	function count()
      {
        var total = 0;
        var itemString = localStorage.getItem("items");
		if(itemString){
		var itemArray = JSON.parse(itemString);
          $.each(itemArray, function(i,v){
          	//console.log(v.qty);
          	total+=parseInt(v.qty);
          });
        }
        //console.log(total);
         $('.count').html(total);
    }

   $('tbody').on('click','.increase',function () {
   	
				var id = $(this).data('id');
				console.log(id);
				var itemString = localStorage.getItem('items');
				if(itemString){
					var itemArray = JSON.parse(itemString);
					
					$.each(itemArray,function (i,v) {
						if (i== id) {
							v.qty++;
						}
					})
					cart = JSON.stringify(itemArray);
					localStorage.setItem('items',cart);
					showmyitem();
					count();
				}
				
			})
    $(".tbody").on('click','.reduced',function(){
    	var id = $(this).data('id');
		var size=$(this).data('size');
				console.log(id);
				var itemString = localStorage.getItem('items');
				if(itemString){
					var itemArray = JSON.parse(itemString);
					
					$.each(itemArray,function (i,v) {
						if (i == id) {
							//alert("ok");
							v.qty--;
							if(v.qty==0){
								//alert("ok");
								itemArray.splice(id,1);
							}
						}
					})
					cart = JSON.stringify(itemArray);
					localStorage.setItem('items',cart);
					showmyitem();
					count()
				}
			})


    
})
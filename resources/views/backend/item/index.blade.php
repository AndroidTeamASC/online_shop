@extends('backend/backend_template')
@section('content')
	<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Item</li>
          </ul>
        </div>
    </div>

    <section>
        <div class="container-fluid">
          <!-- Page Header-->
          	<header> 
	            <h1 class="h3 display">Tables 
	            <button  class="btn btn-primary float-right" data-toggle="modal"  id="createItem">
	       		 	<i class="fa fa-plus"></i> Add Item</button></h1>
						</header>
          	<div class="row">
	            <div class="col-lg-12">
	              <div class="card">
	               <!--  <div class="card-header">
	                  <h4>Basic Table</h4>
	                </div> -->
	                <div class="alert alert-primary alertMessage d-none float-left col-md-4 col-sm-2 offset-4 mt-3">
	       				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      			</div>
	                <div class="card-body">
	                  <div class="table-responsive">
	                    <table class="table">
	                      <thead>
	                        <tr>
	                          <th>No</th>
	                          <th>Item Name</th>
	                          <th>Item Image</th>
	                          <th>Action</th>
	                        </tr>
	                      </thead>
	                      <tbody id="tableBody">
							</tbody>
	                    </table>
	                  </div>
	                </div>
	              </div>
	            </div>
            
          </div>
        </div>
      </section>


     <!-- Add New Item -->
	<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<form id="itemForm" name="itemForm" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="modelHeading"></h5>
						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="col-6 offset-3 my-2">
								<div class="form-group">
									<label for="type">Item Name</label>
									<input type="text" class="form-control @error('item') is-invalid @enderror" id="item_name" name="item_name" autofocus required>
										<p class="error-message-item_name p-2 text-md-left text-danger"></p>
								</div>
								<div class="form-group">
									<label for="type">Item Price</label>
									<input type="text" class="form-control @error('item') is-invalid @enderror" id="item_price" name="item_price" autofocus required>
										<p class="error-message-item_price p-2 text-md-left text-danger"></p>
								</div>
								<div class="form-group">
									<label for="type">Item Image</label>
									<input type="file" class="form-control @error('item') is-invalid @enderror" id="item_image" name="item_image" >
										<p class="error-message-item_image p-2 text-md-left text-danger"></p>
								</div>
								<div class="form-group">
									<label for="type">Brand </label>
									<select name="brand" class="form-control">
										<option>Choose Brand</option>
										@foreach($brands as $brand)
										<option value="{{$brand->id}}">{{$brand->brand_name}}</option>
										@endforeach
									</select>
										<p class="error-message-item_brand p-2 text-md-left text-danger"></p>
								</div>
								<div class="form-group">
									<label for="type">Category </label>
									<select name="category" class="form-control">
										<option>Choose Category</option>
										@foreach($categories as $category)
										<option value="{{$category->id}}">{{$category->category_name}}</option>
										@endforeach
									</select>
										<p class="error-message-item_category p-2 text-md-left text-danger"></p>
								</div> 
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary save" name="button" id="saveBtn"><i class="fas fa-save"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Eidt Item -->
	<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
	      <div class="modal-content">
	        <form id="editItemForm" name="editItemForm" method="POST" enctype="multipart/form-data">
	          <input type="hidden" name="edit_item_id" id="edit_item_id">
	          <div class="modal-header">
	            <h5 class="modal-title" id="edit_modelHeading"></h5>
	            
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <div class="container-fluid">
	              <div class="col-12 my-2">
	                <div class="form-group row">
	                  
	                  <label for="edit_name" class="col-md-4 col-form-label text-md-right">Item Name</label>
	                  <div class="col-md-6">
	                    <input type="text" class="form-control @error('edit_item_name') is-invalid @enderror" id="edit_item_name" name="edit_item_name" autofocus required>
	                      <p class="error-message-edit-item_name p-2 text-md-left text-danger"></p>
	                  </div>
	                </div>
	                <div class="form-group row">
	                  <label for="edit_phone_no" class="col-md-4 col-form-label text-md-right">Item Price</label>
	                  <div class="col-md-6">
	                    <input type="number" class="form-control @error('edit_item_price') is-invalid @enderror" id="edit_item_price" name="edit_item_price" autofocus required>
	                      <p class="error-message-edit-phone_no p-2 text-md-left text-danger"></p>
	                  </div>
	                </div>
	                
	                <div class="form-group row">
	                  <label for="edit_item_image" class="col-md-4 col-form-label text-md-right">{{ __('Item Picture') }}</label>

	                  <div class="col-md-6">
	                      <input type="hidden" name="item_old_image" id="item_old_image">
	                      <input id="edit_item_image" type="file" class="form-control @error('edit_item_image') is-invalid @enderror" name="edit_item_image" value="{{ old('edit_item_image') }}" autocomplete="edit_image" autofocus>
	                      <p class="edit-error-message-image p-2 text-md-left text-danger"></p>
	                      <img class="item_old_image img-fluid pt-2" style="width: 50px">
	                  </div>
	                </div>
	                <div class="form-group row">
						<label for="edit_brand" class="col-md-4 col-form-label text-md-right">Brand </label>
						<div class="col-md-6">
							<select name="edit_brand" class="form-control" id="edit_brand">
							<option>Choose Brand</option>
							@foreach($brands as $brand)
							<option value="{{$brand->id}}">{{$brand->brand_name}}</option>
							@endforeach
						</select>
						<p class="error-message-item_brand p-2 text-md-left text-danger"></p>
						</div>
		
					</div>
					<div class="form-group row">
						<label for="edit_category" class="col-md-4 col-form-label text-md-right">Category </label>
						<div class="col-md-6">
							<select name="edit_category" class="form-control" id="edit_category">
							<option>Choose Brand</option>
							@foreach($categories as $category)
							<option value="{{$category->id}}">{{$category->category_name}}</option>
							@endforeach
						</select>
						<p class="error-message-item_brand p-2 text-md-left text-danger"></p>
						</div>
		
					</div> 
	                
	              </div> 
	              </div>
	            </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	            <button type="submit" class="btn btn-primary save" name="button" id="editSaveBtn"><i class="fas fa-save"></i></button>
	          </div>
	        </form>
	      </div>
	    </div>
 	 </div>

@endsection


@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		getItem()
		var myStopTimer = setInterval(Timer,3000);
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});
		function Timer(){
			$(".alertMessage").addClass('d-none');
		}
		function getItem(){
			var url = "{{route('admin.get_item')}}";
			$.ajax({
				type : 'get',
				url : url,
				processData : false,
				contentData: false,
				success:(data) => {
					var j =1;
					var html = html;
					console.log(data);
					$.each(data,function(i,v){
						html += `<tr>
									<td>${j++}</td>
									<td>${v.item_name}</td>
									<td><img src="{{asset('${v.item_image}')}}" width=200 height = 200></td>
									<td>
										<button class="btn btn-primary btn-sm d-inline-block editItem" data-id="${v.id}"><i class="fa fa-edit text-white"></i></button>
										<button class="btn btn-secondary btn-sm d-inline-block deleteItem" data-id="${v.id}"><i class="fa fa-trash text-white"></i></button>
									</td>
										</tr>	`;
					})
					$('#tableBody').html(html);
				},
				error: function(error){
					console.log(error);
				}
			});
		}

		$('#createItem').click(function (){
		 	alert("message?: DOMString");
			clearInterval(myStopTimer)
			$('#saveBtn').text("Save");
			$('#saveBtn').val('create-type');
			$('#item_id').val('');
			$('#itemForm').trigger("reset");
			$('#modelHeading').html("Create New Brand");
			$('#itemModal').modal('show')
		});

		$('#itemForm').submit(function (e){
			e.preventDefault();
			// $(this).html('Sending....');
			var formData = new FormData(this);
        	
			$.ajax({
				data: formData,
				url: "{{route('admin.item.store')}}",
				type: "POST",
				dataType : "json",
				cache:false,
				processData: false,
				contentType:false,
				success : function (data) {
					$('#itemForm').trigger("reset");
					$('#itemModal').modal('hide');
					$('.alertMessage').removeClass('d-none');
					$('.alertMessage').text(data.success);
					getItem()
					setInterval(Timer,3000);	
				},
				error : function (error) {
					$('#saveBtn').html('Save Change');
					var errors = error.responseJSON.errors;
					if(errors){
						var item_name = errors.item_name;
						var item_price = errors.item_price;
						var item_image = errors.item_image;
						var brand = errors.brand;
						var category = errors.category;
						$('.error-message-item_name').text(item_name)
						$('.error-message-item_price').text(item_price)
						$('.error-message-item_image').text(item_image)
						$('.error-message-brand').text(brand)
						$('.error-message-category').text(category)
						
					}
					$('#saveBtn').html('Save Changes');
				}
			})
		});

	$('tbody').on('click', '.editItem', function () {
      $('.alertMessage').addClass('d-none');
      var item_id = $(this).data('id');
      var url="{{route('admin.item.edit',':id')}}";
      url=url.replace(':id',item_id);
        $.ajax({
          url: url,
          type: "GET",
          dataType: 'json',
          success: function (response) {
            var data = response.item
            var brands = response.brands

            console.log(brands);
              $('#edit_modelHeading').html("Edit Item");
              $('#editSaveBtn').text("Update");
              $('#editItemModal').modal('show');
              $('#edit_item_id').val(data.id);
              $('#edit_item_name').val(data.item_name);
              $('#edit_item_price').val(data.item_price);
              console.log(data.item_image)
              $('#item_old_image').val(data.item_image);
              $('.item_old_image').attr('src',`{{asset('${data.item_image}')}}`);
              $("#edit_brand").val(data.brand_id);
              $("#edit_category").val(data.category_id);
          },
          error: function (error) {
          }
        })
   })

	$('#editItemForm').submit(function (e) {
	        e.preventDefault();
	        /*$(this).html('Sending..'); */
	        var formData = new FormData(this)
	        var id=$('input[name="edit_item_id"]').val();
	        console.log(id);
	        for (var pair of formData.entries())
	          {
	           console.log(pair[0]+ ', '+ pair[1]); 
	          }
	        formData.append('_method', 'PUT');
	        console.log(name);
	        var url="{{ route('admin.item.update',':id') }}";
	        url=url.replace(':id',id);
	        $.ajax({
	          data: formData,
	          url: url,
	          type: "POST",
	          dataType: 'json',
	          cache:false,
	          contentType: false,
	          processData: false,
	          success: function (data) {
	              $('#editItemForm').trigger("reset");
	              $('#editItemModal').modal('hide');
	              console.log(data)
	              $('.alertMessage').removeClass('d-none');
	              $('.alertMessage').text(data.success);
	              getItem()
	              setInterval(Timer, 3000);
	          },
	          error: function (error) {
	            $('#saveBtn').html('Save Changes');
	            var errors=error.responseJSON.errors;
	              if(errors){
	                  var name=errors.name;
	                  var email=errors.email;
	                  var password=errors.password;
	                  var phone_no=errors.phone_no;
	                  var address=errors.address;
	                  $('.error-message-name').text(name)
	                  $('.error-message-email').text(email)
	                  $('.error-message-password').text(password)
	                  $('.error-message-phone_no').text(phone_no)
	                  $('.error-message-address').text(address)
	              }
	            $('#saveBtn').html('Save Changes');
	          }
      })
    })

  	  $('body').on('click', '.deleteItem', function () {
        clearInterval()
        var item_id = $(this).data("id");
        var status = confirm("Are You sure want to delete !");
        if (status) {
          var url="{{route('admin.item.destroy',':id')}}";
          url=url.replace(':id',item_id);
          $.ajax({
              url: url,
              type: "DELETE",
              success: function (data) {
                $('.alertMessage').removeClass('d-none');
                $('.alertMessage').text(data.success);
                getItem()
                setInterval(Timer, 3000);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
    }); 

	
	})
</script>
@endsection
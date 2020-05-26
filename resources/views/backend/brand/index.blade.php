@extends('backend/backend_template')
@section('content')
	<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Brand</li>
          </ul>
        </div>
    </div>

    <section>
        <div class="container-fluid">
          <!-- Page Header-->
          	<header> 
	            <h1 class="h3 display">Tables 
	            <button  class="btn btn-primary float-right" data-toggle="modal"  id="createBrand">
	       		 	<i class="fa fa-plus"></i> Add Brand</button></h1>
						</header>
          	<div class="row">
	            <div class="col-lg-12">
	              <div class="card">
	               <!--  <div class="card-header">
	                  <h4>Basic Table</h4>
	                </div> -->
	                <div class="alert alert-primary alertMessage d-none float-left col-md-4 col-sm-2 offset-4">
	       				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      			</div>
	                <div class="card-body">
	                  <div class="table-responsive">
	                    <table class="table">
	                      <thead>
	                        <tr>
	                          <th>No</th>
	                          <th> Name</th>
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



	<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<form id="brandForm" name="brandForm" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="brand_id" id="brand_id">
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
									<label for="type">Brand Name</label>
									<input type="text" class="form-control @error('tag') is-invalid @enderror" id="brand_name" name="brand_name" autofocus required>
										<p class="error-message p-2 text-md-left text-danger"></p>
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

@endsection


@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		getBrand()
		var myStopTimer = setInterval(Timer,3000);
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});
		function Timer(){
			$(".alertMessage").addClass('d-none');
		}
		function getBrand(){
			var url = "{{route('admin.get_brand')}}";
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
									<td>${v.brand_name}</td>
									<td>
										<button class="btn btn-primary btn-sm d-inline-block editBrand" data-id="${v.id}"><i class="fa fa-edit text-white"></i></button>
										<button class="btn btn-secondary btn-sm d-inline-block deleteBrand" data-id="${v.id}"><i class="fa fa-trash text-white"></i></button>
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

		$('#createBrand').click(function (){
		 	alert("message?: DOMString");
			clearInterval(myStopTimer)
			$('#saveBtn').text("Save");
			$('#saveBtn').val('create-type');
			$('#brand_id').val('');
			$('#brandForm').trigger("reset");
			$('#modelHeading').html("Create New Brand");
			$('#brandModal').modal('show')
		});

		$('#saveBtn').click(function (e){
			e.preventDefault();
			$(this).html('Sending....');
			$.ajax({
				data: $('#brandForm').serialize(),
				url: "{{route('admin.brand.store')}}",
				type: "POST",
				dataType : "json",
				success : function(data) {
					console.log(data);
					$('#brandForm').trigger('reset');
					$('#brandModal').modal('hide');
					$('.alertMessage').removeClass('d-none');
					$('.alertMessage').text(data.success);
					getBrand();
					setInterval(Timer,3000);	
				},error: function(error){
					$('#saveBtn').html('Save Change');
					var errors = error.responseJSON.errors;
					if(errors){
						var brand_name = errors.brand_name;
						$('.error-message').text(brand_name);
					}
				}
			})
		})

		$('tbody').on('click','.editBrand',function(){
		 
			$('.alertMessage').addClass('d-none');
			var brand_id = $(this).data('id');
			var url = "{{route('admin.brand.edit',':id')}}";
			url = url.replace(':id', brand_id);
			$.ajax({
				url: url,
				type: "GET",
				dataType: "json",
				success : function(response) {
					data = response.brand;
					$('#modelHeading').html('Edit Type');
					$('#saveBtn').val("edit-user");
					$('#saveBtn').text('Update');
					$('#brandModal').modal('show');
					$('#brand_id').val(data.id);
					$('#brand_name').val(data.brand_name);
				},
				error :function(error){

				}

			})
		})


		$('tbody').on('click','.deleteBrand',function(){
			clearInterval();
			var brand_id = $(this).data('id');
			var status = confirm("Are your to delte category");
			if(status){
				var url = "{{route('admin.brand.destroy',':id')}}";
				url = url.replace(':id',brand_id);
				$.ajax({
					url: url,
					type: 'DELETE',
					success : function(data){
						$('.alertMessage').removeClass('d-none');
						$('.alertMessage').text(data.success);
						getBrand();
						setInterval(Timer,3000);
					},
					error : function(data){
						console.log("Error", data);
					}
					
				});
			}
		});
	})
</script>
@endsection
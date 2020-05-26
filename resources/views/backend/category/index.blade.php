@extends('backend/backend_template')
@section('content')
	<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Category       </li>
          </ul>
        </div>
    </div>

    <section>
        <div class="container-fluid">
          <!-- Page Header-->
          	<header> 
	            <h1 class="h3 display">Tables 
	            <button  class="btn btn-primary float-right" data-toggle="modal"  id="createCategory">
	       		 	<i class="fa fa-plus"></i> Add Category</button></h1>
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



	<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<form id="categoryForm" name="categoryForm" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="category_id" id="category_id">
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
								<label for="type">Tag</label>
								<input type="text" class="form-control @error('tag') is-invalid @enderror" id="category_name" name="category_name" autofocus required>
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
		getCategory()
		var myStopTimer = setInterval(Timer,3000);
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});
		function Timer(){
			$(".alertMessage").addClass('d-none');
		}
		function getCategory(){
			var url = "{{route('admin.get_category')}}";
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
									<td>${v.category_name}</td>
									<td>
										<button class="btn btn-primary btn-sm d-inline-block editCategory" data-id="${v.id}"><i class="fa fa-edit text-white"></i></button>
										<button class="btn btn-secondary btn-sm d-inline-block deleteCategory" data-id="${v.id}"><i class="fa fa-trash text-white"></i></button>
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

		$('#createCategory').click(function (){
		 
			clearInterval(myStopTimer)
			$('#saveBtn').text("Save");
			$('#saveBtn').val('create-type');
			$('#category_id').val('');
			$('#categoryForm').trigger("reset");
			$('#modelHeading').html("Create New Category");
			$('#categoryModal').modal('show')
		});

		$('#saveBtn').click(function (e){
			e.preventDefault();
			$(this).html('Sending....');
			$.ajax({
				data: $('#categoryForm').serialize(),
				url: "{{route('admin.category.store')}}",
				type: "POST",
				dataType : "json",
				success : function(data) {
					console.log(data);
					$('#categoryForm').trigger('reset');
					$('#categoryModal').modal('hide');
					$('.alertMessage').removeClass('d-none');
					$('.alertMessage').text(data.success);
					getCategory();
					setInterval(Timer,3000);	
				},error: function(error){
					$('#saveBtn').html('Save Change');
					var errors = error.responseJSON.errors;
					if(errors){
						var category_name = errors.category_name;
						$('.error-message').text(category_name);
					}
				}
			})
		})

		$('tbody').on('click','.editCategory',function(){
		 
			$('.alertMessage').addClass('d-none');
			var category_id = $(this).data('id');
			var url = "{{route('admin.category.edit',':id')}}";
			url = url.replace(':id', category_id);
			$.ajax({
				url: url,
				type: "GET",
				dataType: "json",
				success : function(response) {
					data = response.category;
					$('#modelHeading').html('Edit Type');
					$('#saveBtn').val("edit-user");
					$('#saveBtn').text('Update');
					$('#categoryModal').modal('show');
					$('#category_id').val(data.id);
					$('#category_name').val(data.category_name);
				},
				error :function(error){

				}

			})
		})


		$('tbody').on('click','.deleteCategory',function(){
			clearInterval();
			var category_id = $(this).data('id');
			var status = confirm("Are your to delte category");
			if(status){
				var url = "{{route('admin.category.destroy',':id')}}";
				url = url.replace(':id',category_id);
				$.ajax({
					url: url,
					type: 'DELETE',
					success : function(data){
						$('.alertMessage').removeClass('d-none');
						$('.alertMessage').text(data.success);
						getCategory();
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
@extends ('layouts.admin')


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between py-3">
                <h3 class="mb-0">Add Products</h3>
                <a href="{{ url('admin/products') }}" class="btn btn-primary text-white float-end">Back</a>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li><a class="active" href="#info-pills" data-toggle="tab">Product Info</a></li>
                <li class=""><a href="#variation-pills" data-toggle="tab">Description</a></li>
                <li class=""><a href="#price-pills" data-toggle="tab">Price</a></li>
                <li class=""><a href="#seo-pills" data-toggle="tab">SEO</a></li>
            </ul>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-warning mb-3">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form action="{{ url('admin/products') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="tab-content">
                        <div class="tab-pane fade in active show" id="info-pills">

                            <div class="my-3 row">
                                <div class="col-sm-12 col-md-4">
                                    <label class="col-12">Product Name</label>
                                    <input id="name" type="text" name="name"
                                           class="form-control col-12" />
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label>Product Slug</label>
                                    <input id="slug" type="text" name="slug" 
                                           class="form-control col-12" />
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label class="col-12 me-3">Select Brand</label>
                                    <select name="brand_id" class="form-conrol p-2">
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                           
                                <div class="col-sm-12 col-md-4">
                                    <label>Select Parent Category</label>
                                    <select name="category" class="form-control col-12" id="parentCategory">
                                        @foreach ($categories as $category)
                                        @if ($category->parent_id === null)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                        @endforeach
                                    </select> 
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label>Product Type</label>
                                    <select name="type" class="form-control col-12" id="subCategory" disabled>
                                        <option value="">Select Product Type</option>
                                    </select>
                                </div>

                                <div class="my-3 col-sm-12 col-md-4">
                                    <label class="col-form-label">Product Featured image</label>
                                    <div class="">
                                        <div class="input-group">
                                            <input type="file" name="pf_image" required class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class="my-3 col-sm-12 col-md-8">
                                    <div class="form-group">
                                        <label for="gallery_images">Product Gallery</label>
                                        <input type="file" name="image[]" multiple class="form-control-file">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="variation-pills">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 my-3 ">
                                    <label> Product Description</label>
                                    <textarea class="form-control summernote" rows="5" type="textarea" name="description" placeholder="Enter text ..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade in" id="price-pills">
                            <div class="my-3 row">
                                <div class="col-sm-12 col-md-4">
                                    <label> Product Quantity</label>
                                    <input type="text" name="quantity" class="form-control" />
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label> Product Regular Price</label>
                                    <input type="text" name="orginal_price" class="form-control" />
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <label> Product Selling Price</label>
                                    <input type="text" name="selling_price" class="form-control" />
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane fade in" id="seo-pills">
                            <div class="my-3">
                                <label> Product Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" />
                            </div>
                            <div class="my-3">
                                <label> Product Meta Keyword</label>
                                <input type="text" name="meta_keyword" class="form-control" />
                            </div>
                            <div class="my-3">
                                <label> Product Meta Description</label>
                                <input type="text" name="meta_description" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
jQuery(document).ready(function ($) {
    $(document).ready(function () {
        // Get all categories data as JSON
        var categoriesData = @json($categories);
                // When the parent category select field changes
                $('#parentCategory').on('change', function () {
            // Get the selected parent category ID
            var parentId = $(this).val();

            // Disable the subcategory select field until the options are updated
            $('#subCategory').prop('disabled', true);

            // Clear any previous options in the subcategory select field
            $('#subCategory').empty();

            // Make sure there is a valid parent category selected
            if (parentId !== "") {
                // Enable the subcategory select field
                $('#subCategory').prop('disabled', false);

                // Filter the categories that have the selected parent ID
                var subcategories = categoriesData.filter(function (category) {
                    return category.parent_id === parseInt(parentId);
                });

                // Add the new subcategory options to the select field
                $.each(subcategories, function (index, subcategory) {
                    $('#subCategory').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                });
            }
        });
    });
});
</script>
@endsection

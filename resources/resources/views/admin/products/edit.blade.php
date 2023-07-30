@extends ('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between py-3">
                    <h3 class="mb-0">Edit Products</h3>
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

                    <form action="{{ url('admin/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="tab-content">
                            <div class="tab-pane fade in active show" id="info-pills">
                                <div class="my-3 row">
                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-12">Product Name</label>
                                        <input id="name" type="text" name="name" value="{{ $product->name }}"
                                            class="form-control col-12" />
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label>Product Slug</label>
                                        <input id="slug" type="text" name="slug" value="{{ $product->slug }}"
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
                                </div>

                                <div class="my-3 row">
                                    <div class="col-sm-12 col-md-4">
                                        <label>Select Parent Category</label>
                                        <select name="category" class="form-control col-12" id="parentCategory">
                                            @foreach ($categories as $category)
                                                @if ($category->parent_id === null)
                                                    <option value="{{ $category->id }}" {{ $product->category == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    

                                    <div class="col-sm-12 col-md-4">
                                        <label>Product Type</label>
                                        <select name="type" class="form-control col-12" id="subCategory" disabled>
                                            <option value="">Select Product Type</option>
                                            @if ($product->category)
                                                @foreach ($categories as $category)
                                                    @if ($category->parent_id == $product->category)
                                                        <option value="{{ $category->id }}" {{ $product->type == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                </div>
                                <div class="my-3 row">
                                    <div class="my-3 col-sm-12 col-md-4">
                                        <label class="col-form-label">Product Featured image</label>
                                        <div class="">
                                            <div class="input-group">
                                                <div class="col-12 mb-3">
                                                    <input type="file" name="pf_image" class="form-control">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <img src="{{ asset($product->pf_image) }}" width="150px"
                                                        height="150px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3 col-sm-12 col-md-8">
                                        <div class="form-group">
                                            <label for="gallery_images">Product Gallery</label>
                                            <input type="file" name="image[]" class="form-control-file" multiple>
                                            <div class="my-3 gallery-view">
                                                @if ($product->productImages)
                                                    @foreach ($product->productImages as $image)
                                                        <div class="glimg">
                                                            <img src="{{ asset($image->image) }}" alt="Product Iamge"
                                                                style="width: 100px; height:100px; object-fit:cover" />
                                                            <a class="btn btn-danger"
                                                                href="{{ url('admin/product_image/' . $image->id . '/delete') }}">
                                                                Delet</a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    No image
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane fade in" id="variation-pills">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 my-3 ">
                                        <label> Product Description</label>
                                        <textarea rows="5" type="textarea" name="description" class="form-control summernote">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade in" id="price-pills">
                                <div class="my-3 row">
                                    <div class="col-sm-12 col-md-4">
                                        <label> Product Quantity</label>
                                        <input type="text" name="quantity" value="{{ $product->quantity }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label> Product Regular Price</label>
                                        <input type="text" name="orginal_price" value="{{ $product->orginal_price }}"
                                            class="form-control" />
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <label> Product Selling Price</label>
                                        <input type="text" name="selling_price" value="{{ $product->selling_price }}"
                                            class="form-control" />
                                    </div>

                                </div>

                            </div>

                            <div class="tab-pane fade in" id="seo-pills">
                                <div class="my-3">
                                    <label> Product Meta Title</label>
                                    <input type="text" name="meta_title" value="{{ $product->meta_title }}"
                                        class="form-control" />
                                </div>
                                <div class="my-3">
                                    <label> Product Meta Keyword</label>
                                    <input type="text" name="meta_keyword" value="{{ $product->meta_keyword }}"
                                        class="form-control" />
                                </div>
                                <div class="my-3">
                                    <label> Product Meta Description</label>
                                    <input type="text" name="meta_description"
                                        value="{{ $product->meta_description }}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
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

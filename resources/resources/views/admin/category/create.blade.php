@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between py-3">
                    <h3 class="mb-0">Add New Category</h3>
                    <a href="{{ url('admin/category/create') }}" class="btn btn-primary text-white float-end">Back</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-warning mb-3">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ url('admin/category') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="col-form-label">Category Name</label>
                                <div class="">
                                    <input type="text" name="name" class="form-control" onkeyup="generateSlug()"
                                        id="category-name">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="col-form-label">Category Slug</label>
                                <div class="">
                                    <input type="text" name="slug" value="" class="form-control" readonly
                                        id="category-slug">
                                    @error('slug')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="parent_category">Parent Category</label>
                                <select name="parent_id" id="parent_category" class="form-control">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($parentCategories as $parentCategory)
                                        <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label class="col-form-label">Category Image</label>
                                <div class="">
                                    <div class="input-group row">
                                        <div class="col-sm-12 col-md-12 my-2">
                                        <input type="file" name="cat_image"  class="form-control">   
                                        </div>                                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="col-form-label">Category Description</label>
                                <div class="">
                                    <textarea rows="5" name="description" class="form-control"> </textarea>
                                </div>
                            </div>  
                        </div>

                        <!-- Other form fields -->
                        <div class="row mb-3">
                            <div class="col-12 alert alert-danger">
                                <h3>SEO Section</h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Meta Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                        </div>
    
    
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Meta Keyword</label>
                            <div class="col-sm-10">
                                <input type="text" name="meta_keyword"  class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Meta Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="meta_description" class="form-control">
                            </div>
                        </div>
                        <!-- Other form fields -->
                        <div class="row mb-3">
                            <div class="col-12 ">
                                <button type="submit" class="btn btn-primary text-white float-end">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to auto-generate the slug based on the name -->
    <script>
        function generateSlug() {
            const categoryName = document.getElementById('category-name').value;
            const categorySlug = categoryName.toLowerCase().replace(/ /g, '-');
            document.getElementById('category-slug').value = categorySlug;
        }
    </script>

@endsection

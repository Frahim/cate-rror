@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between py-3">
                    <h3 class="mb-0">Category Tree</h3>
                    <a href="{{ url('admin/category/') }}" class="btn btn-primary text-white float-end">Back</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-warning mb-3">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-12">
                    @foreach ($parentCategories as $category)
                        {{ $category->name }}

                        @if (count($category->subcategory))
                        @foreach($subcategories as $subcategory)
                        <ul>
                           <li>{{$subcategory->name}}</li> 
                         @if(count($subcategory->subcategory))
                           @include('product.subCategoryList',['subcategories' => $subcategory->subcategory])
                         @endif
                        </ul> 
                       @endforeach
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    </div>



@endsection

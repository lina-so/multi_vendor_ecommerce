@if ($errors->any())
    <div class="alert alert-danger">
        <h4>Error Occured!</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

@if (session('customError'))
    <div class="alert alert-danger">
        <h4>Error Occurred!</h4>
        <p>{{ session('customError') }}</p>
    </div>
@endif


{{-- name --}}
<div class="form-group">
    <x-form.input name="name" value="{{ $product->name }}" type="text" label="Product Name" />
</div>

{{-- Main Category --}}
<div class="form-group">
    <label for="category_id">Main Category</label>
    <select name="category_id" id="category_id" class="form-control">
        <option value="">Select Main Category</option>
        @foreach ($categories as $mainCategory)
            <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
        @endforeach
    </select>
</div>

{{-- Subcategory --}}
<div class="form-group">
    <label for="parent_id">Subcategory </label>
    <select name="parent_id" id="subcategory_id" class="form-control">
        <!-- Options will be dynamically populated using JavaScript -->
    </select>
</div>


{{-- brand --}}
<div class="form-group">
    <label for="">brand</label>
    <select name="brand_id" id=""class="form-control form-select">
        <option value="" class="checked">choose</option>

        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
        @endforeach
    </select>
</div>


{{-- vendor --}}
<div class="form-group">
    <label for="">vendor</label>
    <select name="vendor_id" id="vendor_id"class="form-control form-select">
        <option value="" class="checked">choose</option>

        @foreach ($vendors as $vendor)
            <option value="{{ $vendor->id }}" @selected(old('vendor_id', $product->vendor_id) == $vendor->id)>{{ $vendor->name }}</option>
        @endforeach
    </select>
</div>


{{-- stores --}}
<div class="form-group">
    <label for="store_id">Stores </label>
    <select name="store_id" id="store_id" class="form-control">
        <!-- Options will be dynamically populated using JavaScript -->
    </select>
</div>

{{-- quantity --}}
<div class="form-group">
    <x-form.input name="quantity" value="{{ $product->quantity }}" type="number" label="Quantity" />
</div>


{{-- description --}}
<div class="form-group">
    <x-form.textarea name="description" cols="5" rows="5" :value="$product->description"
        label="description"></x-form.textarea>
</div>


{{-- image --}}
<div class="form-group">
    <x-form.label id="Image">product image</x-form.label>
    <x-form.input type="file" name="image[]" multiple />
</div>




{{-- price --}}
<div class="form-group">
    <x-form.input name="price" value="{{ $product->price }}" type="number" label="Price" />
</div>

{{-- compare price --}}
<div class="form-group">
    <x-form.input name="compare_price" value="{{ $product->compare_price }}" type="number"
        label="Compare Price (%)" />
</div>


{{-- status --}}
<div class="form-group">
    <label for="">product status</label>
    <div>
        <x-form.radio type="radio" name='status' :checked="$product->status" :options="[
            'active' => 'Active',
            'archived' => 'Archived',
            'draft' => 'Draft',
        ]" class="mr-5" />
    </div>
</div>

{{-- featured --}}
<div class="form-group">
    <label for="">featured</label>
    <div>
        <x-form.radio type="radio" name='featured' :checked="$product->featured" :options="['1' => 'true']" class="mr-5" />
    </div>
</div>

{{-- options --}}
<div class="form-group options-container">
    <label for="" class="form-label">Options</label>
    <div class="option">

    </div>
</div>

<button type="button" class="btn btn-success add-option-btn">Add Option</button>




<div class="form-group">
    @if ($product->exists)
        <button type="submit" class="mt-3 btn btn-primary">edit
            Product</button>
    @else
        <button type="submit" class="mt-3 btn btn-primary">Submit</button>
    @endif
</div>


@push('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- get sub categories -->
    <script>
        $(document).ready(function() {
            // When the main category dropdown changes
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    // Fetch subcategories based on the selected main category
                    $.ajax({
                        url: '/admin/dashboard/get-subcategories/' + categoryId,
                        type: 'GET',
                        success: function(data) {
                            // Clear existing options
                            $('#subcategory_id').empty();
                            // Add new options based on the response
                            $.each(data, function(id, name) {
                                $('#subcategory_id').append($('<option>', {
                                    value: id,
                                    text: name
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    // If no main category selected, clear subcategory options
                    $('#subcategory_id').empty();
                }
            });
        });
    </script>

       <!-- get stores for vendor -->
       <script>
        $(document).ready(function() {
            // When the main category dropdown changes
            $('#vendor_id').on('change', function() {
                var vendor_id = $(this).val();
                if (vendor_id) {
                    // Fetch subcategories based on the selected main category
                    $.ajax({
                        url: '/vendor/dashboard/get-stores/' + vendor_id,
                        type: 'GET',
                        success: function(data) {
                            // Clear existing options
                            $('#store_id').empty();
                            // Add new options based on the response
                            $.each(data, function(id, name) {
                                $('#store_id').append($('<option>', {
                                    value: id,
                                    text: name
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    // If no main category selected, clear subcategory options
                    $('#store_id').empty();
                }
            });
        });
    </script>


    {{-- add options & values --}}
    <script>
        $(document).ready(function() {
            var optionCounter = 0;

            $('.add-option-btn').click(function() {
                var optionTemplate = `
     <div class="option">
         <div class="mb-2">
             <select class="form-control" name="options[${optionCounter}][option_id]">
                 @foreach ($options as $option)
                 <option value="{{ $option->id }}">{{ $option->name }}</option>
                 @endforeach
             </select>
         </div>
         <div class="values-container" data-option="${optionCounter}" data-counter="0">
             <!-- ... Value inputs will be added here ... -->
         </div>
         <button type="button" class="btn btn-primary add-value-btn">Add Value</button>
         <button type="button" class="btn btn-danger remove-option-btn">Remove Option</button>
     </div>
 `;
                $('.options-container').append(optionTemplate);
                optionCounter++;
            });

            $(document).on('click', '.add-value-btn', function() {
                var valuesContainer = $(this).prev('.values-container');
                var optionIndex = valuesContainer.data('option');
                var counter = valuesContainer.data('counter');
                var valueTemplate = `
     <div class="value">
         <input type="text" name="options[${optionIndex}][values][${counter}][value]" class="form-control" placeholder="Value Name">
         <button type="button" class="btn btn-danger remove-value-btn">Remove Value</button>
     </div>
 `;
                valuesContainer.append(valueTemplate);
                valuesContainer.data('counter', counter + 1);
            });

            $(document).on('click', '.remove-option-btn', function() {
                $(this).closest('.option').remove();
            });

            $(document).on('click', '.remove-value-btn', function() {
                $(this).closest('.value').remove();
            });
        });
    </script>
@endpush

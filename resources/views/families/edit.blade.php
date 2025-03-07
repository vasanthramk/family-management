@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Family</h2>
    <form action="{{ route('families.update', $family->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$family->name) }}" >
                @error('name') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        
            <div class="col-md-6 mb-3">
                <label>Surname</label>
                <input type="text" name="surname" class="form-control" value="{{ old('surname',$family->surname) }}" >
                @error('surname') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Birthdate</label>
                <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $family->birthdate ? $family->birthdate->format('Y-m-d') : '') }}" >
                @error('birthdate') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        
            <div class="col-md-6 mb-3">
                <label>Mobile No</label>
                <input type="text" name="mobile_no" class="form-control" value="{{ old('mobile_no',$family->mobile_no) }}" >
                @error('mobile_no') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address',$family->address) }}</textarea>
                @error('address') <span class="text-danger">{{$message}}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>State</label>
                <select id="state" name="state" class="form-control">
                    <option value="">Select State</option>
                    @foreach($locations as $state)
                        <option value="{{ $state['state'] }}" {{ (old('state', $family->state) == $state['state']) ? 'selected' : '' }} >
                            {{ $state['state'] }}
                        </option>
                        
                    @endforeach
                </select>
            @error('state') <span class="text-danger">{{$message}}</span> @enderror   
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>City</label>
                
                <select id="city" name="city" class="form-control" >
                    <option value="">Select City</option>
                </select>
            @error('city') <span class="text-danger">{{$message}}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ old('pincode',$family->pincode) }}" >
                @error('pincode') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Marital Status</label>
                <select name="marital_status" class="form-control" onchange="toggleWeddingDate(this)">
                    <option value="Unmarried" {{ (old( 'marital_status' , $family->marital_status ) == 'Unmarried' ) ? 'selected' : '' }}>Unmarried</option>
                    <option value="Married" {{ (old( 'marital_status' , $family->marital_status ) == 'Married' ) ? 'selected' : '' }}>Married</option>
                </select>
                @error('marital_status') <span class="text-danger">{{$message}}</span> @enderror
            </div>

            <div class="col-md-6 mb-3" id="weddingDateField" style="{{ old('marital_status',$family->marital_status) == 'Married' ? 'display: block;' : 'display: none;' }}">
                <label>Wedding Date</label>
                <input type="date" name="wedding_date" class="form-control" value="{{ old('wedding_date', $family->wedding_date ? $family->wedding_date->format('Y-m-d') : '') }}">
                @error('wedding_date') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Hobbies</label>
                <div id="hobbyContainer">
                    @foreach($family->hobbies ?? [] as $hobby)
                        <input type="text" name="hobbies[]" class="form-control mb-2" value="{{ $hobby }}">
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-primary" onclick="addHobby()">Add Hobby</button>
            </div>

            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" class="form-control">
                @if($family->photo)
                    <img src="{{ asset(Storage::url( $family->photo)) }}" alt="Family Photo" width="100">
                @endif
                @error('photo') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<script>
function toggleWeddingDate(select) {
    document.getElementById('weddingDateField').style.display = select.value === 'Married' ? 'block' : 'none';
}

function addHobby() {
    let container = document.getElementById('hobbyContainer');
    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'hobbies[]';
    input.classList.add('form-control', 'mb-2');
    container.appendChild(input);
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let stateDropdown = document.getElementById("state");
    let cityDropdown = document.getElementById("city");

    let locations = @json($locations); // Convert PHP array to JavaScript
    let selectedState = "{{ old('state', $family->state) }}";
    let selectedCity = "{{ old('city', $family->city) }}";

    function populateCities(state, selectedCity = null) {
        cityDropdown.innerHTML = '<option value="">Select City</option>';
        let selectedStateObj = locations.find(item => item.state === state);
        if (selectedStateObj) {
            selectedStateObj.cities.forEach(city => {
                let isSelected = city === selectedCity ? "selected" : "";
                cityDropdown.innerHTML += `<option value="${city}" ${isSelected}>${city}</option>`;
            });
        }
    }

    // Populate cities when state is selected
    stateDropdown.addEventListener("change", function() {
        populateCities(this.value);
    });

    // Auto-populate cities if an old state value exists
    if (selectedState) {
        stateDropdown.value = selectedState;
        populateCities(selectedState, selectedCity);
    }
});
</script>

@endsection

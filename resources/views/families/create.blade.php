@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Family</h2>
    <form action="{{ route('families.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control">
                @error('name') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Surname</label>
                <input type="text" name="surname" value="{{old('surname')}}" class="form-control" >
                @error('surname') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
        <div class="col-md-6 mb-3">
            <label>Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}"  onchange="validateAge(this)">
            <small class="text-danger" id="ageError" style="display: none;">Must be at least 21 years old.</small>
            @error('birthdate') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>Mobile No</label>
            <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" class="form-control" >
            @error('mobile_no') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        </div>
        <div class="row">
        <div class="col-md-6 mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
            @error('address') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>State</label>
            <select id="state" name="state" class="form-control">
                    <option value="">Select State</option>
                    @foreach($locations as $state)
                        <option value="{{ $state['state'] }}" {{ old('state') == $state['state'] ? 'selected' : '' }} >
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
            <select id="city" name="city" class="form-control">
                    <option value="">Select City</option>
            </select>
            @error('city') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>Pincode</label>
            <input type="text" name="pincode" value="{{ old('pincode') }}" class="form-control" >
            @error('pincode') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        </div>
        <div class="row">
        <div class="col-md-6 mb-3">
            <label>Marital Status</label>
            <select name="marital_status" class="form-control" onchange="toggleWeddingDate(this)">
                <option value="Unmarried" {{ (old('marital_status') == 'unmarried') ? 'selected' : '' }} >Unmarried</option>
                <option value="Married" {{ (old('marital_status') == 'married') ? 'selected' : '' }} >Married</option>
            </select>
            @error('marital_status') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="col-md-6 mb-3" id="weddingDateField" style="display: {{ old('marital_status') == 'Married' ? 'block' : 'none' }};">
            <label>Wedding Date</label>
            <input type="date" name="wedding_date" value="{{ old('wedding_date') }}" class="form-control">
            @error('wedding_date') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        </div>
        <div class="row">
        <div class="col-md-6 mb-3">
            <label>Hobbies</label>
            <div id="hobbyContainer">
                <input type="text" name="hobbies[]" class="form-control mb-2">
            </div>
            <button type="button" class="btn btn-sm btn-primary" onclick="addHobby()">Add Hobby</button>
        </div>
        <div class="col-md-6 mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            @error('photo') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script>

function toggleWeddingDate(select) {
    document.getElementById('weddingDateField').style.display = select.value == 'Married' ? 'block' : 'none';
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
    let oldState = "{{ old('state') }}";
    let oldCity = "{{ old('city') }}";

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
    if (oldState) {
        stateDropdown.value = oldState;
        populateCities(oldState, oldCity);
    }
});
</script>

@endsection

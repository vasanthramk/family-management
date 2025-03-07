@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Family Member</h2>
    <form action="{{ route('family_members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-control">
                @error('name') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Birthdate</label>
                <input type="date" name="birthdate" value="{{ old('birthdate', $member->birthdate ? $member->birthdate->format('Y-m-d') : '') }}" class="form-control">
                
                @error('birthdate') <span class="text-danger">{{$message}}</span> @enderror
             </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Marital Status</label>
                    <select name="marital_status" class="form-control" id="maritalStatus">
                        <option value="unmarried" {{ (old('marital_status', $member->marital_status) == 'unmarried') ? 'selected' : '' }}>Unmarried</option>
                        <option value="married" {{ (old('marital_status', $member->marital_status) == 'married') ? 'selected' : '' }}>Married</option>
                    </select>
                    @error('marital_status') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="col-md-6 mb-3" id="weddingDateField" style="display: {{ old('marital_status', $member->marital_status) == 'unmarried' ? 'none' : 'block' }};">
                <label>Wedding Date</label>
                <input type="date" name="wedding_date" value="{{ old('wedding_date', $member->wedding_date ? $member->wedding_date->format('Y-m-d') : '') }}"  class="form-control">
                @error('wedding_date') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Education</label>
                <input type="text" name="education" value="{{ old('education', $member->education) }}" class="form-control">
                @error('education') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Photo</label>
                <input type="file" name="photo" value="{{ old('photo') }}" class="form-control">
                @error('photo') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<script>
    document.getElementById('maritalStatus').addEventListener('change', function() {
    document.getElementById('weddingDateField').style.display = (this.value === 'married') ? 'block' : 'none';
});
</script>
@endsection

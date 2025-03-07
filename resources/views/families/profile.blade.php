@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h3>Family Profile</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Family Head Details -->
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/'.$family->photo) }}" class="img-fluid rounded-circle" style="width: 150px; height: 150px;" alt="Family Head Photo">
                    <h4 class="mt-3">{{ $family->name }} {{ $family->surname }}</h4>
                    <p><strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($family->birthdate)->format('d/m/Y') }}</p>
                    <p><strong>Mobile:</strong> {{ $family->mobile_no }}</p>
                    <p><strong>Address:</strong> {{ $family->address }}, {{ $family->city }}, {{ $family->state }} - {{ $family->pincode }}</p>
                    <p><strong>Marital Status:</strong> {{ $family->marital_status }}</p>
                    @if($family->marital_status == "Married")
                        <p><strong>Wedding Date:</strong> {{ \Carbon\Carbon::parse($family->wedding_date)->format('d/m/Y') }}</p>
                    @endif
                    <p><strong>Hobbies:</strong> {{ implode(', ', $family->hobbies ?? []) }}</p>
                </div>

                <!-- Family Members -->
                <div class="col-md-8">
                    <h4>Family Members</h4>
                    

                    
                    @if(Optional($familyMembers)->count() > 0)
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Birthdate</th>
                                <th>Marital Status</th>
                                <th>Married Date</th>
                                <th>Education</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($family->marital_status == "Married")
                            @foreach($familyMembers as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($member->birthdate)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($member->marital_status) }}</td>
                                <td>{{ is_null($member->wedding_date) ? '- - - - - -' : \Carbon\Carbon::parse($member->wedding_date)->format('d/m/Y') }}</td>
                                
                                <td>{{ $member->education }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$member->photo) }}" class="img-thumbnail" style="width: 100px; height: 75px;" alt="Member Photo">
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    @else
                    <p>No family members added.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('families.index') }}" class="btn btn-primary mt-3">Back to List</a>
</div>
@endsection

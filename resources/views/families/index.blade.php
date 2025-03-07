@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Families List</h2>
    <a href="{{ route('families.create') }}" class="btn btn-primary mb-3">Add Family</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile No</th>
                <th>Address</th>
                <th>Marital Status</th>
                <th>Wedding Date</th>
                <th>Famiy Members</th>
                <th>Profile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @if($families && $families->count() > 0)
            @foreach($families as $family)
            <tr>
                <td>{{ $family->name }} {{ $family->surname }}</td>
                <td>{{ $family->mobile_no }}</td>
                <td>{{ $family->address }}, {{ $family->city }}, {{ $family->state }}-{{ $family->pincode }}</td>
                <td>{{ $family->marital_status }}</td>
                <td>{{ \Carbon\Carbon::parse($family->wedding_date)->format('d/m/Y') }}</td>
                <td>
                
                    <a href="{{ route('families.show', $family->id) }}" class="btn btn-info {{ is_null($family->familyMembers) ? 'disabled' : '' }}"  >
                        @if (!is_null($family->familyMembers)) {{ Optional($family->familyMembers)->count() }}   @else 0 @endif
                    </a>
                    <a href="{{ route('family_members.show', $family->id) }}" class="btn btn-info"  >
                        {{ Optional($family->familyMembers)->count() }}
                        @php
                            $memberCount = DB::table('family_members')->where('family_id', $family->id)->count();
                        @endphp
                        {{ $memberCount }}
                    </a>
                </td>
                <td>
                <a href="{{ route('families.profile', $family->id) }}" class="btn btn-info">Profile</a>
            </td>
                <td>
                    <a href="{{ route('families.edit', $family->id) }}" class="btn btn-warning {{ is_null($family->familyMembers) ? '' : '' }}">Edit</a>
                    <form action="{{ route('families.destroy', $family->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <tr> <td colspan='8'; align='center'>No Family Added</td></tr>
        @endif
        </tbody>
    </table>
</div>
@endsection

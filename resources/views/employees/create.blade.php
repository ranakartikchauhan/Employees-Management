@extends('layouts.app')
@section('content')
    <div class="py-12">
        <h2>Create Employee</h2>
        <x-success-status class="mb-4" :status="session('message')" />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('employees.store') }}">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    {{-- Gender --}}
                    <div class="mt-4">
                        <x-input-label for="gender" :value="__('Gender')" />
                        <select class="form-control" name="gender" :value="old('gender')" id="gender">
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                    {{-- Active status  --}}
                    <p>User Status:</p>
                    <input type="checkbox" id="status" name="status" value="1">
                    <label for="status"> Is this user is active</label><br>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    <!-- Phone  -->
                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('Phone No')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                            :value="old('phone')" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    {{-- Hobbies --}}
                    <p>Please Select your hobbies</p>
                    <div>
                        <input type="checkbox" name="hobbies[]" value="Dancing">
                        <label for="dancing"> Dancing</label><br>
                        <input type="checkbox" name="hobbies[]" value="Playing">
                        <label for="playing"> Playing</label><br>
                        <input type="checkbox" name="hobbies[]" value="Studying">
                        <label for="studying">Studying</label>
                        <x-input-error :messages="$errors->get('hobbies')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button  name='add' class="ml-4">
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
@endsection

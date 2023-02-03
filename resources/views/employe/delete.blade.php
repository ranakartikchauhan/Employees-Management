@extends('layouts.app')
@section('content')

    <div class="py-12">
        <x-success-status class="mb-4" :status="session('message')"/>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ url('delete-employe/'.$employe->id) }}">
                    @csrf
                    @method('DELETE')
            
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$employe->name" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
            
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$employe->email" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>  
            
                    <div class="flex items-center$employe->id justify-end mt-4">
                       
                        <x-primary-button type="button" onclick="Swal.fire({
                            title: 'Are you sure?',
                            text: 'You wont be able to revert this!',
                            icon: 'warning',
                            allowOutsideClick: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                          }).then((result) => {
                            if (result.isConfirmed) {
                              form.submit();
                              Swal.fire(
                                
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              )
                            }
                          })" class="ml-4">
                            {{ __('Delete') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
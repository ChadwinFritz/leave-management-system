<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oh snap!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Login Form -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold">Leave System Admin Portal</h2>
                <p class="text-gray-600">Please login</p>
            </div>
            <form action="{{ route('admin.login') }}" method="post">
                @csrf
                <div class="mb-4">
                    <input type="text" name="username" class="form-control w-full border border-gray-300 rounded-lg p-2" placeholder="Username" required/>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" class="form-control w-full border border-gray-300 rounded-lg p-2" placeholder="Password" required/>
                </div>
                <div class="flex justify-between mb-4">
                    <div>
                        <a href="{{ route('admin.login') }}" class="text-blue-500 hover:underline">Login as an Admin</a>
                    </div>
                    <div>
                        <button type="submit" class="bg-gray-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Log In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

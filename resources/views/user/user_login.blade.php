<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold">Leave Register System</h2>
                <p class="text-gray-600">Employee</p>
            </div>

            <div class="text-center mb-4">
                <h3 class="text-xl font-bold">Log In to Your Account</h3>
            </div>

            <!-- Error container -->
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oh snap!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('user.login') }}" method="post">
                @csrf
                <div class="mb-4">
                    <input type="email" id="email" class="form-control w-full border border-gray-300 rounded-lg p-2" name="email" placeholder="Your email" value="{{ old('email') }}" required />
                </div>
                <div class="mb-4">
                    <input type="password" id="password" class="form-control w-full border border-gray-300 rounded-lg p-2" name="password" placeholder="Password" required />
                </div>
                <div class="flex justify-between mb-4">
                    <div>
                        <a href="#" class="text-blue-500 hover:underline">Forgot Password?</a>
                    </div>
                    <div>
                        <button type="submit" class="bg-gray-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Log In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PetShopCMS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite('resources/js/app.js')
    </head>
    <body>
        <div class="container w-full flex-col justify-center items-center">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($ApiError))
                <li style="color:red">
                    Error occurred while trying to process your request. Check logs for more details.
                </li>
            @endif

            <form action="{{route("pets.index")}}" class="w-auto bg-gray-100 flex-col justify-center items-center p-10">
                <label for="status">List pets by status</label><br>
                <select id="status" name="status" class="w-1/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="available" selected>available</option>
                    <option value="pending">pending</option>
                    <option value="sold">sold</option>
                </select><br>
                <input type="submit" value="Get Pets" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </form>
            @if(isset($pet))
                @dd($pet)
            @endif
            <form action="{{route("pets.store")}}" method="POST" class="w-auto bg-gray-100 flex-col justify-center items-center p-10">
                <p class="text-lg">Create pet</p>
                @csrf
                @method('POST')
                <label for="name">Name</label><br>
                <input id="name" name="name" type="text"><br>
                <label for="category">Category</label><br>
                <input id="category" name="category" type="text"><br>
                <label for="status">Status</label><br>
                <label for="photoUrls">Photo URLs (separated by commas)</label><br>
                <input id="photoUrls" name="photoUrls" type="text"><br>
                <label for="tags">Tags (separated by commas)</label><br>
                <input id="tags" name="tags" type="text"><br>
                <select id="status" name="status" class="w-1/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="available">available</option>
                    <option value="pending">pending</option>
                    <option value="sold">sold</option>
                </select><br>

                <input type="submit" value="Create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </form>
            <form action="{{route("pets.update")}}" method="POST" class="w-auto bg-gray-100 flex-col justify-center items-center p-10">
                <p class="text-lg">Update pet</p>
                @csrf
                @method('PUT')
                <label for="id">Id</label><br>
                <input id="id" name="id" type="number"><br>
                <label for="name">Name</label><br>
                <input id="name" name="name" type="text"><br>
                <label for="category">Category</label><br>
                <input id="category" name="category" type="text"><br>
                <label for="photoUrls">Photo URLs (separated by commas)</label><br>
                <input id="photoUrls" name="photoUrls" type="text"><br>
                <label for="tags">Tags (separated by commas)</label><br>
                <input id="tags" name="tags" type="text"><br>
                <label for="status">Status</label><br>
                <select id="status" name="status" class="w-1/4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="available">available</option>
                    <option value="pending">pending</option>
                    <option value="sold">sold</option>
                </select><br>

                <input type="submit" value="Update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-5">
            </form>
            @if(isset($pets) && count($pets) > 0)
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Id</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Category</th>
                            <th class="px-6 py-3">Photo</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tags</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-100">
                        @foreach($pets as $pet)
                            <tr>
                                <td class="px-6 py-4">{{$pet->id}}</td>
                                <td class="px-6 py-4">{{$pet->name}}</td>
                                <td class="px-6 py-4">{{isset($pet->category) ? $pet->category->name : null}}</td>
                                <td class="px-6 py-4"><img style="width:50px; height:50px;" src="{{$pet->photoUrls[0] ?? null}}" alt="{{$pet->name}}"></td>
                                <td class="px-6 py-4">{{$pet->status}}</td>
                                <td class="px-6 py-4">
                                    @foreach($pet->tags as $tag)
                                        {{$tag->name}},
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{route("pets.destroy", $pet->id)}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <input type="submit" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-5">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </body>
    <script>
        addEventListener("submit", prepareFormData);
        function prepareFormData(event) {
            event.preventDefault();

            const photoUrlsInput = document.getElementById('photoUrls');
            const tagsInput = document.getElementById('tags');

            const photoUrlsArray = photoUrlsInput.value.split(',');
            const tagsArray = tagsInput.value.split(',');

            photoUrlsInput.value = JSON.stringify(photoUrlsArray);
            tagsInput.value = JSON.stringify(tagsArray);

            event.target.submit();
        }
    </script>
</html>

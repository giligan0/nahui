<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Places') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">{{ __('Places') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all the {{ __('Places') }}.</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a type="button" href="{{ route('places.create') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add new</a>
                        </div>
                    </div>

                    <div class="flow-root">
                        <div class="mt-8 overflow-x-auto">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">No</th>
                                        
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Name</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Place Category Id</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Description</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Address Id</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Is Public</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Is Managed</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Managing Org Id</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Hours</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Accessibility Notes</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Entrance Fee</th>
									<th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Currency</th>

                                        <th scope="col" class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($places as $place)
                                        <tr class="even:bg-gray-50">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900">{{ ++$i }}</td>
                                            
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->name }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->place_category_id }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->description }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->address_id }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->is_public }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->is_managed }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->managing_org_id }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->hours }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->accessibility_notes }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->entrance_fee }}</td>
										<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $place->currency }}</td>

                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                <form action="{{ route('places.destroy', $place->id) }}" method="POST">
                                                    <a href="{{ route('places.show', $place->id) }}" class="text-gray-600 font-bold hover:text-gray-900 mr-2">{{ __('Show') }}</a>
                                                    <a href="{{ route('places.edit', $place->id) }}" class="text-indigo-600 font-bold hover:text-indigo-900  mr-2">{{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('places.destroy', $place->id) }}" class="text-red-600 font-bold hover:text-red-900" onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">{{ __('Delete') }}</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 px-4">
                                    {!! $places->withQueryString()->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
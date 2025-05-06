<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Membuat Laporan PDF Dengan DOMPDF Laravel</h4>
	</center>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-sm text-gray-700 uppercase bg-white dark:bg-gray-800 ">
            <tr
                class="bg-white border-t border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="col" class="px-6 py-3 text-center">
                    <span>Facility Name</span>
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    <span>Category</span>
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    <span>Capacity</span>
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    <span>Location</span>
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    <span>Rates</span>
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    <span>Action</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $facility)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-2 text-center">
                        {{ $facility->name }}
                    </td>
                    <td class="px-6 py-2 text-center">
                        {{ $facility->category->name ?? '-' }}
                    </td>
                    <td class="px-6 py-2 text-center">
                        {{ $facility->capacity }}
                    </td>
                    <td class="px-6 py-2 text-center">
                        {{ $facility->location }}
                    </td>
                    <td class="px-6 py-2 text-center">
                        <div class="flex flex-col">
                            <span>Hourly: Rp {{ number_format($facility->hourly_rate, 0, ',', '.') }}</span>
                            <span>Daily: Rp {{ number_format($facility->daily_rate, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-2 text-center">
                        <form onsubmit="return confirm('Are you sure?');"
                            action="{{ route('facilities.destroy', $facility->id) }}" method="POST">
                            <a href="{{ route('facilities.edit', $facility->id) }}"
                                class="focus:outline-none text-gray-50 bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">EDIT</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                DELETE</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center">
                        <div class="bg-gray-500 text-white p-3 rounded shadow-sm">
                            No Facilities Available!
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
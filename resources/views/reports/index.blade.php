<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rental Transactions') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-sm">
                <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between py-5 mb-5">
                        <div class="md:mt-0 sm:flex-none w-72">
                            <form action="{{ route('reports') }}" method="GET"
                                class="flex item-center gap-2 justify-between">
                                <input type="date" name="startDate"
                                    class="w-auto relative flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300" />
                                <input type="date" name="endDate"
                                    class="w-auto relative flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300" />
                                <select id="kasir_id" name="kasir_id"
                                    class="w-40 relative flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <div class="sm:ml-16 sm:mt-0 sm:flex-none just">
                                    <button type="submit"
                                        class="relative inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                       Process
                                    </button>
                                    <a type="button" href="{{ route('reports.xls', ['startDate' => request()->startDate , 'endDate' => request()->endDate , 'kasir_id' => request()->kasir_id]) }}"
                                        class="relative inline-flex items-center px-4 py-2 font-medium text-green-700 bg-white border border-green-300 leading-5 rounded-md hover:text-green-500 focus:outline-none focus:ring ring-green-300 focus:border-blue-300 active:bg-green-100 active:text-green-700 transition ease-in-out duration-150 dark:bg-green-800 dark:border-green-600 dark:text-green-300 dark:focus:border-blue-700 dark:active:bg-green-700 dark:active:text-green-300">
                                        Export Excel
                                    </a>
                                    <a type="button" href="{{ route('reports.pdf', ['startDate' => request()->startDate , 'endDate' => request()->endDate , 'kasir_id' => request()->kasir_id]) }}"
                                        class="relative inline-flex items-center px-4 py-2 font-medium text-red-700 bg-white border border-red-300 leading-5 rounded-md hover:text-red-500 focus:outline-none focus:ring ring-red-300 focus:border-blue-300 active:bg-red-100 active:text-red-700 transition ease-in-out duration-150 dark:bg-red-800 dark:border-red-600 dark:text-red-300 dark:focus:border-blue-700 dark:active:bg-red-700 dark:active:text-red-300">
                                        Export PDF
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-sm text-gray-700 uppercase bg-white dark:bg-gray-800 ">
                                <tr
                                    class="bg-white border-t border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <span>Customer Name</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <span>Phone</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <span>Total Cost</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <span>Payment Status</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    
                                    <td class="px-6 py-2 text-center">
                                        {{ $transaction->name }}
                                    </td>
                                    <td class="px-6 py-2 text-center">
                                        {{ $transaction->phone }}
                                    </td>
                                    <td class="px-6 py-2 text-center">
                                        {{ number_format($transaction->total_biaya, 2) }}
                                    </td>
                                    <td class="px-6 py-2 text-center">
                                        @php
                                        $statusColors = [
                                        'PENDING' => 'bg-yellow-100 text-yellow-800',
                                        'PAID' => 'bg-green-100 text-green-800',
                                        'CANCELLED' => 'bg-red-100 text-red-800'
                                        ];
                                        @endphp
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$transaction->status_pembayaran] }}">
                                            {{ $transaction->status_pembayaran }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">
                                        <div class="bg-gray-500 text-white p-3 rounded shadow-sm mb-3">
                                            No rental transactions available!
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
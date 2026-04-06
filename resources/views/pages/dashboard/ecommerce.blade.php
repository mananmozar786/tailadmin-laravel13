@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
      <div class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-6">
        <h3 class="text-xl font-semibold text-black dark:text-gray mb-4">
          Welcome to Dashboard
        </h3>
        <p class="text-gray-600 dark:text-gray-400">
          This is your minimal dashboard. You can add your content here.
        </p>
      </div>
    </div>
  </div>
@endsection

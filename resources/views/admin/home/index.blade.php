@extends('../admin/layouts/main')

@section('adminHead')
    <title>Home - Pattern Laravel 9</title>
@endsection

@section('adminContent')
<div class="grid grid-cols-12">
  <div class="col-span-12 mt-8">
    <div class="box p-5 text-center">
      <p class="text-3xl font-bold text-gray-600">
        Seja bem-vindo {{ auth()->guard('admin')->user()->name}}!
      </p>
      <p class="text-sm text-gray-400">
        Área exclusiva para administradores
      </p>
    </div>
  </div>
</div>
@endsection

@section('adminJs')
@endsection

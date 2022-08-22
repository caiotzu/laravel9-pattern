@extends('../admin/layouts/main')

@section('adminHead')
    <title>Home - Pattern Laravel 9</title>
@endsection

@section('adminContent')
@if($errors->any())
  <div id="errorMessage" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-4 relative" role="alert">
    <p class="font-bold text-lg mb-2 relative">Erro</p>
    <p>{!! implode('<br>', $errors->all('<span class="text-lg">&raquo;</span> :message')) !!}</p>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
      <a onClick="(function(){document.getElementById('errorMessage').remove();return false;})();return false;">
        <i data-lucide="x" role="button"></i>
      </a>
    </span>
  </div>
@endif

@if(isset($successMessage))
<div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4 relative" role="alert">
  <p class="font-bold text-lg mb-2 relative">Sucesso</p>
  <p>
    @if(is_array($successMessage))
      @foreach($successMessage as $message)
        <span class="text-lg">&raquo;</span> {!!$message!!}<br/>
      @endforeach
    @else
      <span class="text-lg">&raquo;</span> {!!$successMessage!!}
    @endif
  </p>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <a onClick="(function(){document.getElementById('successMessage').remove();return false;})();return false;">
      <i data-lucide="x" role="button"></i>
    </a>
  </span>
</div>
@endif

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

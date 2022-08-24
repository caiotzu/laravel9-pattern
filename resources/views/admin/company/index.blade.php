@extends('../admin/layouts/main')

@section('adminHead')
    <title>Company - Pattern Laravel 9</title>
@endsection

@section('adminBreadcrumb')
  <li class="breadcrumb-item active">
    <a href="{{ route('admin.home.index') }}">Home</a>
  </li>
  <li class="breadcrumb-item" aria-current="page">
    <a href="{{ route('admin.companies.index') }}">Empresas</a>
  </li>
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

@if(session('successMessage'))
  <div id="successMessage" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-4 relative" role="alert">
    <p class="font-bold text-lg mb-2 relative">Sucesso</p>
    <p>
      @if(is_array(session('successMessage')))
        @foreach(session('successMessage') as $message)
          <span class="text-lg">&raquo;</span> {!! $message !!}<br/>
        @endforeach
      @else
        <span class="text-lg">&raquo;</span> {!! session('successMessage') !!}
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
    <div class="box p-5">
      <div class="flex justify-between p-1 border-b border-slate-200/60 dark:border-darkmode-400">
        <p class="text-2xl font-bold text-gray-600">
          Listagem de empresas
        </p>

        @if(in_array('COMPANY_CREATE',Session::get('userPermission')))
          <a href="{{ route('admin.companies.create') }}" class="btn btn-primary w-32 mr-2 mb-2 ">
            Adicionar
          </a>
        @endif
      </div>
      <div class="overflow-x-auto overflow-y-hidden">
        <table class="table">
          <thead>
            <tr>
              <th class="whitespace-nowrap">Nome fantasia</th>
              <th class="whitespace-nowrap">CNPJ</th>
              <th class="whitespace-nowrap">Tipo</th>
              <th class="whitespace-nowrap">Perfil</th>
              <th class="whitespace-nowrap">Status</th>
              <th class="whitespace-nowrap text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($companies as $company)
              <tr>
                <td>{{ $company->trade_name }}</td>
                <td>{{ $company->cnpj }}</td>
                <td>
                  @if(!$company->headquarter_id)
                    <span class="bg-gray-200 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-200 dark:text-gray-900">Matriz</span>
                  @else
                    <span class="bg-amber-200 text-amber-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-amber-200 dark:text-amber-900">Filial</span>
                  @endif
                </td>
                <td>
                  @if($company->companyGroup->profile->description == 'REVENDA')
                    <span class="bg-indigo-200 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900">Revenda</span>
                  @elseif($company->companyGroup->profile->description == 'ITE')
                    <span class="bg-cyan-200 text-cyan-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-cyan-200 dark:text-cyan-900">Ite</span>
                  @else
                    <span class="bg-purple-200 text-purple-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-purple-200 dark:text-purple-900">Montadora</span>
                  @endif
                </td>
                <td>
                  @if($company->active)
                    <span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>
                  @else
                    <span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>
                  @endif
                </td>
                <td>
                  <div class="text-center">
                    <div class="dropdown inline-block" data-tw-placement="bottom-start">
                      <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                        Ações <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                      </button>
                      <div class="dropdown-menu w-48">
                        <ul class="dropdown-content">
                          @if(in_array('COMPANY_EDIT',Session::get('userPermission')))
                            <li>
                              <a href="{{route('admin.companies.edit', $company->id)}}" class="dropdown-item">
                                <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Editar
                              </a>
                            </li>
                          @endif
                          <li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
        {{ $companies->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

@section('adminJs')
@endsection

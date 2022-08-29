@csrf

<div class="p-2 col-span-12">
  <div class="preview">
    <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap" role="tablist">
      <li id="company" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2 active"
          data-tw-toggle="pill"
          data-tw-target="#tab-company"
          type="button"
          role="tab"
          aria-controls="tab-company"
          aria-selected="true"
        >
          Empresa
        </button>
      </li>
      <li id="contacts" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2"
          data-tw-toggle="pill"
          data-tw-target="#tab-contacts"
          type="button" role="tab"
          aria-controls="tab-contacts"
          aria-selected="false"
        >
          Contatos
        </button>
      </li>
      <li id="addresses" class="nav-item flex-1 border-b border-slate-200/60 dark:border-darkmode-400 md:border-none" role="presentation">
        <button
          class="nav-link w-full py-2"
          data-tw-toggle="pill"
          data-tw-target="#tab-addresses"
          type="button" role="tab"
          aria-controls="tab-addresses"
          aria-selected="false"
        >
          Endereços
        </button>
      </li>
    </ul>
    <div class="tab-content border-l border-r border-b">
      <div id="tab-company" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="company">

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 md:gap-8 p-2">
            <label for="company_group_id" class="form-label">Grupo empresa</label>
            <select class="tom-select w-full" id="company_group_id" name="company_group_id">
              @if(isset($data['company_group_id']) && $data['company_group_id'] == '')
                <option value="" selected>Selecione o grupo</option>
              @else
                <option value="">Selecione o grupo</option>
              @endif

              @foreach($companyGroups as $companyGroup)
              @if(!!old())
                @if(old('id') == $companyGroup->id)
                  <option value="{{ $companyGroup->id }}" selected>{{ $companyGroup->group_name }}</option>
                @else
                  <option value="{{ $companyGroup->id }}">{{ $companyGroup->group_name }}</option>
                @endif
              @elseif(isset($data['company_group_id']) && $data['company_group_id'] == $companyGroup->id)
                  <option value="{{ $companyGroup->id }}" selected>{{ $companyGroup->group_name }}</option>
                @else
                  <option value="{{ $companyGroup->id }}" >{{ $companyGroup->group_name }}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="description" class="form-label">CNPJ<span class="text-red-500">*</span></label>
            <input id="description" name="description" type="text" class="form-control w-full py-2.5 cnpj" value="{{ old('description', $company->cnpj ?? '') }}">
          </div>
        </div>
      </div>
      <div id="tab-contacts" class="tab-pane leading-relaxed p-5 grid grid-cols-12" role="tabpanel" aria-labelledby="contacts">
        Contatos
      </div>
      <div id="tab-addresses" class="tab-pane leading-relaxed p-5 grid grid-cols-12" role="tabpanel" aria-labelledby="addresses">
        Endereços
      </div>
    </div>
  </div>
</div>

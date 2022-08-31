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
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="company_group_id" class="form-label">Grupo empresa <span class="text-red-500">*</span></label>
            <select class="tom-select w-full" id="company_group_id" name="company_group_id">
              @if(isset($company) && $company->company_group_id == '')
                <option value="" selected>Selecione o grupo</option>
              @else
                <option value="">Selecione o grupo</option>
              @endif

              @foreach($companyGroups as $cp)
                @if(!!old())
                  @if(old('company_group_id') == $cp->id)
                    <option value="{{ $cp->id }}" selected>{{ $cp->group_name }}</option>
                  @else
                    <option value="{{ $cp->id }}">{{ $cp->group_name }}</option>
                  @endif
                @elseif(isset($company) && $company->company_group_id == $cp->id)
                  <option value="{{ $cp->id }}" selected>{{ $cp->group_name }}</option>
                @else
                  <option value="{{ $cp->id }}" >{{ $cp->group_name }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="company_type" class="form-label">Tipo empresa <span class="text-red-500">*</span></label>
            <select class="form-select py-2.5" id="company_type" name="company_type">
              @if(!!old())
                <option value="matriz" @if(old('company_type') == 'matriz') selected @endif>Matriz</option>
                <option value="filial" @if(old('company_type') == 'filial') selected @endif>Filial</option>
              @elseif(isset($company))
                <option value="matriz" @if($company->headquarter_id == null) selected @endif>Matriz</option>
                <option value="filial" @if($company->headquarter_id != null) selected @endif>Filial</option>
              @else
                <option value="matriz" selected>Matriz</option>
                <option value="filial">Filial</option>
              @endif
            </select>
          </div>

          <div class="col-span-12 md:col-span-4 p-2
            @if(!!old())
              @if(old('company_type') == 'matriz')
                hidden
              @endif
            @elseif(isset($company))
              @if($company->headquarter_id == null)
                hidden
              @endif
            @else
              hidden
            @endif
            "
            id="divFilial"
          >
            <label for="headquarter_id" class="form-label">Filial da empresa <span class="text-red-500">*</span></label>
            <select class="tom-select w-full" id="headquarter_id" name="headquarter_id">
              @if(isset($data['headquarter_id']) && $data['headquarter_id'] == '')
                <option value="" selected>Selecione a matriz</option>
              @else
                <option value="">Selecione a matriz</option>
              @endif

              @foreach($companies as $c)
                @if(!!old())
                  @if(old('headquarter_id') == $c->id)
                    <option value="{{ $c->id }}" selected>{{ $c->trade_name }}</option>
                  @else
                    <option value="{{ $c->id }}">{{ $c->trade_name }}</option>
                  @endif
                @elseif(isset($company) && $company->headquarter_id == $c->id)
                  <option value="{{ $c->id }}" selected>{{ $c->trade_name }}</option>
                @else
                  <option value="{{ $c->id }}" >{{ $c->trade_name }}</option>
                @endif
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="cnpj" class="form-label">CNPJ <span class="text-red-500">*</span></label>
            <input id="cnpj" name="cnpj" type="text" class="form-control w-full py-2.5 cnpj" value="{{ old('cnpj', $company->cnpj ?? '') }}">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="trade_name" class="form-label">Nome fantasia <span class="text-red-500">*</span></label>
            <input id="trade_name" name="trade_name" type="text" class="form-control w-full py-2.5" value="{{ old('trade_name', $company->trade_name ?? '') }}" maxlength="60">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="company_name" class="form-label">Razão social <span class="text-red-500">*</span></label>
            <input id="company_name" name="company_name" type="text" class="form-control w-full py-2.5" value="{{ old('company_name', $company->company_name ?? '') }}" maxlength="60">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-12 md:col-span-4 p-2">
            <label for="state_registration" class="form-label">Inscrição estadual <span class="text-red-500">*</span></label>
            <input id="state_registration" name="state_registration" type="text" class="form-control w-full py-2.5" value="{{ old('state_registration', $company->state_registration ?? '') }}" maxlength="9">
          </div>

          <div class="col-span-12 md:col-span-4 p-2">
            <label for="municipal_registration" class="form-label">Inscrição municipal <span class="text-red-500">*</span></label>
            <input id="municipal_registration" name="municipal_registration" type="text" class="form-control w-full py-2.5" value="{{ old('municipal_registration', $company->municipal_registration ?? '') }}" maxlength="11">
          </div>
        </div>

        <div class="grid grid-cols-12">
          <div class="col-span-4 p-2">
            <div class="form-check mt-2">
              <input id="active" name="active" class="form-check-input" type="checkbox"
                @if(!!old())
                  @if(old('active') == 'on') checked @endif
                @elseif(isset($company))
                  @if($company->active) checked @endif
                @else
                  checked
                @endif
              >
              <label class="form-check-label" for="active">Ativa</label>
            </div>
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

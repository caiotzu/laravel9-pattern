$(function($) {

  $('select[name=company_type]').on('change', function(e) {
    e.preventDefault();
    const companyType = $('select[name=company_type] option:selected').val();

    if(companyType == 'filial')
      $('#divFilial').fadeIn();
    else
      $('#divFilial').fadeOut();
  });

  $('select[name=contact_type]').on('change', function(e) {
    e.preventDefault();
    const contactType = $('select[name=contact_type] option:selected').val();

    $(':input[name=contact_value]').val('');

    if(contactType == 'E')
      $(':input[name=contact_value]').unmask();
    else
      $(':input[name=contact_value]').mask(spMaskBehavior, spOptions);
  });

  $('a[name=btnAddContact]').on('click', function(e) {
    e.preventDefault();

    const contactType = $('select[name=contact_type] option:selected').val(),
          contactValue = $(':input[name=contact_value]').val(),
          elmMessage = $('#divMessage');

    let arrData = {},
      itens = JSON.parse($(':input[name=arrContact]').val()),
      tableContact = $('#tableContact').find('tbody'),
      main = true;

    if(!contactValue) {
      showMessageBox('Obrigatório informar o contato', 'D', elmMessage, 'after');
      return false;
    }

    $('#errorMessage').remove();

    for(let item of itens) {
      if(item.type == contactType && item.main) {
        main = false;
        break;
      }
    }

    arrData['type'] = contactType;
    arrData['value'] = contactValue;
    arrData['main'] = main;
    arrData['active'] = true;
    arrData['insert'] = 'S';

    itens.push(arrData);
    $(':input[name=arrContact]').val(JSON.stringify(itens));

    tableContact.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableContact.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="${itens[i].type}_contact"
                      value="${itens[i].value}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td data-title="Contato">${itens[i].value}</td>
              <td data-title="Principal">${itens[i].type == 'E' ? 'E-mail' : 'Telefone'}</td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteContact" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditContact" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveContact" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }

    $(':input[name=contact_value]').val('');
    $('select[name=contact_type]').val('E').trigger('change');
  });

  $(document).on('click', 'a[name=btnEditContact]', function(e){
    e.preventDefault();

    const controlId = $(this).attr('data-id');
    let itens = JSON.parse($(':input[name=arrContact]').val());

    $('select[name=contact_type]').val(itens[controlId].type).trigger('change');
    $(':input[name=contact_value]').val(itens[controlId].value);

    $('a[name=btnSaveEditContact]').attr('data-id', controlId);
    $('a[name=btnSaveEditContact]').removeClass('hidden');
    $('a[name=btnCancelEditContact]').removeClass('hidden');
    $('a[name=btnAddContact]').addClass('hidden');
  });

  $('a[name=btnCancelEditContact]').on('click', function(e) {
    e.preventDefault();

    $('a[name=btnSaveEditContact]').attr('data-id', '');
    $('a[name=btnSaveEditContact]').addClass('hidden');
    $('a[name=btnCancelEditContact]').addClass('hidden');
    $('a[name=btnAddContact]').removeClass('hidden');

    $('select[name=contact_type]').val('E').trigger('change');
    $(':input[name=contact_value]').val('');
  });

  $('a[name=btnSaveEditContact]').on('click', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          contactType = $('select[name=contact_type] option:selected').val(),
          contactValue = $(':input[name=contact_value]').val(),
          elmMessage = $('#divMessage');

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    if(!contactValue) {
      showMessageBox('Obrigatório informar o contato', 'D', elmMessage, 'after');
      return false;
    }

    $('#errorMessage').remove();

    itens[controlId]['type'] = contactType;
    itens[controlId]['value'] = contactValue;
    itens[controlId]['insert'] = 'S';

    $(':input[name=arrContact]').val(JSON.stringify(itens));

    tableContact.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableContact.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="${itens[i].type}_contact"
                      value="${itens[i].value}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td data-title="Contato">${itens[i].value}</td>
              <td data-title="Principal">${itens[i].type == 'E' ? 'E-mail' : 'Telefone'}</td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteContact" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditContact" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveContact" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }
    $('a[name=btnSaveEditContact]').attr('data-id', '');
    $('a[name=btnSaveEditContact]').addClass('hidden');
    $('a[name=btnCancelEditContact]').addClass('hidden');
    $('a[name=btnAddContact]').removeClass('hidden');

    $('select[name=contact_type]').val('E').trigger('change');
    $(':input[name=contact_value]').val('');
  });

  $(document).on('click', 'a[name=btnDeleteContact]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    modal.show();
    $('button[name=confirmDeleteContact]').attr('data-id', controlId);
  });

  $('button[name=confirmDeleteContact]').on('click', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id'),
          modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#modalDelete"));

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    itens[controlId]['main'] = false;
    itens[controlId]['insert'] = 'N';

    modal.hide();
    $(':input[name=arrContact]').val(JSON.stringify(itens));
    tableContact.find(`tr[data-id=${controlId}]`).html('');
  });

  $(document).on('click', 'input[name=E_contact], input[name=T_contact]', function(e) {
    e.preventDefault();

    const contactType = $(this).attr('name').split('_')[0],
          controlId = $(this).attr('data-id');

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    for(let i in itens) {
      if(i === controlId && itens[i].type === contactType) {
        itens[i]['main'] = true;
      } else if(itens[i].type === contactType) {
        itens[i]['main'] = false;
      }
    }

    $(':input[name=arrContact]').val(JSON.stringify(itens));

    tableContact.html('');
    for(let i in itens) {
      if(itens[i].insert == 'S') {
        tableContact.append(`
          <tr data-id="${i}">
              <td>
                ${
                  `<div class="form-check mt-2">
                    <input
                      class="form-check-input h-3"
                      type="radio"
                      name="${itens[i].type}_contact"
                      value="${itens[i].value}"
                      data-id="${i}"
                      ${itens[i].main ? 'checked' : ''}
                    >
                    <label class="form-check-label">${itens[i].main ? 'Principal' : '&nbsp;'}</label>
                  </div>`
                }
              </td>
              <td data-title="Contato">${itens[i].value}</td>
              <td data-title="Principal">${itens[i].type == 'E' ? 'E-mail' : 'Telefone'}</td>
              <td data-title="Status">${
                itens[i].active ?
                `<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`
                :
                `<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`
              }</td>
              <td class="space-x-4">
                <div class="flex gap-4 justify-center">
                  <a href="#" name="btnDeleteContact" data-id="${i}" title="Excluir o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#b91c1c">
                        <path d="M3 6h18"></path>
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnEditContact" data-id="${i}" title="Editar o endereço">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <g color="#4338ca">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                      </g>
                    </svg>
                  </a>

                  <a href="#" name="btnToggleActiveContact" data-id="${i}" title="${itens[i].active ? 'Desativar endereço': 'Ativar endereço'}">
                    ${
                      itens[i].active ?
                      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#b91c1c">
                          <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
                          <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
                          <path d="M12 2v4"></path>
                          <path d="m2 2 20 20"></path>
                        </g>
                      </svg>`
                      : `
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g color="#15803d">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </g>
                      </svg>
                      `
                    }
                  </a>
                </div>
              </td>
          </tr>
        `);
      }
    }
    $('a[name=btnSaveEditContact]').attr('data-id', '');
    $('a[name=btnSaveEditContact]').addClass('hidden');
    $('a[name=btnCancelEditContact]').addClass('hidden');
    $('a[name=btnAddContact]').removeClass('hidden');

    $('select[name=contact_type]').val('E').trigger('change');
    $(':input[name=contact_value]').val('');

  });

  $(document).on('click', 'a[name=btnToggleActiveContact]', function(e) {
    e.preventDefault();

    const controlId = $(this).attr('data-id');

    let itens = JSON.parse($(':input[name=arrContact]').val()),
        tableContact = $('#tableContact').find('tbody');

    itens[controlId]['active'] = !itens[controlId]['active'];

    $(':input[name=arrContact]').val(JSON.stringify(itens));

    if(itens[controlId]['active']) {
      tableContact.find(`tr[data-id=${controlId}]`).find('td').eq(3).html(`<span class="bg-green-200 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Ativo</span>`);
      $(this).attr('title', 'Desativar endereço');
      $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <g color="#b91c1c">
            <path d="M18.36 6.64A9 9 0 0 1 20.77 15"></path>
            <path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"></path>
            <path d="M12 2v4"></path>
            <path d="m2 2 20 20"></path>
          </g>
        </svg>
      `);
    } else {
      tableContact.find(`tr[data-id=${controlId}]`).find('td').eq(3).html(`<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Inativo</span>`);
      $(this).attr('title', 'Ativar endereço');
      $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <g color="#15803d">
            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
            <line x1="12" y1="2" x2="12" y2="12"></line>
          </g>
        </svg>
      `);
    }
  });
});

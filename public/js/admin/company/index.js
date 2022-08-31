// $(function($) {
jQuery(function($) {
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
      tableContact = $('#tableContact').find('tbody');

    if(!contactValue)
      showMessageBox('Obrigatório informar o contato', 'D', elmMessage, 'after');
  });
});
